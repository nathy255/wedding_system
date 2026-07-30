<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id', 'name', 'category', 'location', 'starting_price', 
        'rating', 'review_count', 'cover_image', 'description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
