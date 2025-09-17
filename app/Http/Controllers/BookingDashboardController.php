<?php

// app/Http/Controllers/BookingDashboardController.php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Booking;

class BookingDashboardController extends Controller
{
    // Client sees their bookings
    public function client()
    {
        $bookings = Booking::with('service.vendor')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('client.bookings.index', compact('bookings'));
    }

    // Vendor sees bookings for their services
    public function vendor()
    {
        $vendor = Auth::user()->vendor;
        $bookings = Booking::with('service','user')
            ->whereHas('service', function($q) use ($vendor) {
                $q->where('vendor_id', $vendor->id);
            })
            ->latest()
            ->paginate(10);

        return view('vendor.bookings.index', compact('bookings'));
    }
}
