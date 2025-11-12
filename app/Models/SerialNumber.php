<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SerialNumber extends Model
{
    protected $table = 'serial_numbers';

    protected $fillable = [
        'serial',
        'pallet_id',
        'ftr_upload_id',
        'status',
    ];

    // Relationship
    public function ftrFile()
    {
        return $this->belongsTo(FtrUpload::class);
    }
}
