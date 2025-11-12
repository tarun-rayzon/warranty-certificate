<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarrantyRequest extends Model
{
    protected $table = 'warranty_requests';

    protected $fillable = [
        'customer_id',
        'invoice_no',
        'invoice_file_path',
        'purchase_date',
        'status',
        'qc_approved_by',
        'qc_approved_at',
        'qc_reject_reason',
    ];

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
}
