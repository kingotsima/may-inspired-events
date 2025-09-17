<?php

// app/Models/Service.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'vendor_id',
        'category_id',
        'title',
        'description',
        'base_price',
        'price_unit',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // ✅ Relationship with images
    public function images()
    {
        return $this->hasMany(ServiceImage::class);
    }
}

