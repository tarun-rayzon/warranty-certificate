<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

trait HasS3FileUrls
{
    public function getS3UrlFor($path, $minutes = 30)
    {
        if (!$path) {
            return null;
        }

        return Storage::disk('s3')->temporaryUrl($path, Carbon::now()->addMinutes($minutes));
    }
}
