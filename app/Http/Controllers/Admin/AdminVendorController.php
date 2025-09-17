<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vendor;
use Illuminate\Http\Request;

class AdminVendorController extends Controller
{
    public function index()
    {
        $vendors = Vendor::with('user')->latest()->paginate(10);
        return view('admin.vendors.index', compact('vendors'));
    }

    public function approve(Vendor $vendor)
    {
        $vendor->update([
            'status' => 'approved',
            'verification_status' => 'approved'
        ]);

        // ✅ Assign Vendor role to the related user
        if ($vendor->user && !$vendor->user->hasRole('Vendor')) {
            $vendor->user->assignRole('Vendor');
        }

        return back()->with('success','Vendor approved successfully and role assigned!');
    }

    public function reject(Vendor $vendor)
    {
        $vendor->update([
            'status' => 'rejected',
            'verification_status' => 'rejected'
        ]);

        // ❌ Remove Vendor role if assigned
        if ($vendor->user && $vendor->user->hasRole('Vendor')) {
            $vendor->user->removeRole('Vendor');
        }

        return back()->with('success','Vendor rejected and role removed successfully!');
    }

    public function suspend(Vendor $vendor)
    {
        $vendor->update([
            'status' => 'suspended',
            'verification_status' => 'suspended'
        ]);

        // ❌ Remove Vendor role so navbar links disappear
        if ($vendor->user && $vendor->user->hasRole('Vendor')) {
            $vendor->user->removeRole('Vendor');
        }

        return back()->with('success','Vendor suspended and role removed successfully!');
    }

    public function restore(Vendor $vendor)
    {
        $vendor->update([
            'status' => 'approved',
            'verification_status' => 'approved'
        ]);

        // ✅ Re-assign Vendor role
        if ($vendor->user && !$vendor->user->hasRole('Vendor')) {
            $vendor->user->assignRole('Vendor');
        }

        return back()->with('success','Vendor restored successfully and role re-assigned!');
    }
}
