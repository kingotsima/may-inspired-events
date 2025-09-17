<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminEventBooking;
use App\Models\User;
use App\Notifications\AdminEventBookingStatus;


class AdminEventBookingController extends Controller
{
    // Show form for admin to create a booking
    public function create()
    {
        $users = User::all();
        return view('admin_booking.create', compact('users'));
    }

    // Store booking created by admin
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'    => 'required|exists:users,id',
            'event_name' => 'required|string|max:255',
            'event_date' => 'required|date',
            'guests'     => 'nullable|integer|min:1',
            'budget'     => 'nullable|numeric|min:0',
        ]);

        AdminEventBooking::create([
            'user_id' => $request->user_id,
            'event_name' => $request->event_name,
            'event_date' => $request->event_date,
            'guests'     => $request->guests,
            'budget'     => $request->budget,
            'details'    => $request->details,
            'status'     => 'pending',
            'amount'     => $request->amount ?? 0, // or derive from budget
        ]);
        

        return redirect()->route('admin.dashboard')
                         ->with('success', 'Admin event booking created successfully!');
    }

    public function index()
    {
        $bookings = AdminEventBooking::with('user')->latest()->paginate(15);
        return view('admin_booking.index', compact('bookings'));
    }

    public function show(AdminEventBooking $booking)
    {
        return view('admin_booking.show', compact('booking'));
    }

    public function approve(AdminEventBooking $booking)
    {
        $booking->update(['status' => 'approved']);

        // Send notification to user
        if ($booking->user) {
            $booking->user->notify(new AdminEventBookingStatus($booking));
        }

        return back()->with('success', 'Booking approved successfully!');
    }

    public function reject(AdminEventBooking $booking)
    {
        $booking->update(['status' => 'rejected']);

        // Send notification to user
        if ($booking->user) {
            $booking->user->notify(new AdminEventBookingStatus($booking));
        }

        return back()->with('success', 'Booking rejected successfully!');
    }



}
