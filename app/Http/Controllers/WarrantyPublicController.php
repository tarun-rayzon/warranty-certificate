<?php

namespace App\Http\Controllers;

use App\Http\Requests\WarrantyRequestStore;
use App\Jobs\VerifyRequestSerials;
use App\Models\Customer;
use App\Models\SerialNumber;
use App\Models\WarrantyRequest;
use App\Models\WarrantyRequestItem;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class WarrantyPublicController extends Controller
{
    public function create()
    {
        return Inertia::render('Warranty/Index', []);
    }

    public function submit(WarrantyRequestStore $request)
    {
        // normalize serials array
        $serials = collect(explode(',', $request->serial_no))
            ->map(fn($s) => strtoupper(trim($s)))
            ->filter()
            ->unique();

        try {
            // find or create customer by email
            DB::transaction(function () use ($request, $serials) {
                $customer = Customer::updateOrCreate(
                    ['email' => $request->email],
                    [
                        'name' => $request->name,
                        'phone' => $request->phone,
                        'last_purchase_date' => $request->purchase_date,
                        'address' => $request->address,
                        'city' => $request->city,
                        'state' => $request->state,
                        'pincode' => $request->pincode,
                    ]
                );

                $path = null;
                if ($request->hasFile('invoice')) {
                    $path = $request->file('invoice')->store('invoices');
                }

                $wr = WarrantyRequest::create([
                    'request_id' => $this->generateRqNo(),
                    'customer_id' => $customer->id,
                    'invoice_no'  => $request->invoice_no,
                    'invoice_file_path' => $path ?? null,
                    'purchase_date' => $request->purchase_date,
                    'status' => 'pending_verification',
                ]);

                $items = $serials->map(fn($serial) => [
                    'warranty_request_id' => $wr->id,
                    'serial' => $serial,
                    'created_at' => now(),
                    'updated_at' => now(),
                ])->values()->all();

                WarrantyRequestItem::insert($items);

                // Dispatch Job for serial verification
                dispatch(new VerifyRequestSerials($wr->id));

                // send OTP (create code, hash, email notification)
                app(OtpService::class)->send($request->email);

                return back();
            });
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Something went wrong while submitting the request.');
        }
    }

    public function checkSerial(Request $r)
    {
        $r->validate([
            'serial_no' => 'required|string'
        ]);

        $serials = collect(explode(',', $r->serial_no))
            ->map(fn($s) => strtoupper(trim($s)))
            ->filter()
            ->unique();
        $found = SerialNumber::whereIn('serial', $serials)->pluck('serial')->toArray();

        $invalid = $serials->diff($found)->values()->all();

        if (!empty($invalid)) {
            return back()->withErrors([
                'serial_no' => 'Invalid serial numbers: ' . implode(', ', $invalid)
            ]);
        }

        if (empty($invalid)) {
            return back();
        }
    }

    // Generate request number
    public function generateRqNo()
    {
        return DB::transaction(function () {
            $today = date('Ymd');

            $latestRq = WarrantyRequest::where('request_id', 'like', 'WR-' . $today . '-%')
                ->lockForUpdate() // ⬅ lock rows for this transaction
                ->latest('id')
                ->first();

            $nextNumber = $latestRq
                ? intval(substr($latestRq->request_id, -4)) + 1
                : 1;

            return 'WR-' . $today . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        });
    }
}
