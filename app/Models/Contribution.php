<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contribution extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id', 'contributor_id', 'contributor_name', 'contributor_phone',
        'type', 'amount', 'payment_method', 'payment_reference',
        'status', 'recorded_by', 'confirmed_by', 'confirmed_at', 'notes',
    ];

    protected $casts = [
        'amount'       => 'decimal:2',
        'confirmed_at' => 'datetime',
    ];

    // Relationships
    public function event()        { return $this->belongsTo(Event::class); }
    public function contributor()  { return $this->belongsTo(User::class, 'contributor_id'); }
    public function recordedBy()   { return $this->belongsTo(User::class, 'recorded_by'); }
    public function confirmedBy()  { return $this->belongsTo(User::class, 'confirmed_by'); }
    public function confirmation() { return $this->hasOne(Confirmation::class); }

    // Scopes
    public function scopeConfirmed($q) { return $q->where('status', 'confirmed'); }
    public function scopePending($q)   { return $q->where('status', 'pending'); }
    public function scopeCash($q)      { return $q->where('type', 'cash'); }

    // Helpers
    public function getDisplayNameAttribute()
    {
        return $this->contributor?->full_name ?? $this->contributor_name ?? 'Unknown';
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'confirmed' => 'green',
            'pending'   => 'amber',
            'rejected'  => 'red',
            default     => 'gray',
        };
    }
}
