<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use App\Models\ServiceImage;

class VendorServiceController extends Controller
{
    public function index()
    {
        $services = Auth::user()->vendor->services;
        return view('vendor.services.index', compact('services'));
    }

    public function create()
    {
        return view('vendor.services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'base_price'  => 'required|numeric|min:0',
            'price_unit'  => 'required|string|max:50',
            'category_id' => 'required|exists:categories,id',
            'images.*'    => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $data = $request->only(['title','description','base_price','price_unit','category_id']);
        $data['vendor_id'] = Auth::user()->vendor->id;

        $service = Service::create($data);

        // Handle multiple images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('services', 'public'); // stores in storage/app/public/services
                $service->images()->create(['filename' => $path]);                
            }
        }

        return redirect()->route('vendor.services.index')
                        ->with('success','Service created!');
    }


    public function edit(Service $service)
    {
        $vendorId = auth()->user()->vendor->id;

        if ($service->vendor_id !== $vendorId) {
            abort(403, 'Unauthorized action.');
        }

        return view('vendor.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        // Validate input
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'base_price' => 'required|numeric',
            'price_unit' => 'required|string|max:50',
            'images.*' => 'nullable|image|max:2048', // 2MB per image
        ]);

        // Update service details
        $service->update([
            'title' => $request->title,
            'description' => $request->description,
            'base_price' => $request->base_price,
            'price_unit' => $request->price_unit,
        ]);

        // Handle new uploaded images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('services', 'public'); // stored in storage/app/public/services
                $service->images()->create([
                    'filename' => $path,
                ]);
            }
        }

        return redirect()->route('vendor.services.index', $service)
                        ->with('success', 'Service updated successfully.');
    }



    // Delete a single service image
    public function destroyImage($serviceId, $imageId)
    {
        $service = auth()->user()->vendor->services()->findOrFail($serviceId);
        $image = $service->images()->findOrFail($imageId);

        // Delete file
        $filePath = public_path('uploads/services/' . $image->filename);
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Delete DB record
        $image->delete();

        return back()->with('success', 'Image deleted successfully.');
    }



    // Delete entire service
    public function destroy(Service $service)
    {
        $vendorId = auth()->user()->vendor->id;
        if ($service->vendor_id !== $vendorId) {
            abort(403, 'Unauthorized action.');
        }

        // Delete service images from storage
        foreach ($service->images as $image) {
            $filePath = public_path('uploads/services/' . $image->filename);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        // Delete service (images will cascade if foreign key is setup)
        $service->delete();

        return redirect()->route('vendor.services.index')->with('success', 'Service deleted successfully.');
    }


}
