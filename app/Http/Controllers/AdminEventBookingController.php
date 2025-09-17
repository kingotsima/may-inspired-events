<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminEventBooking;
use Illuminate\Support\Facades\Auth;

class AdminEventBookingController extends Controller
{
    // Show booking form for client
    public function create()
    {
        return view('admin_booking.event_form');
    }

    // Store booking for client
    public function store(Request $request)
    {
        $request->validate([
            'event_name' => 'required|string|max:255',
            'event_date' => 'required|date',
            'guests'     => 'nullable|integer|min:1',
            'budget'     => 'nullable|numeric|min:0',
        ]);

        AdminEventBooking::create([
            'user_id'    => Auth::id(),
            'event_name' => $request->event_name,
            'event_date' => $request->event_date,
            'guests'     => $request->guests,
            'budget'     => $request->budget,
            'details'    => $request->details,
            'status'     => 'pending',
            'amount'     => $request->amount ?? 0, // or derive from budget
        ]);
        

        return redirect()->route('client.dashboard')
                         ->with('success', 'Admin event booking submitted!');
    }
}
