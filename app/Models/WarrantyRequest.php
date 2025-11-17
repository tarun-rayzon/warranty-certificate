<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarrantyRequest extends Model
{
    protected $table = 'warranty_requests';

    protected $fillable = [
        'request_id',
        'customer_id',
        'invoice_no',
        'invoice_file_path',
        'purchase_date',
        'status',
        'qc_approved_by',
        'qc_approved_at',
        'qc_reject_reason',
    ];

    protected $appends = ['status_label', 'status_badge'];

    // Relationship
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(WarrantyRequestItem::class);
    }

    public function certificate()
    {
        return $this->hasOne(WarrantyCertificate::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    //
    public function getCreatedAtAttribute($value)
    {
        return date('d-m-Y', strtotime($value));
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending_verification' => 'Pending Verification',
            'pending_qc'           => 'Pending QC',
            'approved'             => 'Approved',
            'rejected'             => 'Rejected',
        ];

        return $labels[$this->status] ?? 'Unknown';
    }

    public function getStatusBadgeAttribute()
    {
        $labels = [
            'pending_verification' => 'warning',
            'pending_qc'           => 'warning',
            'approved'             => 'success',
            'rejected'             => 'danger',
        ];

        return $labels[$this->status] ?? 'warning';
    }
}
