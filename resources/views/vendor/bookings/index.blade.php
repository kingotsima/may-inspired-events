@extends('layouts.app')

@section('title', 'My Service Bookings')

@section('content')
<div class="vendor-bookings">

    <!-- Hero Section -->
    <section class="hero-bookings text-center text-white py-5 mb-5">
        <div class="container" data-aos="fade-down">
            <h1 class="fw-bold display-5 mb-3 animate-title">📑 My Bookings</h1>
            <p class="lead opacity-75">Track client bookings, payment status, and details at a glance.</p>
        </div>
    </section>

    <div class="container">
        @forelse($bookings as $booking)
            <div class="booking-item shadow-lg rounded-4 border-0 mb-4 p-4" data-aos="fade-up">
                <div class="d-flex justify-content-between align-items-start flex-wrap">
                    <div class="mb-2">
                        <h5 class="fw-bold mb-1 text-primary">{{ $booking->service->title }}</h5>
                        <p class="mb-1 text-muted small">
                            <i class="bi bi-person-fill me-2"></i>
                            <strong>{{ $booking->user->name }}</strong> ({{ $booking->user->email }})
                        </p>
                        <p class="mb-1 small text-muted">
                            <i class="bi bi-upc-scan me-2"></i>
                            Ref: <span class="fw-medium text-dark">{{ $booking->reference }}</span>
                        </p>
                    </div>
                    <div class="text-end">
                        <span class="badge px-3 py-2 bg-{{ $booking->status == 'paid' ? 'success' : 'warning' }} rounded-pill mb-2">
                            {{ ucfirst($booking->status) }}
                        </span>
                        <p class="fw-bold text-dark mb-0">
                            ₦{{ number_format($booking->amount, 2) }}
                        </p>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-info shadow-sm text-center" data-aos="fade-up">
                No bookings found yet.
            </div>
        @endforelse

        <!-- Pagination -->
        <div class="mt-5 d-flex justify-content-center" data-aos="fade-up">
            {{ $bookings->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

{{-- Styles --}}
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<style>
    /* Hero Section */
    .hero-bookings {
        background: linear-gradient(135deg, #6a11cb, #2575fc);
        border-radius: 0 0 30px 30px;
    }

    /* Pulsing animated title */
    .animate-title {
        animation: fadeIn 1s ease-in-out, pulse 3s infinite;
    }
    @keyframes pulse {
        0%   { text-shadow: 0 0 0px rgba(255,255,255,0.3); }
        50%  { text-shadow: 0 0 12px rgba(255,255,255,0.8); }
        100% { text-shadow: 0 0 0px rgba(255,255,255,0.3); }
    }

    /* Booking Card Styling */
    .booking-item {
        background: #fff;
        border-left: 6px solid #2575fc;
        transition: 0.3s ease;
    }
    .booking-item:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(0,0,0,0.15);
    }

    .booking-item h5 {
        font-size: 1.25rem;
    }

    .badge {
        font-size: 0.85rem;
    }

    /* Pagination styling */
    .pagination .page-item .page-link {
        border-radius: 12px;
        margin: 0 3px;
        color: #2575fc;
        font-weight: 500;
        transition: .3s;
    }
    .pagination .page-item.active .page-link {
        background: #2575fc;
        border-color: #2575fc;
        color: white;
        font-weight: bold;
        box-shadow: 0 0 8px rgba(37,117,252,0.4);
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