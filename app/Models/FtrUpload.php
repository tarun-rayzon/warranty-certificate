<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FtrUpload extends Model
{
    protected $table = 'ftr_uploads';

    protected $fillable = [
        'original_name',
        'path',
        'rows_parsed',
        'uploaded_by',
    ];

    // Relationship
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function serialNumbers()
    {
        return $this->hasMany(SerialNumber::class);
    }
}
