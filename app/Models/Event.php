<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'couple_name', 'bride_name', 'groom_name',
        'wedding_date', 'venue', 'target_budget',
        'description', 'created_by', 'is_active',
    ];

    protected $casts = [
        'wedding_date'  => 'date',
        'target_budget' => 'decimal:2',
        'is_active'     => 'boolean',
    ];

    // Relationships
    public function contributions()
    {
        return $this->hasMany(Contribution::class);
    }

    public function gifts()
    {
        return $this->hasMany(Gift::class);
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'event_members', 'event_id', 'user_id')
                    ->withPivot('role')
                    ->withTimestamps();
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Accessors
    public function getTotalConfirmedAttribute()
    {
        return $this->contributions()->where('status', 'confirmed')->sum('amount');
    }

    public function getTotalPendingAttribute()
    {
        return $this->contributions()->where('status', 'pending')->sum('amount');
    }

    public function getProgressPercentAttribute()
    {
        if ($this->target_budget <= 0) return 0;
        return min(100, round(($this->total_confirmed / $this->target_budget) * 100));
    }

    public function getDaysToGoAttribute()
    {
        return now()->diffInDays($this->wedding_date, false);
    }
}
