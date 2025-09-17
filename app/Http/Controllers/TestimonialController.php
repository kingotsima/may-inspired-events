<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestimonialController extends Controller
{
    // Client submits testimonial
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'message' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('testimonials', 'public');
        }

        Testimonial::create([
            'name' => $request->name, // ✅ use the typed name
            'message' => $request->message,
            'rating' => $request->rating,
            'image' => $path,
            'status' => 'pending', // default until admin approves
        ]);

        return redirect()->route('welcome')->with('success', 'Testimonial submitted for review!');
    }


    // Admin views all testimonials
    public function index()
    {
        $testimonials = Testimonial::latest()->paginate(10);
        return view('admin.testimonials.index', compact('testimonials'));
    }

    // Admin approves
    public function approve(Testimonial $testimonial)
    {
        $testimonial->update(['status' => 'approved']);
        return back()->with('success', 'Testimonial approved.');
    }

    // Admin deletes
    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return back()->with('success', 'Testimonial deleted.');
    }

    // Admin adds testimonial manually
    public function create()
    {
        return view('admin.testimonials.create');
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
            'rating' => 'nullable|integer|min:1|max:5',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('testimonials', 'public');
        }

        Testimonial::create([
            'name' => $request->name,
            'message' => $request->message,
            'rating' => $request->rating ?? 5,
            'image' => $imagePath,
            'status' => 'approved', // admin testimonials go live instantly
        ]);

        return redirect()->route('admin.testimonials.index')->with('success', 'Testimonial added successfully.');
    }
}
