@extends('layouts.app')

@section('content')
<div class="container py-5">

    {{-- Network Error --}}
    @if(session('network_error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert" data-aos="fade-down">
            <i class="bi bi-wifi-off"></i> {{ session('network_error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Navigation --}}
    <div class="mb-4 d-flex flex-wrap gap-2" data-aos="fade-right">
        <a href="{{ route('vendors.index') }}" class="btn btn-nav">
            <i class="bi bi-arrow-left-circle"></i> Back to Vendors
        </a>
        <a href="{{ route('services.index') }}" class="btn btn-nav">
            <i class="bi bi-grid-fill"></i> Back to Services
        </a>
    </div>

    {{-- Unified Service Card --}}
    <div class="card service-main-card shadow-lg border-0 rounded-4 overflow-hidden" data-aos="zoom-in">

        <div class="row g-0">
            {{-- Image Section --}}
            <div class="col-md-6">
                @if($service->images->count() > 1)
                    <div id="serviceCarousel" class="carousel slide h-100" data-bs-ride="carousel">
                        <div class="carousel-inner h-100">
                            @foreach($service->images as $key => $image)
                                <div class="carousel-item h-100 @if($key == 0) active @endif">
                                    <img src="{{ asset('storage/' . $image->filename) }}" 
                                         class="d-block w-100 h-100 service-hero-img" 
                                         alt="Service Image">
                                </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#serviceCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#serviceCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>
                @elseif($service->images->count() == 1)
                    <img src="{{ asset('storage/' . $service->images->first()->filename) }}" class="w-100 h-100 service-hero-img" alt="Service Image">
                @else
                    <img src="https://via.placeholder.com/600x400?text=No+Image"
                         class="w-100 h-100 service-hero-img" alt="No Image">
                @endif
            </div>

            {{-- Info Section --}}
            <div class="col-md-6 d-flex">
                <div class="p-4 d-flex flex-column justify-content-center">
                    <h2 class="fw-bold text-primary mb-3">{{ $service->title }}</h2>
                    <p class="text-muted mb-4">{{ $service->description }}</p>

                    <p class="fw-bold fs-4 text-success mb-3">
                        ₦{{ number_format($service->base_price, 2) }}
                        @if($service->price_unit)
                            <small class="text-muted">/ {{ $service->price_unit }}</small>
                        @endif
                    </p>

                    <p class="mb-4">
                        <i class="bi bi-shop text-primary"></i>
                        <strong> Vendor:</strong> {{ $service->vendor->business_name ?? 'N/A' }}
                    </p>

                    @auth
                        <form action="{{ route('bookings.store', $service) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success btn-lg w-100 shadow-sm">
                                <i class="bi bi-calendar-check"></i> Book Now
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg w-100 shadow-sm">
                            <i class="bi bi-box-arrow-in-right"></i> Login to Book
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    {{-- More from Vendor --}}
    @if($service->vendor && $service->vendor->services()->where('id', '!=', $service->id)->count() > 0)
        <div class="mt-5" data-aos="fade-up">
            <h4 class="fw-bold mb-4 text-center">More from {{ $service->vendor->business_name }}</h4>

            @php
                $otherServices = $service->vendor
                    ->services()
                    ->where('id', '!=', $service->id)
                    ->paginate(3);
            @endphp

            <div class="row g-4 justify-content-center">
                @foreach($otherServices as $otherService)
                    <div class="col-md-4 col-sm-6 d-flex" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 150 }}">
                        <div class="card shadow-sm border-0 h-100 w-100 rounded-4 overflow-hidden service-card">
                            @if($otherService->images->first())
                                <img src="{{ asset('storage/' . $otherService->images->first()->filename) }}" class="card-img-top service-img" alt="Service Image">
                            @else
                                <img src="https://via.placeholder.com/400x250?text=No+Image" class="card-img-top service-img" alt="No Image">
                            @endif
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-bold">{{ $otherService->title }}</h5>
                                <p class="text-muted mb-2">
                                    ₦{{ number_format($otherService->base_price, 2) }}
                                    @if($otherService->price_unit)
                                        <small>/ {{ $otherService->price_unit }}</small>
                                    @endif
                                </p>
                                <a href="{{ route('services.show', $otherService->id) }}" class="btn btn-outline-primary btn-sm mt-auto">View Service</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 d-flex justify-content-center">
                {{ $otherServices->links('pagination::bootstrap-5') }}
            </div>
        </div>
    @endif

</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<style>
    /* Unified Image + Info Card */
    .service-main-card {
        overflow: hidden;
        border-radius: 20px;
    }
    .service-hero-img {
        height: 100%;
        min-height: 350px;
        object-fit: cover;
        transition: transform .5s ease;
    }
    .service-hero-img:hover {
        transform: scale(1.07);
    }

    /* Modern Nav Buttons */
    .btn-nav {
        background: linear-gradient(135deg, #6a11cb, #2575fc);
        color: #fff !important;
        border: none;
        border-radius: 25px;
        padding: 0.6rem 1.2rem;
        font-weight: 500;
        transition: transform .2s, box-shadow .2s;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-nav:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0,0,0,0.15);
    }

    /* Extra Styling */
    .service-card {
        transition: transform .3s, box-shadow .3s;
    }
    .service-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 25px rgba(0,0,0,0.15);
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        once: true
    });
</script>
@endpush
@endsection