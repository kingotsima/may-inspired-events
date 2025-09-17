@extends('layouts.app')

@section('title','Admin Event Booking Details')

@section('content')
<div class="admin-event-booking-details-page">

    <!-- Hero Section -->
    <section class="booking-hero text-white py-5 mb-5">
        <div class="container text-center" data-aos="fade-down">
            <h1 class="fw-bold display-6">📑 Event Booking Details</h1>
            <p class="opacity-75">View and manage the details of this booking</p>
        </div>
    </section>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="zoom-in">

                <!-- Booking Details Card -->
                <div class="card shadow-lg border-0 rounded-4 overflow-hidden mb-4">
                    <div class="card-header bg-light fw-bold">
                        Booking #{{ $booking->id }}
                    </div>
                    <div class="card-body p-4">

                        <div class="mb-3">
                            <h6 class="fw-bold text-muted">User</h6>
                            <p>{{ $booking->user->name ?? 'N/A' }}</p>
                        </div>
                        <hr>

                        <div class="mb-3">
                            <h6 class="fw-bold text-muted">Event Name</h6>
                            <p>{{ $booking->event_name }}</p>
                        </div>
                        <hr>

                        <div class="mb-3">
                            <h6 class="fw-bold text-muted">Event Date</h6>
                            <p>{{ \Carbon\Carbon::parse($booking->event_date)->format('d M Y') }}</p>
                        </div>
                        <hr>

                        <div class="mb-3">
                            <h6 class="fw-bold text-muted">Number of Guests</h6>
                            <p>{{ $booking->guests ?? 'N/A' }}</p>
                        </div>
                        <hr>

                        <div class="mb-3">
                            <h6 class="fw-bold text-muted">Budget</h6>
                            <p class="fw-semibold">{{ $booking->budget ? '₦'.number_format($booking->budget,2) : 'N/A' }}</p>
                        </div>
                        <hr>

                        <div class="mb-3">
                            <h6 class="fw-bold text-muted">Amount Paid</h6>
                            <p class="fw-semibold text-success">{{ $booking->amount ? '₦'.number_format($booking->amount,2) : 'N/A' }}</p>
                        </div>
                        <hr>

                        <div class="mb-3">
                            <h6 class="fw-bold text-muted">Status</h6>
                            <span class="badge px-3 py-2 fs-6
                                @if($booking->status === 'pending') bg-warning text-dark
                                @elseif($booking->status === 'approved') bg-success
                                @elseif($booking->status === 'rejected') bg-danger
                                @else bg-secondary @endif">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </div>
                        <hr>

                        <div class="mb-3">
                            <h6 class="fw-bold text-muted">Details</h6>
                            <p>{{ $booking->details ?? 'N/A' }}</p>
                        </div>

                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex justify-content-between gap-3" data-aos="fade-up">
                    <a href="{{ route('admin.event-bookings.create') }}" class="btn btn-gradient fw-semibold">
                        <i class="bi bi-plus-circle"></i> Create New Booking
                    </a>
                    <a href="{{ route('admin.event-bookings.index') }}" class="btn btn-outline-secondary fw-semibold rounded-pill">
                        ← Back to Bookings
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<style>
    /* Hero */
    .booking-hero {
        background: linear-gradient(135deg, #6a11cb, #2575fc);
        border-radius: 0 0 30px 30px;
    }

    /* Card Styling */
    .card {
        border-radius: 18px;
        transition: transform .3s ease, box-shadow .3s ease;
    }
    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 28px rgba(0,0,0,.15);
    }

    /* Gradient CTA button */
    .btn-gradient {
        background: linear-gradient(135deg, #36d1dc, #5b86e5);
        color: #fff !important;
        border-radius: 12px;
        border: none;
        transition: .3s;
    }
    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0,0,0,.2);
    }

    .btn-outline-secondary {
        border-width: 2px;
        transition: .3s;
    }
    .btn-outline-secondary:hover {
        background: #f0f0f0;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
AOS.init({ duration: 900, once: true, offset: 70 });
</script>
@endpush