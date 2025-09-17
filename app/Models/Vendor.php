<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $fillable = [
        'user_id',
        'business_name',
        'bio',
        'phone',
        'city',
        'state',
        'verification_status',
        'status', // ✅ Add this so it's mass-assignable
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    // app/Models/Vendor.php
    public function availability()
    {
        return $this->hasOne(\App\Models\VendorAvailability::class);
    }
}
