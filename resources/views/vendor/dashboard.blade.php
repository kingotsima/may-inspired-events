@extends('layouts.app')

@section('title', 'Vendor Dashboard')

@section('content')
<div class="vendor-dashboard">

    <!-- Hero Section -->
    <section class="hero-dashboard text-center text-white py-5 mb-5">
        <div class="container" data-aos="fade-down">
            <h1 class="fw-bold display-5 mb-3 animate-title">🏠 Vendor Dashboard</h1>
            <p class="lead opacity-75">Welcome, {{ Auth::user()->name }} — manage services, bookings, and more.</p>
        </div>
    </section>

    <div class="container">
        <!-- Main Dashboard Cards -->
        <div class="row g-4" data-aos="fade-up">

            {{-- Services Card --}}
            <div class="col-md-3">
                <div class="dash-card shadow-lg border-0 h-100 rounded-4 p-3">
                    <div class="d-flex flex-column justify-content-between h-100">
                        <div>
                            <h5 class="fw-bold text-primary">My Services</h5>
                            <p class="text-muted small">View, add, or edit all your services.</p>
                        </div>
                        <a href="{{ route('vendor.services.index') }}" class="btn btn-primary btn-sm shadow-sm">Manage Services</a>
                    </div>
                </div>
            </div>

            {{-- Bookings Card --}}
            <div class="col-md-3">
                <div class="dash-card shadow-lg border-0 h-100 rounded-4 p-3">
                    <div class="d-flex flex-column justify-content-between h-100">
                        <div>
                            <h5 class="fw-bold text-success">Bookings</h5>
                            <p class="text-muted small">Track upcoming bookings & requests.</p>
                        </div>
                        <a href="{{ route('vendor.bookings') }}" class="btn btn-success btn-sm shadow-sm">View Bookings</a>
                    </div>
                </div>
            </div>

            {{-- Quick Actions Card --}}
            <div class="col-md-3">
                <div class="dash-card shadow-lg border-0 h-100 rounded-4 p-3">
                    <div class="h-100 d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="fw-bold text-info">Quick Actions</h5>
                            <p class="text-muted small">Add services or update your availability.</p>
                        </div>
                        <div class="d-flex flex-column gap-2">
                            <a href="{{ route('vendor.services.create') }}" class="btn btn-outline-primary btn-sm shadow-sm">➕ Add Service</a>
                            <a href="{{ route('vendor.availability') }}" class="btn btn-outline-warning btn-sm shadow-sm">🗓 Update Availability</a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Profile Card --}}
            <div class="col-md-3">
                <div class="dash-card shadow-lg border-0 h-100 rounded-4 p-3 text-center">
                    <div class="d-flex flex-column justify-content-between h-100">
                        <div>
                            <div class="mb-3">
                                <i class="bi bi-person-circle fs-1 text-primary"></i>
                            </div>
                            <h5 class="fw-bold">My Profile</h5>
                            <p class="text-muted small">Edit vendor details & contact info.</p>
                        </div>
                        <a href="{{ route('vendor.profile.edit') }}" class="btn btn-outline-secondary btn-sm shadow-sm">✏ Edit Profile</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Availability Summary -->
        <div class="row g-4 mt-4" data-aos="fade-up">
            <div class="col-md-6">
                <div class="dash-card shadow-lg border-0 rounded-4 p-4">
                    <h5 class="fw-bold text-primary">🗓 My Availability</h5>
                    @if($availability)
                        <p class="text-muted mb-0">
                            <strong>Days:</strong> 
                            {{ is_array($availability->available_days) ? implode(', ', $availability->available_days) : $availability->available_days }}<br>
                            
                            <strong>Time:</strong> {{ $availability->start_time }} – {{ $availability->end_time }}<br>
                            
                            @if(!empty($availability->unavailable_dates))
                                <strong>Unavailable:</strong>
                                {{ is_array($availability->unavailable_dates) ? implode(', ', $availability->unavailable_dates) : $availability->unavailable_dates }}
                            @endif
                        </p>
                    @else
                        <p class="text-muted">You haven’t set your availability yet.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="mt-5" data-aos="fade-up">
            <h4 class="fw-bold mb-3">📌 Recent Activity</h4>
            <div class="list-group shadow-sm rounded-4">
                @forelse($recentActivities ?? [] as $activity)
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span>{{ $activity->description }}</span>
                        <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                    </div>
                @empty
                    <div class="list-group-item text-muted">No recent activity.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

{{-- Styles --}}
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<style>
    /* Hero Banner */
    .hero-dashboard {
        background: linear-gradient(130deg, #6a11cb, #2575fc);
        border-radius: 0 0 30px 30px;
        animation: fadeInDown 1s ease-out;
    }

    .animate-title {
        animation: fadeIn 1s ease-in-out, pulse 3s infinite;
    }
    @keyframes pulse {
        0%   { text-shadow: 0 0 0px rgba(255,255,255,0.4); }
        50%  { text-shadow: 0 0 15px rgba(255,255,255,0.8); }
        100% { text-shadow: 0 0 0px rgba(255,255,255,0.4); }
    }

    /* Dashboard Cards */
    .dash-card {
        min-height: 200px;
        transition: .3s;
    }
    .dash-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.12);
    }

    /* Buttons */
    .btn {
        border-radius: 10px;
        transition: 0.25s;
    }
    .btn:hover {
        transform: translateY(-2px);
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