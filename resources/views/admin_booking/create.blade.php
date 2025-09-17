@extends('layouts.app')

@section('title','Create Event Booking')

@section('content')
<div class="admin-create-booking-page">

    <!-- Hero -->
    <section class="booking-hero text-white py-5 mb-5">
        <div class="container text-center" data-aos="fade-down">
            <h1 class="fw-bold display-6">📝 Create Event Booking</h1>
            <p class="opacity-75">Fill out the form below to create a new booking</p>
        </div>
    </section>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8" data-aos="zoom-in">

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="alert alert-danger rounded-3 shadow-sm">
                        <strong>⚠️ Please fix the following errors:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Card Form -->
                <div class="card shadow-lg border-0 rounded-4 p-4 booking-form-card">
                    <form action="{{ route('admin.event-bookings.store') }}" method="POST">
                        @csrf

                        <!-- Select User -->
                        <div class="mb-3">
                            <label for="user_id" class="form-label fw-semibold">Select User</label>
                            <select name="user_id" id="user_id" class="form-select form-select-lg shadow-sm" required>
                                <option value="">-- Select User --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Event Name -->
                        <div class="mb-3">
                            <label for="event_name" class="form-label fw-semibold">Event Name</label>
                            <input type="text" name="event_name" id="event_name" class="form-control form-control-lg shadow-sm" placeholder="Enter event name" required>
                        </div>

                        <!-- Event Date -->
                        <div class="mb-3">
                            <label for="event_date" class="form-label fw-semibold">Event Date</label>
                            <input type="date" name="event_date" id="event_date" class="form-control form-control-lg shadow-sm" required>
                        </div>

                        <!-- Guests -->
                        <div class="mb-3">
                            <label for="guests" class="form-label fw-semibold">Number of Guests</label>
                            <input type="number" name="guests" id="guests" class="form-control form-control-lg shadow-sm" min="1" required>
                        </div>

                        <!-- Budget -->
                        <div class="mb-3">
                            <label for="budget" class="form-label fw-semibold">Budget (₦)</label>
                            <input type="number" step="0.01" name="budget" id="budget" class="form-control form-control-lg shadow-sm" min="0" required>
                        </div>

                        <!-- Details -->
                        <div class="mb-3">
                            <label for="details" class="form-label fw-semibold">Additional Details</label>
                            <textarea name="details" id="details" class="form-control shadow-sm" rows="4" placeholder="Optional additional info"></textarea>
                        </div>

                        <!-- Actions -->
                        <div class="d-flex justify-content-between gap-3 mt-4">
                            <button type="submit" class="btn btn-success btn-lg rounded-pill px-4 fw-bold shadow-sm">
                                ✅ Create Booking
                            </button>
                            <a href="{{ route('admin.event-bookings.index') }}" class="btn btn-outline-secondary btn-lg rounded-pill px-4 fw-bold">
                                Cancel
                            </a>
                        </div>
                    </form>
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
    .booking-form-card {
        border-radius: 20px;
        transition: transform .3s ease, box-shadow .3s ease;
    }
    .booking-form-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }

    /* Fancy inputs */
    .form-control, .form-select {
        border-radius: 12px;
        padding: .75rem 1rem;
    }
    .form-control:focus, .form-select:focus {
        border-color: #2575fc;
        box-shadow: 0 0 0 .25rem rgba(37,117,252,0.25);
    }

    /* Buttons */
    .btn-success {
        background: linear-gradient(135deg,#28a745,#218838);
        border: none;
        transition: .3s;
    }
    .btn-success:hover {
        background: linear-gradient(135deg,#218838,#1e7e34);
        transform: translateY(-2px);
    }
    .btn-outline-secondary {
        border-width: 2px;
        transition: .2s;
    }
    .btn-outline-secondary:hover {
        background: #f8f9fa;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
AOS.init({
    duration: 900,
    once: true,
    offset: 70
});
</script>
@endpush