@extends('layouts.app')

@section('title', 'Apply as a Vendor')

@section('content')
<div class="vendor-apply-page">

    <!-- Hero Section -->
    <section class="vendor-hero text-white py-5 mb-5">
        <div class="container text-center" data-aos="fade-down">
            <h1 class="fw-bold display-5">🛍️ Apply to Become a Vendor</h1>
            <p class="lead opacity-75">Join our trusted marketplace and grow your business</p>
        </div>
    </section>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6" data-aos="zoom-in">
                <div class="card vendor-card shadow-lg border-0 rounded-4 p-4">

                    @if ($errors->any())
                        <div class="alert alert-danger small rounded-3 shadow-sm mb-4">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(session('success'))
                        <div class="alert alert-success small rounded-3 shadow-sm mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('vendor.store') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Business Name</label>
                            <input type="text" name="business_name" class="form-control form-control-lg shadow-sm" placeholder="Enter your business name" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Bio</label>
                            <textarea name="bio" class="form-control shadow-sm" rows="3" placeholder="Tell us about your business"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Phone</label>
                            <input type="text" name="phone" class="form-control form-control-lg shadow-sm" placeholder="e.g. +2348012345678" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">City</label>
                            <input type="text" name="city" class="form-control form-control-lg shadow-sm" placeholder="Your city" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">State</label>
                            <input type="text" name="state" class="form-control form-control-lg shadow-sm" placeholder="Your state" required>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-gradient btn-lg fw-bold">
                                <i class="bi bi-check-circle"></i> Submit Request
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
    /* Hero */
    .vendor-hero {
        background: linear-gradient(135deg, #6a11cb, #2575fc);
        border-radius: 0 0 30px 30px;
    }

    /* Card */
    .vendor-card {
        border-radius: 18px;
        transition: transform .3s ease, box-shadow .3s ease;
    }
    .vendor-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 28px rgba(0,0,0,0.15);
    }

    /* Form controls */
    .form-control {
        border-radius: 12px;
        padding: .7rem 1rem;
    }
    .form-control:focus {
        border-color: #2575fc;
        box-shadow: 0 0 0 .25rem rgba(37,117,252,0.25);
    }

    /* Gradient Button */
    .btn-gradient {
        background: linear-gradient(135deg, #36d1dc, #5b86e5);
        border: none;
        border-radius: 12px;
        color: #fff !important;
        transition: all .3s ease;
    }
    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 18px rgba(0,0,0,0.2);
    }
</style>
@endpush

{{-- AOS --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 900,
        once: true,
        offset: 70
    });
</script>
@endpush
@endsection