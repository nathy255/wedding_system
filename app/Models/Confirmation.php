<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Confirmation extends Model
{
    protected $fillable = [
        'contribution_id', 'gift_id', 'sent_to_phone',
        'sent_to_email', 'sent_via', 'message_body', 'status',
    ];

    public function contribution() { return $this->belongsTo(Contribution::class); }
    public function gift()         { return $this->belongsTo(Gift::class); }
}
