<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'full_name', 'phone', 'email', 'password', 'role',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    // Role helpers
    public function isAdmin()     { return $this->role === 'admin'; }
    public function isCommittee() { return $this->role === 'committee'; }
    public function isCouple()    { return $this->role === 'couple'; }
    public function isVendor()    { return $this->role === 'vendor'; }

    public function canManage()
    {
        return in_array($this->role, ['admin', 'committee']);
    }

    // Relationships
    public function vendorProfile()
    {
        return $this->hasOne(Vendor::class, 'user_id');
    }

    // Relationships
    public function contributions()
    {
        return $this->hasMany(Contribution::class, 'contributor_id');
    }

    public function recordedContributions()
    {
        return $this->hasMany(Contribution::class, 'recorded_by');
    }

    public function events()
    {
        return $this->belongsToMany(Event::class, 'event_members', 'user_id', 'event_id')
                    ->withPivot('role')
                    ->withTimestamps();
    }
}
