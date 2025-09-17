@extends('layouts.app')

@section('title', 'My Bookings')

@section('content')
<div class="bookings-page">

    <!-- Hero Section -->
    <section class="bookings-hero text-white py-5 mb-5">
        <div class="container text-center" data-aos="fade-down">
            <h1 class="fw-bold display-5">📑 My Bookings</h1>
            <p class="lead opacity-75">Track all your service bookings and their statuses in one place</p>
        </div>
    </section>

    <div class="container">

        {{-- Bookings Grid --}}
        <div class="row g-4">
            @forelse($bookings as $booking)
                <div class="col-12 col-sm-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="card booking-card h-100 shadow-sm border-0 rounded-4 overflow-hidden">

                        {{-- Service Image --}}
                        @if($booking->service->images->first())
                            <img src="{{ asset('storage/' . $booking->service->images->first()->filename) }}"
                                 class="card-img-top booking-img"
                                 alt="{{ $booking->service->title }}">
                        @else
                            <img src="https://via.placeholder.com/400x250?text=No+Image"
                                 class="card-img-top booking-img"
                                 alt="No Image">
                        @endif

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold text-dark">{{ $booking->service->title }}</h5>

                            <p class="text-muted small mb-2">
                                <i class="bi bi-shop text-primary"></i>
                                Vendor: {{ $booking->service->vendor->business_name ?? 'N/A' }}
                            </p>

                            <p class="fw-semibold text-success mb-1">
                                ₦{{ number_format($booking->amount, 2) }}
                            </p>

                            <p class="small mb-2">
                                Reference: <code>{{ $booking->reference }}</code>
                            </p>

                            {{-- Booking Status --}}
                            <span class="badge status-badge mb-3 bg-{{ 
                                $booking->status === 'paid' ? 'success' : 
                                ($booking->status === 'pending' ? 'warning text-dark' : 'danger') }}">
                                {{ ucfirst($booking->status) }}
                            </span>

                            {{-- QR Ticket for Paid --}}
                            @if($booking->status === 'paid')
                                <div class="mb-3 text-center">
                                    <p class="small fw-semibold text-muted">🎟 Your QR Ticket</p>
                                    <div class="qr-wrapper shadow-sm p-2 bg-light rounded">
                                        {!! QrCode::size(120)->generate($booking->reference) !!}
                                    </div>
                                </div>
                            @endif

                            <a href="{{ route('services.show', $booking->service_id) }}" class="btn btn-gradient btn-sm mt-auto">
                                <i class="bi bi-eye"></i> View Service
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center" data-aos="zoom-in">
                    <i class="bi bi-calendar-x display-5 text-muted mb-3 d-block"></i>
                    <div class="alert alert-info shadow-sm d-inline-block px-4 rounded-pill">
                        You have no bookings yet.
                        <a href="{{ route('services.index') }}" class="fw-semibold">Browse Services</a>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($bookings->hasPages())
            <div class="mt-5 d-flex justify-content-center" data-aos="fade-up">
                {{ $bookings->links('pagination::bootstrap-5') }}
            </div>
        @endif

    </div>
</div>

{{-- Extra CSS --}}
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<style>
    /* Hero */
    .bookings-hero {
        background: linear-gradient(135deg, #6a11cb, #2575fc);
        border-radius: 0 0 30px 30px;
    }

    /* Booking Cards */
    .booking-card {
        transition: transform .3s ease, box-shadow .3s ease;
        border-radius: 18px;
    }
    .booking-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.12);
    }
    .booking-img {
        height: 200px;
        object-fit: cover;
        transition: transform .5s ease;
    }
    .booking-card:hover .booking-img {
        transform: scale(1.05);
    }

    /* QR Wrapper */
    .qr-wrapper {
        display: inline-block;
        border-radius: 12px;
    }

    /* Gradient Button */
    .btn-gradient {
        background: linear-gradient(135deg, #36d1dc, #5b86e5);
        color: #fff !important;
        border-radius: 8px;
        font-weight: 500;
        transition: 0.3s;
    }
    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0,0,0,0.2);
    }

    /* Pagination */
    .pagination .page-item .page-link {
        border-radius: 12px;
        margin: 0 4px;
        color: #2575fc;
        font-weight: 600;
    }
    .pagination .page-item.active .page-link {
        background: #2575fc;
        border-color: #2575fc;
        color: #fff;
        box-shadow: 0 0 8px rgba(37,117,252,0.3);
    }
</style>
@endpush

{{-- AOS --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 800,
        once: true,
        offset: 70
    });
</script>
@endpush
@endsection