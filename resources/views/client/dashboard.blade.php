@extends('layouts.app')

@section('title', 'Client Dashboard')

@section('content')
<div class="client-dashboard">

    <!-- Hero Section -->
    <section class="hero-client text-center text-white py-5 mb-5">
        <div class="container" data-aos="fade-down">
            <h1 class="fw-bold display-5 mb-3 animate-title">
                Welcome to Your User Dashboard, {{ strtok(Auth::user()->name, ' ') }} 🎉
            </h1>
            <p class="lead opacity-75">
                Manage your bookings, payments, services, and vendor journey all in one place.
            </p>
        </div>
    </section>

    <div class="container">
        {{-- Stats Section --}}
        <div class="row g-4 mb-4">
            <!-- Bookings -->
            <div class="col-md-4" data-aos="fade-up">
                <div class="stat-card text-center p-4 rounded-4 shadow-lg bg-white h-100">
                    <div class="mb-2 text-primary fs-2"><i class="bi bi-calendar-check"></i></div>
                    <h5 class="fw-semibold">My Bookings</h5>
                    <h2 class="fw-bold text-primary">{{ Auth::user()->bookings()->count() }}</h2>
                    <p class="text-muted small">Total bookings made</p>
                </div>
            </div>

            <!-- Payments -->
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-card text-center p-4 rounded-4 shadow-lg bg-white h-100">
                    <div class="mb-2 text-success fs-2"><i class="bi bi-cash-coin"></i></div>
                    <h5 class="fw-semibold">Payments</h5>
                    <h2 class="fw-bold text-success">
                        ₦{{ number_format(Auth::user()->bookings()->where('status','paid')->sum('amount'), 2) }}
                    </h2>
                    <p class="text-muted small">Total amount paid</p>
                </div>
            </div>

            <!-- Services Booked -->
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-card text-center p-4 rounded-4 shadow-lg bg-white h-100">
                    <div class="mb-2 text-info fs-2"><i class="bi bi-tools"></i></div>
                    <h5 class="fw-semibold">Services Booked</h5>
                    <h2 class="fw-bold text-info">{{ Auth::user()->bookings()->where('type', 'service')->count() }}</h2>
                    <p class="text-muted small">Total services booked</p>
                </div>
            </div>
        </div>

        {{-- Quick Actions + Recent Bookings --}}
        <div class="row g-4">
            <!-- Quick Actions -->
            <div class="col-md-6" data-aos="fade-right">
                <div class="card shadow-lg rounded-4 border-0 h-100">
                    <div class="card-body">
                        <h5 class="card-title mb-3 fw-bold">⚡ Quick Actions</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <a href="{{ route('admin.booking.event.form') }}" class="text-decoration-none">📅 Book an Event</a>
                            </li>
                            <li class="list-group-item">
                                <a href="{{ route('client.bookings') }}" class="text-decoration-none">🎟 My Bookings</a>
                            </li>
                            <li class="list-group-item">
                                <a href="{{ route('services.index') }}" class="text-decoration-none">🛠 Explore Services</a>
                            </li>
                            <li class="list-group-item">
                                <a href="{{ route('vendors.index') }}" class="text-decoration-none">🏪 Browse Vendors</a>
                            </li>
                            @unless(Auth::user()->vendor)
                            <li class="list-group-item">
                                <a href="{{ route('vendor.apply') }}" class="text-decoration-none">🚀 Become a Vendor</a>
                            </li>
                            @endunless
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Recent Bookings -->
            <div class="col-md-6" data-aos="fade-left">
                <div class="card shadow-lg rounded-4 border-0 h-100">
                    <div class="card-body">
                        <h5 class="card-title mb-3 fw-bold">🆕 Recent Bookings</h5>
                        @php
                            $recentBookings = Auth::user()->bookings()->latest()->take(5)->get();
                        @endphp
                        @if($recentBookings->count() > 0)
                            <ul class="list-group list-group-flush">
                                @foreach($recentBookings as $booking)
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <div>
                                            @if($booking->type === 'service')
                                                <strong>{{ $booking->service->title ?? 'Service' }}</strong>
                                                <small class="text-muted"> | ₦{{ number_format($booking->amount) }}</small>
                                            @else
                                                <strong>{{ $booking->details['event_name'] ?? 'Admin Event' }}</strong>
                                                <small class="text-muted">
                                                    | Date: {{ \Carbon\Carbon::parse($booking->details['event_date'])->format('d M, Y') ?? 'N/A' }}
                                                    | ₦{{ number_format($booking->amount) }} (Admin Event)
                                                </small>
                                            @endif
                                        </div>
                                        <span class="badge bg-{{ $booking->status === 'paid' || $booking->status === 'approved' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-muted mb-0">No bookings yet.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Styles --}}
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<style>
    .hero-client {
        background: linear-gradient(135deg, #6a11cb, #2575fc);
        border-radius: 0 0 30px 30px;
    }
    .animate-title {
        animation: fadeIn 1s ease-in-out, pulse 3s infinite;
    }
    @keyframes pulse {
        0% { text-shadow: 0 0 0 rgba(255,255,255,0.3); }
        50% { text-shadow: 0 0 15px rgba(255,255,255,0.8); }
        100% { text-shadow: 0 0 0 rgba(255,255,255,0.3); }
    }
    .stat-card {
        border-left: 6px solid #2575fc20;
        transition: .3s;
    }
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.12) !important;
    }
    .list-group-item {
        border: none;
        padding: 0.8rem 0;
    }
    .list-group-item a {
        display: flex;
        align-items: center;
        font-weight: 500;
        color: #333;
        transition: .2s;
    }
    .list-group-item a:hover {
        color: #2575fc;
        transform: translateX(4px);
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
