@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="admin-dashboard container-fluid py-4">

    <!-- Title -->
    <div class="text-center mb-5" data-aos="fade-down">
        <h2 class="fw-bold display-6 text-primary">📊 Admin Dashboard</h2>
        <p class="text-muted">Overview of revenue, bookings, users, and vendor stats</p>
    </div>

    <!-- Revenue & Booking Summary -->
    <div class="row g-4 mb-4">
        <div class="col-md-3" data-aos="zoom-in">
            <div class="card dash-card text-white shadow-sm h-100" style="background: linear-gradient(45deg, #0d6efd, #0a58ca);">
                <div class="card-body">
                    <i class="bi bi-cash-stack fs-1 mb-2"></i>
                    <h6 class="text-uppercase small">Total Revenue</h6>
                    <h3 class="fw-bold">₦{{ number_format($totalRevenue,2) }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3" data-aos="zoom-in" data-aos-delay="100">
            <div class="card dash-card text-white shadow-sm h-100" style="background: linear-gradient(45deg, #198754, #0f5132);">
                <div class="card-body">
                    <i class="bi bi-journal-check fs-1 mb-2"></i>
                    <h6 class="text-uppercase small">Total Bookings</h6>
                    <h3 class="fw-bold">{{ $totalBookings }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3" data-aos="zoom-in" data-aos-delay="200">
            <div class="card dash-card text-white shadow-sm h-100" style="background: linear-gradient(45deg, #20c997, #0c5460);">
                <div class="card-body">
                    <i class="bi bi-credit-card-2-front fs-1 mb-2"></i>
                    <h6 class="text-uppercase small">Paid Bookings</h6>
                    <h3 class="fw-bold">{{ $paidBookings }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3" data-aos="zoom-in" data-aos-delay="300">
            <div class="card dash-card text-white shadow-sm h-100" style="background: linear-gradient(45deg, #ffc107, #b58105);">
                <div class="card-body">
                    <i class="bi bi-hourglass-split fs-1 mb-2"></i>
                    <h6 class="text-uppercase small">Pending Bookings</h6>
                    <h3 class="fw-bold">{{ $pendingBookings }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Users, Vendors & Services -->
    <div class="row g-4 mb-4">
        <div class="col-md-4" data-aos="fade-up">
            <div class="card border-0 shadow-sm h-100 dash-card2">
                <div class="card-body text-center">
                    <i class="bi bi-people fs-2 text-primary mb-2"></i>
                    <h6 class="text-uppercase small text-muted">Users</h6>
                    <h3 class="fw-bold text-dark">{{ $totalUsers }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
            <div class="card border-0 shadow-sm h-100 dash-card2">
                <div class="card-body text-center">
                    <i class="bi bi-shop fs-2 text-success mb-2"></i>
                    <h6 class="text-uppercase small text-muted">Vendors</h6>
                    <h3 class="fw-bold text-dark">{{ $totalVendors }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
            <div class="card border-0 shadow-sm h-100 dash-card2">
                <div class="card-body text-center">
                    <i class="bi bi-tools fs-2 text-warning mb-2"></i>
                    <h6 class="text-uppercase small text-muted">Services</h6>
                    <h3 class="fw-bold text-dark">{{ $totalServices }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Revenue Chart -->
    <div class="card shadow-sm border-0 rounded-4" data-aos="fade-up">
        <div class="card-body">
            <h5 class="fw-bold mb-3">📈 Revenue (Last 7 Days)</h5>
            <canvas id="revenueChart" height="120"></canvas>
        </div>
    </div>

</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<style>
    .dash-card {
        border-radius: 16px;
        transition: transform .3s ease, box-shadow .3s ease;
    }
    .dash-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 28px rgba(0,0,0,0.25) !important;
    }
    .dash-card2 {
        border-radius: 14px;
        transition: transform .3s ease, box-shadow .3s ease;
    }
    .dash-card2:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.15) !important;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    AOS.init({
        duration: 900,
        once: true,
        offset: 80
    });

    const ctx = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($revenueByDay->keys()) !!},
            datasets: [{
                label: 'Revenue',
                data: {!! json_encode($revenueByDay->values()) !!},
                borderColor: '#6a11cb',
                backgroundColor: 'rgba(106, 17, 203, 0.15)',
                tension: 0.4,
                fill: true,
                borderWidth: 2,
                pointBackgroundColor: '#2575fc',
                pointBorderColor: '#fff',
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false } },
                y: { ticks: { callback: val => '₦' + val } }
            }
        }
    });
</script>
@endpush