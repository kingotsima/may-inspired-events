@extends('layouts.app')

@section('title', 'About Us')

@section('content')
<div class="about-page">

    <!-- Hero Section -->
    <section class="hero-about text-center text-white py-5 mb-5">
        <div class="container" data-aos="fade-down">
            <h1 class="fw-bold display-5 mb-3 animate-title">🌟 About Us</h1>
            <p class="lead opacity-75">
                Learn more about May Inspired Events — your trusted event partner.
            </p>
        </div>
    </section>

    <div class="container">
        <div class="row g-4 justify-content-center">
            <!-- Mission Card -->
            <div class="col-lg-6" data-aos="fade-right">
                <div class="about-card shadow-lg p-4 rounded-4 bg-white h-100">
                    <h4 class="fw-bold text-primary mb-3">Who We Are</h4>
                    <p>
                        Welcome to <strong>{{ config('app.name', 'May Inspired Events') }}</strong> — your one-stop platform 
                        for discovering, booking, and managing events. We connect clients with trusted vendors, 
                        making event planning stress-free and secure.
                    </p>
                </div>
            </div>
            
            <!-- Vision Card -->
            <div class="col-lg-6" data-aos="fade-left">
                <div class="about-card shadow-lg p-4 rounded-4 bg-white h-100">
                    <h4 class="fw-bold text-primary mb-3">Our Mission</h4>
                    <p>
                        Our mission is to empower individuals and organizations to plan memorable events 
                        while helping vendors reach a wider audience. All transactions are safe, transparent, 
                        and backed by our 10% service guarantee.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Styles --}}
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<style>
    /* Hero Banner */
    .hero-about {
        background: linear-gradient(130deg, #6a11cb, #2575fc);
        border-radius: 0 0 30px 30px;
        animation: fadeInDown 1s ease-out;
    }

    .animate-title {
        animation: fadeIn 1s ease-in-out, pulse 3s infinite;
    }

    @keyframes pulse {
        0%   { text-shadow: 0 0 0px rgba(255,255,255,0.4); }
        50%  { text-shadow: 0 0 15px rgba(255,255,255,0.8); }
        100% { text-shadow: 0 0 0px rgba(255,255,255,0.4); }
    }

    /* About Cards */
    .about-card {
        transition: .3s;
        border-radius: 18px;
    }
    .about-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    }

    .about-card h4 {
        font-weight: bold;
    }
</style>
@endpush

{{-- Scripts --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 900,
        once: true
    });
</script>
@endpush
@endsection