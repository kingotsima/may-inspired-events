@extends('layouts.app')

@section('title', 'Update Availability')

@section('content')
<div class="availability-page">

    <!-- Hero Section -->
    <section class="hero-availability text-center text-white py-5 mb-5">
        <div class="container" data-aos="fade-down">
            <h1 class="fw-bold display-5 mb-3 animate-title">🗓 Update Availability</h1>
            <p class="lead opacity-75">Set your working hours and manage unavailable dates for your services.</p>
        </div>
    </section>

    <div class="container">
        <!-- Availability Card -->
        <div class="availability-card shadow-lg p-4 rounded-4 bg-white" data-aos="fade-up">
            <form action="{{ route('vendor.availability.update') }}" method="POST" class="row gy-4">
                @csrf
                @method('PUT')

                {{-- Weekly schedule --}}
                <div class="col-12">
                    <label class="form-label fw-semibold">Available Days</label>
                    <select name="available_days[]" class="form-select form-select-lg shadow-sm" multiple required>
                        @foreach(['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'] as $day)
                            <option value="{{ $day }}"
                                @if(isset($availability) && in_array($day, $availability->available_days ?? [])) selected @endif>
                                {{ $day }}
                            </option>
                        @endforeach
                    </select>
                    <small class="text-muted">Hold Ctrl (Cmd on Mac) to select multiple days.</small>
                </div>

                {{-- Time range --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Start Time</label>
                    <input type="time" name="start_time" class="form-control form-control-lg shadow-sm" 
                           value="{{ $availability->start_time ?? '' }}" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">End Time</label>
                    <input type="time" name="end_time" class="form-control form-control-lg shadow-sm" 
                           value="{{ $availability->end_time ?? '' }}" required>
                </div>

                {{-- Unavailable dates --}}
                <div class="col-12">
                    <label class="form-label fw-semibold">Unavailable Dates</label>
                    <input type="text" id="unavailable_dates" name="unavailable_dates[]" 
                           class="form-control form-control-lg shadow-sm" 
                           value="{{ isset($availability->unavailable_dates) ? implode(',', $availability->unavailable_dates) : '' }}">
                    <small class="text-muted">Select dates when you cannot provide services.</small>
                </div>

                <div class="col-12 d-grid mt-2">
                    <button type="submit" class="btn btn-primary btn-lg shadow-sm">
                        <i class="bi bi-save"></i> Save Availability
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Styles --}}
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<style>
    /* Hero Banner */
    .hero-availability {
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

    /* Availability Card */
    .availability-card {
        transition: .3s;
        border-radius: 18px;
    }
    .availability-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.12);
    }

    /* Form inputs */
    .form-control, .form-select {
        border-radius: 12px;
        padding: 14px 16px;
        font-size: 1rem;
    }
    .form-control:focus, .form-select:focus {
        border-color: #2575fc;
        box-shadow: 0 0 0 .2rem rgba(37,117,252,0.3);
    }

    /* Save Button */
    .btn-primary {
        font-weight: bold;
        border-radius: 12px;
        transition: 0.3s;
    }
    .btn-primary:hover {
        background: #6a11cb;
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(0,0,0,0.2);
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

    // Flatpickr integration (if installed)
    const unavailableInput = document.getElementById('unavailable_dates');
    let selectedDates = unavailableInput.value ? unavailableInput.value.split(',') : [];

    if (window.flatpickr) {
        flatpickr("#unavailable_dates", {
            mode: "multiple",
            dateFormat: "Y-m-d",
            defaultDate: selectedDates
        });
    }
</script>
@endpush
@endsection