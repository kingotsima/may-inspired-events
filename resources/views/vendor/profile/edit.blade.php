@extends('layouts.app')

@section('title', 'Edit Vendor Profile')

@section('content')
<div class="vendor-profile-edit">

    <!-- Hero Section -->
    <section class="hero-vendor text-center text-white py-5 mb-5">
        <div class="container" data-aos="fade-down">
            <h1 class="fw-bold display-5 mb-3 animate-title">📝 Edit Vendor Profile</h1>
            <p class="lead opacity-75">Keep your information up to date so clients know exactly who you are.</p>
        </div>
    </section>

    <div class="container">
        <!-- Profile Form Card -->
        <div class="profile-card shadow-lg p-4 rounded-4 bg-white mx-auto" style="max-width: 720px;" data-aos="fade-up">
            <form action="{{ route('vendor.profile.update') }}" method="POST" class="row gy-4">
                @csrf
                @method('PUT')

                <div class="col-12">
                    <label for="business_name" class="form-label fw-semibold">Business Name</label>
                    <input type="text" name="business_name" id="business_name" 
                           class="form-control form-control-lg shadow-sm @error('business_name') is-invalid @enderror" 
                           value="{{ old('business_name', $vendor->business_name) }}" required>
                    @error('business_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label for="bio" class="form-label fw-semibold">Bio / Description</label>
                    <textarea name="bio" id="bio" rows="4" 
                              class="form-control form-control-lg shadow-sm @error('bio') is-invalid @enderror">{{ old('bio', $vendor->bio) }}</textarea>
                    @error('bio')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12">
                    <label for="phone" class="form-label fw-semibold">Phone</label>
                    <input type="text" name="phone" id="phone" 
                           class="form-control form-control-lg shadow-sm @error('phone') is-invalid @enderror" 
                           value="{{ old('phone', $vendor->phone) }}" required>
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="city" class="form-label fw-semibold">City</label>
                    <input type="text" name="city" id="city" 
                           class="form-control form-control-lg shadow-sm @error('city') is-invalid @enderror" 
                           value="{{ old('city', $vendor->city) }}" required>
                    @error('city')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="state" class="form-label fw-semibold">State</label>
                    <input type="text" name="state" id="state" 
                           class="form-control form-control-lg shadow-sm @error('state') is-invalid @enderror" 
                           value="{{ old('state', $vendor->state) }}" required>
                    @error('state')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 d-flex justify-content-between mt-3">
                    <a href="{{ route('vendor.dashboard') }}" class="btn btn-outline-secondary btn-lg shadow-sm">
                        ⬅ Back
                    </a>
                    <button type="submit" class="btn btn-primary btn-lg shadow-sm">
                        💾 Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Styles --}}
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<style>
    /* Hero Banner */
    .hero-vendor {
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

    /* Profile Card */
    .profile-card {
        transition: .3s;
        border-radius: 18px;
    }
    .profile-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.12);
    }

    /* Form styling */
    .form-control, .form-select {
        border-radius: 12px;
        padding: 14px 16px;
        font-size: 1rem;
    }
    .form-control:focus, .form-select:focus {
        border-color: #2575fc;
        box-shadow: 0 0 0 .2rem rgba(37,117,252,0.3);
    }

    /* Buttons */
    .btn {
        border-radius: 12px;
        transition: 0.3s;
    }
    .btn-primary {
        font-weight: bold;
    }
    .btn-primary:hover {
        background: #6a11cb;
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(0,0,0,0.2);
    }
    .btn-outline-secondary:hover {
        background: #f1f1f1;
        transform: translateY(-2px);
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