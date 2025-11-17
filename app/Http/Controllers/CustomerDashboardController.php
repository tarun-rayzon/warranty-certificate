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

        $requests = WarrantyRequest::with(['certificate', 'items'])
            ->where('customer_id', $customer->id);

        $count = (clone $requests)->selectRaw('
            count(id) as count,
            SUM(CASE WHEN status = "pending_qc" THEN 1 ELSE 0 END) as pending,
            SUM(CASE WHEN status = "approved" THEN 1 ELSE 0 END) as approved,
            SUM(CASE WHEN status = "rejected" THEN 1 ELSE 0 END) as rejected
        ')->first()->toArray();

        $requests = $requests->paginate(10);

        return Inertia::render('WarrantyDashboard/Index', [
            'requests' => $requests,
            'count' => $count
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
