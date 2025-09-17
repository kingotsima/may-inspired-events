@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')
<div class="d-flex justify-content-center align-items-center min-vh-100 forgot-bg">

    <div class="forgot-card shadow-sm p-4 p-md-5 rounded-4 bg-white text-center">
        
        <!-- Icon -->
        <div class="icon-circle mx-auto mb-3 d-flex align-items-center justify-content-center">
            <i class="bi bi-key-fill fs-2 text-purple"></i>
        </div>

        <!-- Title & Subtitle -->
        <h3 class="fw-bold mb-1">Forget password?</h3>
        <p class="text-muted small mb-4">We’ll send you the updated instructions shortly.</p>

        <!-- Flash Message -->
        @if (session('status'))
            <div class="alert alert-success small rounded-3 shadow-sm">{{ session('status') }}</div>
        @endif

        <!-- Reset Form -->
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="mb-3 text-start">
                <label for="email" class="form-label small fw-semibold">Email</label>
                <input id="email" type="email"
                       class="form-control form-control-lg @error('email') is-invalid @enderror"
                       name="email" value="{{ old('email') }}" placeholder="Enter your email" required autofocus>
                @error('email')
                <div class="invalid-feedback small">{{ $message }}</div>
                @enderror
            </div>

            <!-- Submit -->
            <div class="d-grid mt-4">
                <button type="submit" class="btn btn-purple btn-lg fw-semibold">
                    Reset password
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Styles --}}
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<style>
    /* Background with floating dots feel */
    .forgot-bg {
        background: #fdfdff;
    }

    body {
        margin: 0 !important;
        background: #fdfdff;
    }

    /* Card */
    .forgot-card {
        width: 100%;
        max-width: 420px;
        border: 1px solid #eee;
    }

    /* Purple Accent */
    .text-purple { color: #6c63ff; }
    .btn-purple {
        background: #6c63ff;
        border: none;
        border-radius: 10px;
        color: #fff !important;
        transition: 0.3s;
    }
    .btn-purple:hover {
        background: #574fd1;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0,0,0,0.15);
    }

    /* Icon Circle */
    .icon-circle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: rgba(108, 99, 255, 0.1);
    }

    .form-control {
        border-radius: 10px;
        font-size: 0.95rem;
    }
    .form-control:focus {
        border-color: #6c63ff;
        box-shadow: 0 0 0 0.15rem rgba(108, 99, 255, 0.25);
    }
</style>
@endpush
@endsection