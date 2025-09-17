@extends('layouts.app')

@section('content')
<div class="services-page">

    <!-- Hero Section -->
    <section class="hero-services text-center text-white py-5 mb-5">
        <div class="container" data-aos="fade-down">
            <h1 class="fw-bold display-5 mb-3 animate-title">🎉 Available Services</h1>
            <p class="lead opacity-75">Browse and book services from trusted, verified vendors.</p>
        </div>
    </section>

    <div class="container">

        {{-- Filter Form --}}
        <div class="filter-card shadow-lg p-4 mb-5 rounded-4 bg-white" data-aos="fade-up">
            <form method="GET" action="{{ route('services.index') }}" class="row gy-3 gx-4 align-items-end">
                <div class="col-md-4">
                    <label class="form-label fw-semibold">Search</label>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="🔍 Search services..." class="form-control form-control-lg shadow-sm">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Min Price</label>
                    <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="₦0" class="form-control form-control-lg shadow-sm">
                </div>
                <div class="col-md-2">
                    <label class="form-label fw-semibold">Max Price</label>
                    <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="₦∞" class="form-control form-control-lg shadow-sm">
                </div>
                <div class="col-md-2 d-grid">
                    <button class="btn btn-primary btn-lg shadow-sm"><i class="bi bi-funnel"></i> Filter</button>
                </div>
                <div class="col-md-2 d-grid">
                    <a href="{{ route('services.index') }}" class="btn btn-outline-secondary btn-lg shadow-sm"><i class="bi bi-arrow-repeat"></i> Reset</a>
                </div>
            </form>
        </div>

        {{-- Services Grid --}}
        <div class="row g-4 justify-content-center">
            @forelse($services as $service)
                <div class="col-sm-6 col-md-4 col-lg-3" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="card h-100 shadow-sm border-0 service-card rounded-4 overflow-hidden">
                        
                        {{-- Service Image --}}
                        <div class="position-relative overflow-hidden">
                            <img src="{{ $service->image 
                                    ? asset('storage/' . $service->image) 
                                    : ($service->images->count() 
                                        ? asset('storage/' . $service->images->first()->filename) 
                                        : 'https://via.placeholder.com/400x250?text=No+Image') }}"
                                 class="card-img-top service-img"
                                 alt="{{ $service->title }}">
                            <span class="badge bg-primary position-absolute top-0 start-0 m-2">{{ $service->category->name ?? 'Service' }}</span>
                        </div>

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold mb-2">
                                <a href="{{ route('services.show', $service) }}" class="stretched-link text-decoration-none text-dark">
                                    {{ Str::limit($service->title, 30) }}
                                </a>
                            </h5>
                            <p class="card-text text-muted small flex-grow-1">{{ Str::limit($service->description, 80) }}</p>

                            <div class="mt-3">
                                <p class="fw-bold text-primary mb-1">
                                    ₦{{ number_format($service->base_price, 2) }} 
                                    @if($service->price_unit)
                                        <span class="text-muted">/ {{ $service->price_unit }}</span>
                                    @endif
                                </p>
                                <p class="small text-muted mb-2">👤 {{ $service->vendor->business_name ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center" data-aos="fade-up">
                    <div class="alert alert-info shadow-sm">
                        No services found. Try adjusting your filters.
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-5 d-flex justify-content-center" data-aos="fade-up">
            {{ $services->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

{{-- Styles --}}
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<style>
    /* Hero Banner */
    .hero-services {
        background: linear-gradient(130deg, #6a11cb, #2575fc);
        border-radius: 0 0 30px 30px;
        animation: fadeInDown 1s ease-out;
    }

    /* Animate Title Blink */
    .animate-title {
        animation: fadeIn 1s ease-in-out, pulse 3s infinite;
    }

    @keyframes pulse {
        0% { text-shadow: 0 0 0px rgba(255,255,255,0.4); }
        50% { text-shadow: 0 0 15px rgba(255,255,255,0.8); }
        100% { text-shadow: 0 0 0px rgba(255,255,255,0.4); }
    }

    /* Service Cards */
    .service-card {
        transition: .3s;
        border-radius: 18px;
    }
    .service-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    }

    .service-img {
        height: 200px;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .service-card:hover .service-img {
        transform: scale(1.08);
    }

    .badge {
        border-radius: 10px;
        padding: .4rem .7rem;
        font-size: .75rem;
    }

    /* Pagination */
    .pagination .page-item .page-link {
        border-radius: 10px;
        margin: 0 4px;
        color: #2575fc;
        font-weight: 500;
        transition: .3s;
    }
    .pagination .page-item.active .page-link {
        background: #2575fc;
        border-color: #2575fc;
        color: white;
        font-weight: bold;
        box-shadow: 0 0 10px rgba(37,117,252,0.4);
    }
    .pagination .page-item .page-link:hover {
        background: #6a11cb;
        color: white;
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