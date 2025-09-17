<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id','service_id','amount','status','reference','type'
    ];

    public function service() {
        return $this->belongsTo(Service::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    // ✅ Keep only one event() method
    public function event() {
        return $this->belongsTo(Event::class);
    }
}
