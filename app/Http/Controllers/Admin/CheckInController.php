<?php

// app/Http/Controllers/Admin/CheckInController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;

class CheckInController extends Controller
{
    public function index()
    {
        return view('admin.checkin.index');
    }

    public function verify(Request $request)
    {
        $reference = $request->input('reference');
        $booking = Booking::where('reference',$reference)->first();

        if(!$booking) {
            return response()->json(['status'=>'error','message'=>'Invalid ticket']);
        }

        if($booking->checked_in) {
            return response()->json(['status'=>'error','message'=>'Already checked in']);
        }

        if($booking->status != 'paid') {
            return response()->json(['status'=>'error','message'=>'Unpaid booking']);
        }

        // mark checked-in
        $booking->update(['checked_in'=>true]);

        return response()->json(['status'=>'success','message'=>'Check-in successful','client'=>$booking->user->name]);
    }
}

