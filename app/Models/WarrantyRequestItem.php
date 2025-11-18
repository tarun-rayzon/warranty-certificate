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

    protected $appends = [
        'status_label',
        'status_badge',
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

    // Accessors
    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending'            => 'Pending',
            'verified'           => 'Verified',
            'not_found'          => 'Not Found',
            'already_consumed'   => 'Already Consumed',
            'invalid'            => 'Invalid',
        ];

        return $labels[$this->verification_state] ?? 'Unknown';
    }

    public function getStatusBadgeAttribute()
    {
        $labels = [
            'pending'            => 'warning',
            'verified'           => 'success',
            'not_found'          => 'dark',
            'already_consumed'   => 'danger',
            'invalid'            => 'danger',
        ];

        return $labels[$this->verification_state] ?? 'warning';
    }
}
