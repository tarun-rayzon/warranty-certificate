<?php

namespace App\Models;

use App\Traits\HasS3FileUrls;
use Illuminate\Database\Eloquent\Model;

class WarrantyCertificate extends Model
{
    use HasS3FileUrls;

    protected $table = 'warranty_certificates';

    protected $fillable = [
        'warranty_request_id',
        'certificate_no',
        'pdf_path',
    ];

    protected $appends = [
        'warranty_certificate_file_url',
    ];

    // Relationships
    public function warrantyRequest()
    {
        return $this->belongsTo(WarrantyRequest::class);
    }

        public function getWarrantyCertificateFileUrlAttribute()
    {
        return $this->pdf_path ? $this->getS3UrlFor($this->pdf_path) : null;
    }
}
