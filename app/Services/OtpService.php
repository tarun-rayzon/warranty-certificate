<?php

namespace App\Services;

use App\Models\EmailOtp;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class OtpService
{
    protected int $expiryMinutes = 10;
    protected int $length = 6;

    /**
     * Generate & send OTP
     */
    public function send(string $email)
    {
        // Prevent spamming (1 OTP/min)
        $existing = EmailOtp::where('email', $email)
            ->where('created_at', '>', now()->subMinute())
            ->first();

        if ($existing) {
            return back()->withErrors('otp', 'Wait a minute before requesting again');
        }

        $code = random_int(100000, 999999);

        EmailOtp::where('email', $email)->delete(); // clear old ones
        EmailOtp::create([
            'email'      => $email,
            'code_hash'  => Hash::make($code),
            'expires_at' => now()->addMinutes($this->expiryMinutes),
        ]);

        // ✉️ send via mail
        Mail::to($email)->send(new \App\Mail\SendOtpMail($code));
    }

    /**
     * Verify OTP
     */
    public function verify(string $email, string $code): bool
    {
        $otp = EmailOtp::where('email', $email)->latest()->first();

        if (! $otp) {
            return false;
        }

        // expired
        if (Carbon::parse($otp->expires_at)->isPast()) {
            $otp->delete();
            return false;
        }

        // max 5 attempts
        if ($otp->attempts >= 5) {
            $otp->delete();
            return false;
        }

        $otp->increment('attempts');

        if (Hash::check($code, $otp->code_hash)) {
            $otp->delete(); // one-time use
            return true;
        }

        return false;
    }
}
