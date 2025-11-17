<?php

namespace App\Jobs;

use App\Models\SerialNumber;
use App\Models\WarrantyRequest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class VerifyRequestSerials implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(public int $warrantyRequestId)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $req = WarrantyRequest::with('items')->findOrFail($this->warrantyRequestId);

        foreach ($req->items as $item) {
            $sn = SerialNumber::where('serial', $item->serial)->first();

            if (! $sn) {
                $item->update(['verification_state' => 'not_found']);
                continue;
            }

            if ($sn->status === 'available') {
                $item->update([
                    'verification_state' => 'verified',
                    'serial_number_id' => $sn->id
                ]);
            } else {
                $item->update([
                    'verification_state' => 'already_consumed',
                    'serial_number_id' => $sn->id
                ]);
            }
        }
    }
}
