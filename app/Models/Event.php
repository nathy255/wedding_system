<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'event_date', 'event_type', 'venue', 'target_budget',
        'description', 'banner_image', 'created_by', 'is_active',
    ];

    protected $casts = [
        'event_date'  => 'date',
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

    public function tasks()
    {
        return $this->hasMany(Task::class);
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
        return (int) round(now()->diffInDays($this->event_date, false));
    }

    // Backwards Compatibility for Old Views during migration phase
    public function getCoupleNameAttribute()
    {
        return $this->name;
    }

    public function getWeddingDateAttribute()
    {
        return $this->event_date;
    }
}
