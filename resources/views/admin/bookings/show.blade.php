@extends('layouts.app')

@section('title','Booking Details')

@section('content')
<div class="booking-details-page">

    <!-- Hero Section -->
    <section class="booking-hero text-white py-5 mb-5">
        <div class="container text-center" data-aos="fade-down">
            <h1 class="fw-bold display-6">📑 Booking Details</h1>
            <p class="opacity-75">Full information about this booking</p>
        </div>
    </section>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="zoom-in">
                <div class="card shadow-lg border-0 rounded-4 overflow-hidden mb-4">
                    <div class="card-body p-4">

                        <div class="mb-3">
                            <h5 class="fw-bold text-primary">Booking Reference</h5>
                            <p><code class="fw-semibold">{{ $booking->reference }}</code></p>
                        </div>

                        <hr>

                        <div class="mb-3">
                            <h5 class="fw-bold text-primary">Client</h5>
                            <p>{{ $booking->user->name }} <small class="text-muted">({{ $booking->user->email }})</small></p>
                        </div>

                        <hr>

                        <div class="mb-3">
                            <h5 class="fw-bold text-primary">Vendor</h5>
                            <p>{{ $booking->service->vendor->business_name ?? '-' }}</p>
                        </div>

                        <hr>

                        <div class="mb-3">
                            <h5 class="fw-bold text-primary">Service</h5>
                            <p>{{ $booking->service->title }}</p>
                        </div>

                        <hr>

                        <div class="mb-3">
                            <h5 class="fw-bold text-primary">Amount</h5>
                            <p class="fw-semibold text-success">₦{{ number_format($booking->amount,2) }}</p>
                        </div>

                        <hr>

                        <div class="mb-3">
                            <h5 class="fw-bold text-primary">Status</h5>
                            <span class="badge bg-{{ $booking->status=='paid'?'success':($booking->status=='pending'?'warning text-dark':'danger') }} px-3 py-2 fs-6">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </div>

                        <hr>

                        <div class="mb-3">
                            <h5 class="fw-bold text-primary">Booking Date</h5>
                            <p>{{ $booking->created_at->toDayDateTimeString() }}</p>
                        </div>

                    </div>
                </div>

                <div class="text-center">
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-gradient px-4">
                        ← Back to list
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

    /* Card */
    .card {
        border-radius: 16px;
        transition: transform .3s ease, box-shadow .3s ease;
    }
    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 25px rgba(0,0,0,.15);
    }

    /* Gradient Button */
    .btn-gradient {
        background: linear-gradient(135deg, #36d1dc, #5b86e5);
        color: #fff !important;
        border: none;
        border-radius: 12px;
        font-weight: 500;
        transition: .3s;
    }
    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0,0,0,.2);
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
AOS.init({ duration: 900, once: true, offset: 60 });
</script>
@endpush