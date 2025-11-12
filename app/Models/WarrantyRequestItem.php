<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarrantyRequestItem extends Model
{
    protected $table = 'warranty_request_items';

    protected $fillable = [
        'warranty_request_id',
        'serial',
        'verification_state',
        'serial_number_id',
    ];

    // Relationships
    public function serialNumber()
    {
        return $this->belongsTo(SerialNumber::class);
    }

    public function warrantyRequest()
    {
        return $this->belongsTo(WarrantyRequest::class);
    }
}
