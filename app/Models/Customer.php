<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'customers';

    protected $fillable = [
        'email',
        'name',
        'phone',
        'last_purchase_date',
        'address',
        'city',
        'state',
        'pincode',
    ];
}
