<?php

namespace App\Jobs;

use App\Mail\CertificateReadyMail;
use App\Models\WarrantyCertificate;
use App\Models\WarrantyRequest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;

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
        // Local logo file (super fast — recommended)
        $logoPath = public_path('image/header-logo.png');
        $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));

        // Using Snappy (wkhtmltopdf)
        $pdf = PDF::loadView('pdf.certificate', [
            'req' => $req,
            'certificateNo' => $certificateNo,
            'issuedAt' => now()->toDateString(),
            'logoBase64' => $logoBase64,
        ])
        ->setPaper('a4')
        ->setOption('margin-top', '5mm')
        ->setOption('margin-bottom', '10mm')
        ->setOption('margin-left', '5mm')
        ->setOption('margin-right', '5mm')
        ->setOption('enable-local-file-access', true)
        ->setOption('dpi', 120)
        ->setOption('print-media-type', true);

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
