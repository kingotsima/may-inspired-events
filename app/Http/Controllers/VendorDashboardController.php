<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\VendorAvailability;

class VendorDashboardController extends Controller
{
    public function index()
    {
        $vendor = Auth::user()->vendor; // assuming User hasOne Vendor
        $availability = null;

        if ($vendor) {
            $availability = VendorAvailability::where('vendor_id', $vendor->id)->first();
            // ✅ Do NOT decode JSON manually, Eloquent will cast to array
        }

        $recentActivities = [];

        return view('vendor.dashboard', compact('availability', 'recentActivities'));
    }
}
