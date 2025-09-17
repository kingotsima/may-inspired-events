<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorAvailability extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'available_days',   // corrected
        'start_time',
        'end_time',
        'unavailable_dates',
    ];

    // Cast JSON fields to arrays automatically
    protected $casts = [
        'available_days' => 'array',   // corrected
        'unavailable_dates' => 'array',
    ];
}
