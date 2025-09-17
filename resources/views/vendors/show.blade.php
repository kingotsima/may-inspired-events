@extends('layouts.app')

@section('title', $vendor->business_name)

@section('content')
<div class="vendor-profile-page">

    <!-- Hero Section -->
    <section class="vendor-hero text-white py-5 mb-5">
        <div class="container text-center" data-aos="fade-down">
            <h1 class="fw-bold display-5"><i class="bi bi-shop"></i> {{ $vendor->business_name }}</h1>
            <p class="lead"><i class="bi bi-geo-alt-fill"></i> {{ $vendor->city }}, {{ $vendor->state }}</p>
        </div>
    </section>

    <div class="container">
        <!-- Back Button -->
        <div class="mb-4 d-flex" data-aos="fade-right">
            <a href="{{ route('vendors.index') }}" class="btn btn-nav">
                <i class="bi bi-arrow-left-circle"></i> Back to Vendors
            </a>
        </div>

        <!-- Vendor Info Card -->
        <div class="card shadow-lg border-0 rounded-4 overflow-hidden vendor-info" data-aos="zoom-in">
            <div class="card-body p-4">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                    <h2 class="fw-bold text-primary mb-3 mb-md-0">
                        <i class="bi bi-info-circle"></i> Vendor Info
                    </h2>
                    <a href="{{ route('vendors.services', $vendor->id) }}" class="btn btn-gradient px-4">
                        <i class="bi bi-card-list"></i> View Services
                    </a>
                </div>
                <hr>

                <!-- Contact Info -->
                <div class="row g-4">
                    <div class="col-md-6">
                        <p class="text-muted mb-2">
                            <i class="bi bi-telephone-fill text-success me-2"></i> {{ $vendor->phone }}
                        </p>
                        <!-- <p class="text-muted mb-2">
                            <i class="bi bi-envelope-fill text-danger me-2"></i> {{ $vendor->email ?? 'N/A' }}
                        </p> -->
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted mb-2">
                            <i class="bi bi-geo-alt-fill text-primary me-2"></i> {{ $vendor->city }}, {{ $vendor->state }}
                        </p>
                    </div>
                </div>

                <!-- Availability Section -->
                <div class="mt-4">
                    <h5 class="fw-semibold mb-2 text-primary">
                        <i class="bi bi-calendar-event-fill me-2"></i> Availability
                    </h5>
                    @if($availability)
                        <div class="p-3 bg-light rounded-4 shadow-sm">
                            <p class="mb-1 text-muted">
                                <strong>Days:</strong>
                                {{ is_array($availability->available_days) ? implode(', ', $availability->available_days) : $availability->available_days }}
                            </p>
                            <p class="mb-1 text-muted">
                                <strong>Time:</strong>
                                {{ $availability->start_time }} – {{ $availability->end_time }}
                            </p>
                            @if(!empty($availability->unavailable_dates))
                                <p class="mb-0 text-muted">
                                    <strong>Unavailable:</strong>
                                    {{ is_array($availability->unavailable_dates) ? implode(', ', $availability->unavailable_dates) : $availability->unavailable_dates }}
                                </p>
                            @endif
                        </div>
                    @else
                        <p class="text-muted">This vendor has not set availability yet.</p>
                    @endif
                </div>

                <!-- About Section -->
                <div class="mt-4">
                    <h5 class="fw-semibold mb-2"><i class="bi bi-file-text text-info"></i> About</h5>
                    <p class="text-secondary">{{ $vendor->bio ?? 'No description available.' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Custom Styles --}}
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<style>
    /* Hero Section */
    .vendor-hero {
        background: linear-gradient(135deg, #6a11cb, #2575fc);
        border-radius: 0 0 30px 30px;
    }

    /* Vendor Card Hover */
    .vendor-info {
        transition: transform .3s ease, box-shadow .3s ease;
        border-radius: 18px;
    }
    .vendor-info:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.15);
    }

    /* Back Button Modern Style */
    .btn-nav {
        background: linear-gradient(135deg, #6a11cb, #2575fc);
        color: #fff !important;
        border: none;
        border-radius: 25px;
        padding: 0.6rem 1.2rem;
        font-weight: 500;
        transition: .3s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-nav:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0,0,0,0.15);
    }

    /* Services Button CTA */
    .btn-gradient {
        background: linear-gradient(135deg, #36d1dc, #5b86e5);
        color: #fff !important;
        border-radius: 25px;
        font-weight: 500;
        transition: .3s;
    }
    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0,0,0,0.2);
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 900,
        once: true,
        offset: 80
    });
</script>
@endpush
@endsection