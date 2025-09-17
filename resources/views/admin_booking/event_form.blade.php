@extends('layouts.app')

@section('title', 'Book Admin for Event')

@section('content')
<div class="book-event-page">

    <!-- Hero Section -->
    <section class="event-hero text-white py-5 mb-5">
        <div class="container text-center" data-aos="fade-down">
            <h1 class="fw-bold display-5">🎉 Book Admin to Host Your Event</h1>
            <p class="lead opacity-75">Plan weddings, birthdays, and special occasions with ease</p>
        </div>
    </section>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-10 col-md-8 col-lg-6" data-aos="zoom-in">
                <div class="card booking-card shadow-lg border-0 p-4 rounded-4">

                    {{-- Alerts --}}
                    @if ($errors->any())
                        <div class="alert alert-danger small rounded-3 shadow-sm mb-4">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if(session('success'))
                        <div class="alert alert-success small rounded-3 shadow-sm mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Form --}}
                    <form action="{{ route('admin.booking.event') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="event_name" class="form-label fw-semibold">Event Name</label>
                            <input type="text" class="form-control form-control-lg shadow-sm" name="event_name" placeholder="e.g. Wedding, Birthday" required>
                        </div>

                        <div class="mb-3">
                            <label for="event_date" class="form-label fw-semibold">Event Date</label>
                            <input type="date" class="form-control form-control-lg shadow-sm" name="event_date" required>
                        </div>

                        <div class="mb-3">
                            <label for="guests" class="form-label fw-semibold">Number of Guests</label>
                            <input type="number" class="form-control form-control-lg shadow-sm" name="guests" placeholder="e.g. 100" required>
                        </div>

                        <div class="mb-3">
                            <label for="budget" class="form-label fw-semibold">Budget (₦)</label>
                            <input type="number" step="0.01" class="form-control form-control-lg shadow-sm" name="budget" placeholder="e.g. 500000" required>
                        </div>

                        <div class="mb-3">
                            <label for="details" class="form-label fw-semibold">Additional Details</label>
                            <textarea class="form-control shadow-sm" name="details" rows="4" placeholder="Enter any extra information about the event"></textarea>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-gradient btn-lg fw-bold">
                                <i class="bi bi-send"></i> Submit Booking
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

{{-- Styles --}}
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<style>
    .event-hero {
        background: linear-gradient(135deg, #6a11cb, #2575fc);
        border-radius: 0 0 30px 30px;
    }
    .booking-card {
        border-radius: 20px;
        background: #fff;
        transition: transform .3s ease, box-shadow .3s ease;
    }
    .booking-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.15);
    }
    .form-control {
        border-radius: 12px;
        padding: .75rem 1rem;
    }
    .form-control:focus {
        border-color: #2575fc;
        box-shadow: 0 0 0 0.25rem rgba(37,117,252,0.25);
    }
    .btn-gradient {
        background: linear-gradient(135deg, #36d1dc, #5b86e5);
        color: #fff !important;
        border: none;
        border-radius: 12px;
        transition: .3s ease;
    }
    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0,0,0,0.2);
    }
</style>
@endpush

{{-- AOS --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 900,
        once: true,
        offset: 60
    });
</script>
@endpush
@endsection