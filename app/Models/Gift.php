<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gift extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id', 'donor_id', 'donor_name', 'donor_phone',
        'item_name', 'category', 'estimated_value',
        'description', 'status', 'received_by', 'received_at',
    ];

    protected $casts = [
        'estimated_value' => 'decimal:2',
        'received_at'     => 'datetime',
    ];

    public function event()      { return $this->belongsTo(Event::class); }
    public function donor()      { return $this->belongsTo(User::class, 'donor_id'); }
    public function receivedBy() { return $this->belongsTo(User::class, 'received_by'); }

    public function getDisplayDonorAttribute()
    {
        return $this->donor?->full_name ?? $this->donor_name ?? 'Unknown';
    }
}
