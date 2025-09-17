@extends('layouts.app')

@section('title', 'My Services')

@section('content')
<div class="vendor-services">

    <!-- Hero Section -->
    <section class="hero-services text-center text-white py-5 mb-5">
        <div class="container" data-aos="fade-down">
            <h1 class="fw-bold display-5 mb-3 animate-title">📦 My Services</h1>
            <p class="lead opacity-75">Manage your service listings — add, edit, or remove with ease.</p>
        </div>
    </section>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2" data-aos="fade-up">
            <h2 class="fw-bold">Your Services</h2>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('vendor.dashboard') }}" class="btn btn-outline-secondary shadow-sm">🏠 Dashboard</a>
                <a href="{{ route('vendor.services.create') }}" class="btn btn-primary shadow-sm">➕ Add Service</a>
            </div>
        </div>

        @forelse($services as $service)
            <div class="service-card shadow-lg border-0 rounded-4 mb-4 overflow-hidden" data-aos="fade-up">
                <div class="row g-0 align-items-stretch">
                    
                    {{-- Thumbnail --}}
                    <div class="col-md-3 service-thumb">
                        @if($service->images && $service->images->count() > 0)
                            <img src="{{ asset('storage/' . $service->images[0]->filename) }}" 
                                 alt="{{ $service->title }}" 
                                 class="img-fluid w-100 h-100 obj-fit-cover">
                        @else
                            <img src="https://via.placeholder.com/300x200?text=No+Image" 
                                 alt="No Image" class="img-fluid w-100 h-100 obj-fit-cover">
                        @endif
                    </div>

                    {{-- Service Details --}}
                    <div class="col-md-9">
                        <div class="card-body p-4 d-flex flex-column h-100">
                            <h5 class="fw-bold text-primary mb-2">{{ $service->title }}</h5>
                            <p class="text-muted small flex-grow-1">{{ Str::limit($service->description, 120) }}</p>

                            <div class="d-flex justify-content-between align-items-center flex-wrap mt-3">
                                <p class="fw-semibold text-success mb-2">
                                    ₦{{ number_format($service->base_price, 2) }}
                                    <small class="text-muted">/ {{ $service->price_unit }}</small>
                                </p>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('vendor.services.edit', $service) }}" class="btn btn-warning btn-sm shadow-sm">✏️ Edit</a>
                                    <form action="{{ route('vendor.services.destroy', $service) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm shadow-sm">🗑 Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        @empty
            <div class="empty-state text-center py-5" data-aos="fade-up">
                <p class="text-muted">You haven’t added any services yet.</p>
                <a href="{{ route('vendor.services.create') }}" class="btn btn-outline-primary shadow-sm">Add Your First Service</a>
            </div>
        @endforelse
    </div>
</div>

{{-- Styles --}}
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<style>
    /* Hero Banner */
    .hero-services {
        background: linear-gradient(135deg, #6a11cb, #2575fc);
        border-radius: 0 0 30px 30px;
        animation: fadeInDown 1s ease-out;
    }
    .animate-title {
        animation: fadeIn 1s ease-in-out, pulse 3s infinite;
    }
    @keyframes pulse {
        0%   { text-shadow: 0 0 0 rgba(255,255,255,0.3); }
        50%  { text-shadow: 0 0 12px rgba(255,255,255,0.8); }
        100% { text-shadow: 0 0 0 rgba(255,255,255,0.3); }
    }

    /* Service Card */
    .service-card {
        transition: .3s;
    }
    .service-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.12) !important;
    }

    .service-thumb {
        background: #f8f9fa;
        min-height: 180px;
        max-height: 220px;
        overflow: hidden;
    }
    .service-thumb img {
        transition: transform 0.4s ease;
        height: 100%;
        width: 100%;
        object-fit: cover;
    }
    .service-card:hover .service-thumb img {
        transform: scale(1.08);
    }

    /* Buttons */
    .btn {
        border-radius: 8px;
        font-weight: 500;
        transition: 0.25s;
    }
    .btn:hover {
        transform: translateY(-2px);
    }

    .empty-state {
        background: #fdfdfd;
        border: 2px dashed #2575fc40;
        border-radius: 16px;
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