<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\WarrantyRequest;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CustomerDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('temp.auth');
    }

    /**
     * Dashboard
     */
    public function index()
    {
        $email = session('temp_auth_email');
        abort_unless($email, 401);

        $customer = Customer::where('email', $email)->firstOrFail();

        // Base query (no withCount, no eager loads)
        $baseQuery = WarrantyRequest::where('customer_id', $customer->id);

        // Get aggregated counts from the base query
        $count = (clone $baseQuery)->selectRaw('
            COUNT(*) as count,
            SUM(CASE WHEN status = "pending_qc" THEN 1 ELSE 0 END) as pending,
            SUM(CASE WHEN status = "approved" THEN 1 ELSE 0 END) as approved,
            SUM(CASE WHEN status = "rejected" THEN 1 ELSE 0 END) as rejected
        ')->first()->toArray();

        // Now build the paginated requests with withCount and eager loads
        $requests = $baseQuery
            ->with(['certificate'])
            ->withCount('items')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // return view / inertia
        return Inertia::render('WarrantyDashboard/Index', [
            'requests' => $requests,
            'count' => $count,
        ]);
    }

    /**
     * View Warranty Request
     */
    public function show($id)
    {
        $email = session('temp_auth_email');
        abort_unless($email, 401);

        $customer = Customer::where('email', $email)->firstOrFail();

        $request = WarrantyRequest::with(['items', 'certificate'])->where('customer_id', $customer->id)->findOrFail($id);

        return Inertia::render('WarrantyDashboard/Show', [
            'request' => $request,
        ]);
    }

    /**
     * Logout
     */
    public function logout()
    {
        session()->forget('temp_auth_email');
        return to_route('public.request.create');
    }
}
