<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Testimonial;

class WelcomeController extends Controller
{
    public function index()
    {
        $featuredServices = Service::latest()->paginate(3);
        $testimonials = Testimonial::all();

        return view('welcome', compact('featuredServices', 'testimonials'));
    }
}
