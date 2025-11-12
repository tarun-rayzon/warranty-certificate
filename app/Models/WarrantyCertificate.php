<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarrantyCertificate extends Model
{
    protected $table = 'warranty_certificates';

    protected $fillable = [
        'warranty_request_id',
        'certificate_no',
        'pdf_path',
    ];

    // Relationships
    public function warrantyRequest()
    {
        return $this->belongsTo(WarrantyRequest::class);
    }
}
