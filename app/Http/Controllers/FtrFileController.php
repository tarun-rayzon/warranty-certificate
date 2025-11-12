<?php

namespace App\Http\Controllers;

use App\Models\FtrUpload;
use App\Models\SerialNumber;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Facades\Excel;

class FtrFileController extends Controller
{
    private $user;

    public function __construct(Request $request)
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $this->user = $request->user(); // This will be executed after the 'auth' middleware

            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ftr_files = FtrUpload::query()
            ->with('uploader:id,name')
            ->paginate(10);

        return Inertia::render('FTR/Index', [
            'ftr_files' => $ftr_files
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // if(!$this->user->hasPermissionTo('ftr-files.create')) {
        //     abort(403, 'Unauthorized action.');
        // }

        $request->validate([
            'ftr_file' => 'required|mimes:csv,xlsx,xls',
        ]);

        DB::beginTransaction();

        try {
            $checkExistingFile = FtrUpload::where('original_name', $request->file('ftr_file')->getClientOriginalName())->first();

            if ($checkExistingFile) {
                return back()->with('error', 'File already exists.');
            }

            // ✅ 1. Create upload record first
            $upload = FtrUpload::create([
                'uploaded_by'   => auth()->id(),
                'original_name' => $request->file('ftr_file')->getClientOriginalName(),
                'path'          => '', // temporary, update after parsing
                'rows_parsed'   => 0,
            ]);

            $tempFile = $request->file('ftr_file')->storeAs('temp', time() . '.' . $request->file('ftr_file')->getClientOriginalExtension());

            Excel::import(new class($upload) implements ToCollection {
                public function __construct(private FtrUpload $upload) {}
                public function collection(Collection $rows)
                {
                    $inserts = [];
                    $rowCount = 0;

                    // Skip the header and start from row 2
                    foreach ($rows->skip(5) as $row) {
                        $serial = strtoupper(trim((string)($row[3] ?? '')));
                        $pallet_id = strtoupper(trim((string)($row[2] ?? '')));

                        if (! $serial) continue;

                        $inserts[$serial] = [
                            'serial' => $serial,
                            'pallet_id' => $pallet_id,
                            'ftr_upload_id' => $this->upload->id,
                            'status' => 'available',
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];

                        $rowCount++;
                    }
                    // ✅ Efficient upsert
                    SerialNumber::upsert(
                        array_values($inserts),
                        ['serial'],
                        ['pallet_id'],
                        ['ftr_upload_id', 'updated_at']
                    );

                    $this->upload->update(['rows_parsed' => $rowCount]);
                }
            }, storage_path('app/' . $tempFile));

            // ✅ now upload to s3
            $s3Path  = optimize_and_upload_image($request->file('ftr_file'), 'documents/ftr');
            $upload->update(['path' => $s3Path]);

            DB::commit();

            // ✅ delete temp file
            @unlink(storage_path('app/' . $tempFile));

            return back()->with('success', 'File uploaded successfully.');
        } catch (\Throwable $th) {
            dd($th->getMessage());
            //throw $th;
            DB::rollBack();
            return back()->with('error', 'Something went wrong while uploading the file.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        // if (!$this->user->hasPermissionTo('ftr-files.view')) {
        //     abort(403, 'Unauthorized action.');
        // }
        $filters = [
            'search' => $request->get('search', ''),
        ];

        $ftr_file = FtrUpload::with(['uploader:id,name'])->findOrFail($id);

        $serial_numbers = SerialNumber::where('ftr_upload_id', $id)
            ->when($filters['search'], function ($query, $search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('serial', 'like', '%' . $search . '%')
                        ->orWhere('pallet_id', 'like', '%' . $search . '%');
                });
            })
            ->paginate(10);

        $serial_numbers->appends(request()->query());

        return Inertia::render('FTR/Show', [
            'ftr_file' => $ftr_file,
            'serial_numbers' => $serial_numbers,
            'filters' => $filters
        ]);
    }

    /**
     * Delete the specified resource.
     */
    public function destroy(string $id)
    {
        // if(!$this->user->hasPermissionTo('ftr-files.delete')) {
        //     abort(403, 'Unauthorized action.');
        // }

        $ftr_file = FtrUpload::findOrFail($id);

        try {
            Storage::disk('s3')->delete($ftr_file->path);

            $ftr_file->serialNumbers()->delete();
            $ftr_file->delete();

            return back()->with('success', 'File deleted successfully.');
        } catch (\Throwable $th) {
            return back()->with('error', 'Something went wrong while deleting the file.');
        }
    }
}
