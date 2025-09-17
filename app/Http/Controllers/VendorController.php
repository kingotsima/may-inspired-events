<?php

namespace App\Http\Controllers; // NOT Admin

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorController extends Controller
{

    public function index()
    {
        // Show only approved vendors
        $vendors = \App\Models\Vendor::where('status', 'approved')->paginate(10);

        return view('vendors.index', compact('vendors'));
    }

    public function show(Vendor $vendor)
    {
        if ($vendor->status !== 'approved') {
            abort(404);
        }

        // Load the vendor's availability (relationship)
        $availability = $vendor->availability;

        return view('vendors.show', compact('vendor', 'availability'));
    }


    public function create() {
        return view('vendor.create');
    }

    public function store(Request $request) {
        $request->validate([
            'business_name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'phone' => 'required|string|max:20',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
        ]);
    
        $vendor = Vendor::create([
            'user_id' => Auth::id(),
            'business_name' => $request->business_name,
            'bio' => $request->bio,
            'phone' => $request->phone,
            'city' => $request->city,
            'state' => $request->state,
            'status' => 'pending',
        ]);

        return redirect('/')
            ->with('success','Your vendor application has been submitted. Please wait for admin approval.');
    }

//To Edit Vendor Profiles
    public function edit()
    {
        $vendor = Vendor::where('user_id', Auth::id())->firstOrFail();
        return view('vendor.profile.edit', compact('vendor'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'business_name' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'phone' => 'required|string|max:20',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
        ]);

        $vendor = Vendor::where('user_id', Auth::id())->firstOrFail();

        $vendor->update([
            'business_name' => $request->business_name,
            'bio' => $request->bio,
            'phone' => $request->phone,
            'city' => $request->city,
            'state' => $request->state,
        ]);

        return redirect()->route('vendor.dashboard')->with('success', 'Profile updated successfully.');
    }

    //To show a particular Vendors services
    public function services($id)
    {
        $vendor = Vendor::with('services')->findOrFail($id);

        // Paginate services (6 per page)
        $services = $vendor->services()->paginate(6);

        return view('vendors.services', compact('vendor', 'services'));
    }



}
