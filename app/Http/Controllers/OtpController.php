<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\WarrantyRequest;
use App\Services\OtpService;
use Illuminate\Http\Request;

class OtpController extends Controller
{
    public function send(Request $r)
    {
        $email = strtolower(trim($r->input('email')));

        try {
            app(OtpService::class)->send($email);

            return back();
        } catch (\Throwable $th) {
            return back()->withErrors('otp', $th->getMessage());
        }
    }

    public function verify(Request $r)
    {
        $r->validate([
            'email' => 'required|email',
            'code'  => 'required|string|size:6'
        ]);

        $email = strtolower(trim($r->input('email')));

        $code  = trim($r->input('code'));

        try {
            if (! app(OtpService::class)->verify($email, $code)) {
                return back()->withErrors('otp', 'Invalid or expired OTP');
            }

            // Mark request now visible in dashboard + begin QC stage
            WarrantyRequest::where('customer_id', Customer::where('email', $email)->value('id'))
                ->where('status', 'pending_verification')
                ->update(['status' => 'pending_qc']);

            // create temporary session
            session(['temp_auth_email' => $email]);

            return to_route('customer.dashboard');
        } catch (\Throwable $th) {
            return back()->withErrors('otp', $th->getMessage());
        }
    }
}
