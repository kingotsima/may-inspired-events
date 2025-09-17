@extends('layouts.app')

@section('title', 'Edit Service')

@section('content')
<div class="service-edit">

    <!-- Hero Section -->
    <section class="hero-edit text-center text-white py-5 mb-5">
        <div class="container" data-aos="fade-down">
            <h1 class="fw-bold display-5 mb-3 animate-title">✏️ Edit Service</h1>
            <p class="lead opacity-75">Update your service details and images below.</p>
        </div>
    </section>

    <div class="container" data-aos="fade-up">
        <!-- Validation Errors -->
        @if($errors->any())
            <div class="alert alert-danger shadow-sm rounded-4">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Main Form Card -->
        <form id="update-service-form" 
              action="{{ route('vendor.services.update', $service) }}" 
              method="POST" 
              enctype="multipart/form-data" 
              class="service-form-card shadow-lg p-4 rounded-4 bg-white mt-4">
            @csrf
            @method('PUT')

            {{-- Title --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Title</label>
                <input type="text" name="title" class="form-control form-control-lg shadow-sm" value="{{ old('title', $service->title) }}" required>
            </div>

            {{-- Description --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Description</label>
                <textarea name="description" rows="4" class="form-control form-control-lg shadow-sm">{{ old('description', $service->description) }}</textarea>
            </div>

            {{-- Base Price & Price Unit --}}
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Base Price (₦)</label>
                    <input type="number" name="base_price" class="form-control form-control-lg shadow-sm" value="{{ old('base_price', $service->base_price) }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Price Unit</label>
                    <input type="text" name="price_unit" class="form-control form-control-lg shadow-sm" value="{{ old('price_unit', $service->price_unit) }}" required>
                </div>
            </div>

            {{-- Upload New Images --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Upload New Images</label>
                <input type="file" name="images[]" class="form-control form-control-lg shadow-sm" accept="image/*" multiple>
                <small class="text-muted">Leave empty if you don’t want to add new images.</small>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-success btn-lg shadow-sm px-4">
                    💾 Update Service
                </button>
            </div>
        </form>

        <!-- Existing Images -->
        @if($service->images && $service->images->count() > 0)
            <div class="mt-5" data-aos="fade-up">
                <label class="form-label fw-semibold mb-3">Current Images</label>
                <div class="d-flex flex-wrap gap-3">
                    @foreach($service->images as $image)
                        <div class="position-relative img-thumb">
                            <img src="{{ asset('storage/' . $image->filename) }}" alt="Service Image" class="rounded-4 shadow-sm">
                            
                            <!-- Delete Button -->
                            <button class="btn btn-sm btn-danger position-absolute top-0 end-0 rounded-circle shadow"
                                    onclick="event.preventDefault(); if(confirm('Delete this image?')) { document.getElementById('delete-image-{{ $image->id }}').submit(); }">
                                ×
                            </button>
                            
                            <!-- Hidden form -->
                            <form id="delete-image-{{ $image->id }}" action="{{ route('vendor.services.images.destroy', [$service->id, $image->id]) }}" method="POST" style="display:none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

{{-- Styles --}}
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<style>
    /* Hero Banner */
    .hero-edit {
        background: linear-gradient(135deg, #6a11cb, #2575fc);
        border-radius: 0 0 30px 30px;
    }

    .animate-title {
        animation: fadeIn 1s ease-in-out, pulse 3s infinite;
    }
    @keyframes pulse {
        0%   { text-shadow: 0 0 0px rgba(255,255,255,0.3); }
        50%  { text-shadow: 0 0 15px rgba(255,255,255,0.8); }
        100% { text-shadow: 0 0 0px rgba(255,255,255,0.3); }
    }

    /* Form Card */
    .service-form-card {
        border-left: 5px solid #2575fc;
        transition: .3s;
    }
    .service-form-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.12) !important;
    }

    /* Input focus */
    .form-control:focus {
        border-color: #2575fc;
        box-shadow: 0 0 0 .2rem rgba(37,117,252,0.25);
    }

    /* Existing Thumbnails */
    .img-thumb {
        width: 140px;
        height: 100px;
        overflow: hidden;
    }
    .img-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform .4s ease;
    }
    .img-thumb:hover img {
        transform: scale(1.08);
    }
    .img-thumb button {
        width: 24px;
        height: 24px;
        line-height: 14px;
        font-size: 1rem;
        padding: 0;
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