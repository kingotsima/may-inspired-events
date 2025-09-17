<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\VendorAvailability;

class VendorAvailabilityController extends Controller
{
    /**
     * Show the availability form.
     */
    public function index()
    {
        $vendor = Auth::user()->vendor; // Assuming a User hasOne Vendor

        // Load existing availability if exists
        $availability = $vendor ? $vendor->availability : null;

        return view('vendor.availability', compact('availability'));
    }

    /**
     * Save or update availability.
     */
    public function update(Request $request)
    {
        $request->validate([
            'available_days' => 'required|array|min:1',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'unavailable_dates' => 'nullable|array',
        ]);

        $vendor = Auth::user()->vendor;

        if (!$vendor) {
            return redirect()->route('vendor.dashboard')
                             ->with('error', 'Vendor account not found.');
        }

        // Either create new or update existing
        VendorAvailability::updateOrCreate(
            ['vendor_id' => $vendor->id],
            [
                'available_days' => $request->available_days, // array is cast automatically
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'unavailable_dates' => $request->unavailable_dates ?? [],
            ]
        );

        return redirect()->route('vendor.dashboard')
                         ->with('success', 'Availability updated successfully!');
    }
}
