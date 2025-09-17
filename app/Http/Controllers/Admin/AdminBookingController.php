<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class AdminBookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user','service.vendor']);

        // Optional filters
        if ($request->filled('user')) {
            $query->whereHas('user', fn($q) => 
                $q->where('name','like','%'.$request->user.'%')
            );
        }
        if ($request->filled('vendor')) {
            $query->whereHas('service.vendor', fn($q) => 
                $q->where('business_name','like','%'.$request->vendor.'%')
            );
        }
        if ($request->filled('status')) {
            $query->where('status',$request->status);
        }

        $bookings = $query->latest()->paginate(15)->withQueryString();

        return view('admin.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        return view('admin.bookings.show', compact('booking'));
    }

    public function adminBookings(Request $request)
    {
        $query = Booking::with(['user','service.vendor'])
            ->where('type', 'admin_event');

        // Extra filters
        if ($request->filled('user')) {
            $query->whereHas('user', fn($q) => 
                $q->where('name','like','%'.$request->user.'%')
            );
        }
        if ($request->filled('vendor')) {
            $query->whereHas('service.vendor', fn($q) => 
                $q->where('business_name','like','%'.$request->vendor.'%')
            );
        }
        if ($request->filled('status')) {
            $query->where('status',$request->status);
        }

        $bookings = $query->latest()->paginate(15)->withQueryString();

        return view('admin.bookings.admin_bookings', compact('bookings'));
    }

    public function approve(Booking $booking)
    {
        if ($booking->type !== 'admin_event') {
            abort(403, 'Unauthorized action.');
        }

        $booking->update(['status' => 'approved']);

        return back()->with('success','Booking approved successfully!');
    }

    public function reject(Booking $booking)
    {
        if ($booking->type !== 'admin_event') {
            abort(403, 'Unauthorized action.');
        }

        $booking->update(['status' => 'rejected']);

        return back()->with('success','Booking rejected successfully!');
    }

    public function showAdminBooking(Booking $booking)
    {
        if ($booking->type !== 'admin_event') {
            abort(403, 'Unauthorized action.');
        }

        $details = json_decode($booking->details, true);

        return view('admin.bookings.admin_booking_show', compact('booking', 'details'));
    }
}
