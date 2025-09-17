<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'date',
        'location',
        'price',
    ];

    // App\Models\Event.php
    protected $dates = ['event_date']; // ensures Carbon can handle it


    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
