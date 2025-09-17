@extends('layouts.app')

@section('title', $vendor->business_name . ' - Services')

@section('content')
<div class="vendor-services-page">

    <!-- Hero Section -->
    <section class="vendor-services-hero text-white py-5 mb-5">
        <div class="container text-center" data-aos="zoom-in">
            <h1 class="fw-bold display-5"><i class="bi bi-card-list"></i> Services by {{ $vendor->business_name }}</h1>
            <p class="lead opacity-75">Browse all available services offered by this vendor.</p>
        </div>
    </section>

    <div class="container">

        <!-- Back Button -->
        <div class="mb-4 d-flex" data-aos="fade-right">
            <a href="{{ route('vendors.show', $vendor->id) }}" class="btn btn-nav">
                <i class="bi bi-arrow-left-circle"></i> Back to {{ $vendor->business_name }}
            </a>
        </div>

        <!-- Services Grid -->
        @if($services->count() > 0)
            <div class="row g-4 justify-content-center">
                @foreach($services as $service)
                    <div class="col-md-4 col-sm-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="card service-card shadow-sm border-0 h-100 rounded-4 overflow-hidden">

                            {{-- Service Image --}}
                            <div class="position-relative overflow-hidden">
                                <img src="{{ $service->image
                                    ? asset('storage/' . $service->image)
                                    : ($service->images->count()
                                        ? asset('storage/' . $service->images->first()->filename)
                                        : 'https://via.placeholder.com/400x250?text=No+Image') }}"
                                     class="card-img-top service-img"
                                     alt="{{ $service->name }}">
                                <span class="badge bg-gradient position-absolute top-0 end-0 m-2">
                                    ₦{{ number_format($service->base_price, 0) }}
                                </span>
                            </div>

                            <!-- Card Body -->
                            <div class="card-body d-flex flex-column">
                                <h5 class="fw-bold text-dark mb-2">{{ $service->name }}</h5>
                                <p class="text-muted small flex-grow-1">{{ Str::limit($service->description, 120) }}</p>
                                
                                <div class="mt-3">
                                    <a href="{{ route('services.show', $service->id) }}" class="btn btn-gradient w-100">
                                        <i class="bi bi-eye"></i> View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-5" data-aos="fade-up">
                {{ $services->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="alert alert-info shadow-sm rounded text-center" data-aos="fade-up">
                <i class="bi bi-info-circle"></i> This vendor hasn’t posted any services yet.
            </div>
        @endif
    </div>
</div>

{{-- Custom Styles and AOS --}}
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<style>
    /* Hero */
    .vendor-services-hero {
        background: linear-gradient(135deg, #6a11cb, #2575fc);
        border-radius: 0 0 25px 25px;
    }

    /* Service Cards */
    .service-card {
        transition: transform .3s ease, box-shadow .3s ease;
        border-radius: 18px;
    }
    .service-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 15px 30px rgba(0,0,0,.12);
    }
    .service-img {
        height: 200px;
        object-fit: cover;
        transition: transform .5s ease;
    }
    .service-card:hover .service-img {
        transform: scale(1.05);
    }

    /* Back Button */
    .btn-nav {
        background: linear-gradient(135deg, #6a11cb, #2575fc);
        color: #fff !important;
        border-radius: 25px;
        padding: 0.6rem 1.2rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: all .3s;
    }
    .btn-nav:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0,0,0,0.15);
    }

    /* Gradient Button */
    .btn-gradient {
        background: linear-gradient(135deg, #36d1dc, #5b86e5);
        color: #fff !important;
        border-radius: 25px;
        font-weight: 500;
        transition: all .3s;
    }
    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0,0,0,0.2);
    }

    /* Badge */
    .badge.bg-gradient {
        background: linear-gradient(135deg, #ff512f, #dd2476);
        font-size: .75rem;
        border-radius: 20px;
    }

    /* Pagination Pills */
    .pagination .page-item .page-link {
        border-radius: 12px;
        margin: 0 4px;
        color: #2575fc;
        font-weight: 500;
    }
    .pagination .page-item.active .page-link {
        background: #2575fc;
        border-color: #2575fc;
        color: #fff;
        box-shadow: 0 0 10px rgba(37,117,252,0.4);
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