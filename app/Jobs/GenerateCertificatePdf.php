<?php

namespace App\Jobs;

use App\Mail\CertificateReadyMail;
use App\Models\WarrantyCertificate;
use App\Models\WarrantyRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class GenerateCertificatePdf implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public int $requestId)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $req = WarrantyRequest::with(['customer', 'items'])->findOrFail($this->requestId);

        $certificateNo = $this->generateCertificateNo();

        $pdf = Pdf::loadView('pdf.certificate', [
            'req' => $req,
            'certificateNo' => $certificateNo,
            'issuedAt' => now()->toDateString(),
        ])->setPaper('a4');

        $path = "certificates/{$certificateNo}.pdf";

        Storage::disk('s3')->put($path, $pdf->output());

        $warranty = WarrantyCertificate::create([
            'warranty_request_id' => $req->id,
            'certificate_no' => $certificateNo,
            'pdf_path' => $path,
        ]);

        // notify customer with download link
        Mail::to($req->customer->email)->send(new CertificateReadyMail($req->customer, $certificateNo, $path));
    }

    // Generate request number
    public function generateCertificateNo()
    {
        return DB::transaction(function () {
            $today = date('Ymd');

            $latestCert = WarrantyCertificate::where('certificate_no', 'like', 'RZ-' . $today . '-%')
                ->lockForUpdate() // ⬅ lock rows for this transaction
                ->latest('id')
                ->first();

            $nextNumber = $latestCert
                ? intval(substr($latestCert->certificate_no, -4)) + 1
                : 1;

            return 'RZ-' . $today . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);
        });
    }
}
