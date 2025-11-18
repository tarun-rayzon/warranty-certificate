<?php

namespace App\Http\Controllers;

use App\Models\WarrantyRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QcApprovalController extends Controller
{
    private $user;

    public function __construct()
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
    public function index(Request $request)
    {
        if (!$this->user->hasPermissionTo('warranty.view')) {
            abort(403, 'Unauthorized action.');
        }

        $filters = [
            'search' => $request->get('search', ''),
            'status' => $request->get('status', ''),
        ];

        $warranty_requests = WarrantyRequest::query()
            ->when($filters['search'], function ($query, $search) {
                $query->where('request_id', 'like', '%' . $search . '%')
                    ->orWhereHas('customer', function ($query) use ($search) {
                        $query->where('name', 'like', '%' . $search . '%')
                            ->orWhere('phone', 'like', '%' . $search . '%')
                            ->orWhere('email', 'like', '%' . $search . '%');
                    });
            })
            ->when($filters['status'], function ($query, $status) {
                $query->where('status', $status);
            })
            ->with(['customer:id,name,phone,email', 'certificate'])
            ->orderBy('created_at', 'desc');

        $count = (clone $warranty_requests)->selectRaw('
            count(id) as count,
            SUM(CASE WHEN status = "pending_qc" THEN 1 ELSE 0 END) as pending,
            SUM(CASE WHEN status = "approved" THEN 1 ELSE 0 END) as approved,
            SUM(CASE WHEN status = "rejected" THEN 1 ELSE 0 END) as rejected
        ')->first()->toArray();

        $warranty_requests = $warranty_requests
            ->withCount('items')
            ->paginate(10);

        return Inertia::render('Request/Index', [
            'warranty_requests' => $warranty_requests,
            'count' => $count,
            'filters' => $filters
        ]);
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        if (!$this->user->hasPermissionTo('warranty.view')) {
            abort(403, 'Unauthorized action.');
        }

        $warranty_request = WarrantyRequest::with(['customer', 'items', 'certificate'])->findOrFail($id);

        return Inertia::render('Request/Show', [
            'request' => $warranty_request,
        ]);
    }
}
