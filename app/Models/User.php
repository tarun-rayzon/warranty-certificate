<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasRoles;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    // Relationship with Reporting Manager (self-referencing relationship)
    public function reportingManager()
    {
        return $this->belongsTo(User::class, 'reporting_manager_id');
    }

    // Relationship with Subordinates
    public function subordinates()
    {
        return $this->hasMany(User::class, 'reporting_manager_id');
    }

    public function getSubordinateIds()
    {
        $subordinates = $this->subordinates()->with('subordinates')->get();

        $ids = $subordinates->pluck('id')->toArray();

        foreach ($subordinates as $subordinate) {
            $ids = array_merge($ids, $subordinate->getSubordinateIds());
        }

        return $ids;
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function getCreatedAtAttribute()
    {
        return date('d M, Y', strtotime($this->attributes['created_at']));
    }
}
