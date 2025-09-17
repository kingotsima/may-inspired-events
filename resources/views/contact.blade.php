@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
<div class="contact-page">

    <!-- Hero Section -->
    <section class="hero-contact text-center text-white py-5 mb-5">
        <div class="container" data-aos="fade-down">
            <h1 class="fw-bold display-5 mb-3 animate-title">📬 Get in Touch</h1>
            <p class="lead opacity-75">We’d love to hear from you. Reach out through the form below.</p>
        </div>
    </section>

    <div class="container">
        <div class="row g-4 justify-content-center">
            <!-- Contact Info Card -->
            <div class="col-md-5" data-aos="fade-right">
                <div class="contact-card shadow-lg p-4 rounded-4 bg-white h-100">
                    <h4 class="fw-bold mb-4 text-primary">Our Info</h4>
                    <ul class="list-unstyled">
                        <li class="mb-3 d-flex align-items-center">
                            <i class="bi bi-geo-alt-fill text-primary me-3 fs-4"></i>
                            <span>New York, USA</span>
                        </li>
                        <li class="mb-3 d-flex align-items-center">
                            <i class="bi bi-envelope-fill text-primary me-3 fs-4"></i>
                            <span>kingotsima@gmail.com</span>
                        </li>
                        <li class="mb-3 d-flex align-items-center">
                            <i class="bi bi-telephone-fill text-primary me-3 fs-4"></i>
                            <span>+1 234 567 890</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Contact Form Card -->
            <div class="col-md-7" data-aos="fade-left">
                <div class="contact-card shadow-lg p-4 rounded-4 bg-white">
                    <h4 class="fw-bold mb-4 text-primary">Send Us a Message</h4>
                    <form action="mailto:kingotsima@gmail.com" method="POST" enctype="text/plain" class="row gy-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-semibold">Your Name</label>
                            <input type="text" class="form-control form-control-lg shadow-sm" id="name" name="name" required>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-semibold">Your Email</label>
                            <input type="email" class="form-control form-control-lg shadow-sm" id="email" name="email" required>
                        </div>
                        <div class="col-12">
                            <label for="message" class="form-label fw-semibold">Message</label>
                            <textarea class="form-control form-control-lg shadow-sm" id="message" name="message" rows="5" required></textarea>
                        </div>
                        <div class="col-12 d-grid mt-3">
                            <button type="submit" class="btn btn-primary btn-lg shadow-sm">
                                <i class="bi bi-send"></i> Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Styles --}}
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<style>
    /* Hero Banner similar to services */
    .hero-contact {
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

    /* Contact Card */
    .contact-card {
        transition: .3s;
        border-radius: 18px;
    }
    .contact-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    }

    /* Form inputs */
    .form-control {
        border-radius: 12px;
        padding: 14px 16px;
        font-size: 1rem;
    }
    .form-control:focus {
        border-color: #2575fc;
        box-shadow: 0 0 0 .2rem rgba(37,117,252,0.3);
    }

    .btn-primary {
        font-weight: bold;
        border-radius: 12px;
        transition: 0.3s;
    }
    .btn-primary:hover {
        background: #6a11cb;
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(0,0,0,0.2);
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