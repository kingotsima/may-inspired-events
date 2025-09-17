<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminEventBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_name',
        'event_date',
        'guests',
        'budget',
        'details',
        'status',
        'amount',
    ];

    protected $casts = [
        'event_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}


