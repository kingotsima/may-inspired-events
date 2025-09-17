@extends('layouts.app')

@section('title', 'Available Vendors')

@section('content')
<div class="vendors-page">

    <!-- Hero -->
    <section class="hero-vendors text-center text-white py-5 mb-5">
        <div class="container" data-aos="zoom-in">
            <h1 class="fw-bold display-5"><i class="bi bi-people-fill"></i> Available Vendors</h1>
            <p class="lead opacity-75">Connect with trusted, approved vendors for your events.</p>
        </div>
    </section>

    <div class="container">

        {{-- No vendors alert --}}
        @if($vendors->isEmpty())
            <div class="alert alert-info text-center shadow-sm rounded" data-aos="fade-up">
                <i class="bi bi-exclamation-circle"></i> 
                No approved vendors available at the moment.
            </div>
        @else
            {{-- Vendor Cards --}}
            <div class="row g-4">
                @foreach($vendors as $vendor)
                    <div class="col-sm-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <div class="card h-100 vendor-card border-0 rounded-4 shadow-sm overflow-hidden">
                            <!-- Optional vendor banner (fallback color gradient) -->
                            <div class="vendor-header text-white p-3 d-flex align-items-center">
                                <i class="bi bi-shop me-2 fs-4"></i>
                                <h5 class="card-title mb-0 fw-bold">{{ $vendor->business_name }}</h5>
                            </div>

                            <div class="card-body">
                                <p class="text-muted mb-2">
                                    <i class="bi bi-telephone-fill text-success me-2"></i> {{ $vendor->phone }}
                                </p>
                                <p class="text-muted mb-2">
                                    <i class="bi bi-geo-alt-fill text-danger me-2"></i> {{ $vendor->city }}, {{ $vendor->state }}
                                </p>
                                <p class="card-text small">
                                    {{ Str::limit($vendor->bio ?? 'No description available', 100) }}
                                </p>
                            </div>
                            <div class="card-footer bg-light border-0 text-center">
                                <a href="{{ route('vendors.show', $vendor->id) }}" class="btn btn-gradient px-4">
                                    <i class="bi bi-eye"></i> View Profile
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-5 d-flex justify-content-center" data-aos="fade-up">
                {{ $vendors->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</div>

{{-- Styles with AOS --}}
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<style>
    /* Hero Banner */
    .hero-vendors {
        background: linear-gradient(135deg, #6a11cb, #2575fc);
        border-radius: 0 0 30px 30px;
    }

    /* Vendor Card */
    .vendor-card {
        transition: transform .3s ease, box-shadow .3s ease;
        border-radius: 16px;
    }
    .vendor-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 15px 30px rgba(0,0,0,.12);
    }

    /* Card header band */
    .vendor-header {
        background: linear-gradient(135deg, #6a11cb, #2575fc);
    }

    /* Gradient Button */
    .btn-gradient {
        background: linear-gradient(135deg, #6a11cb, #2575fc);
        color: #fff !important;
        border-radius: 25px;
        font-weight: 500;
        transition: transform .2s, box-shadow .2s;
    }
    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    /* Pagination pills style */
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
        box-shadow: 0 0 8px rgba(37,117,252,0.4);
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