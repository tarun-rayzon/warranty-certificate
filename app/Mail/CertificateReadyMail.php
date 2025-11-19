<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CertificateReadyMail extends Mailable
{
    use Queueable, SerializesModels;

    public $customer;
    public $certificateNo;
    public $downloadPath;

    /**
     * Create a new message instance.
     */
    public function __construct($customer, $certificateNo, $downloadPath)
    {
        $this->customer = $customer;
        $this->certificateNo = $certificateNo;
        $this->downloadPath = $downloadPath;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Warranty Certificate is Ready',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.certificate-ready',
            with: [
                'customer'       => $this->customer,
                'certificateNo'  => $this->certificateNo,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {

        return [
            Attachment::fromStorageDisk('s3', $this->downloadPath)
            ->as('Warranty-Certificate.pdf')
            ->withMime('application/pdf')
        ];
    }
}
