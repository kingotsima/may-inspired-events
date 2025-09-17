@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
<div class="d-flex justify-content-center align-items-center min-vh-100 reset-bg">

    <!-- Floating Card -->
    <div class="reset-card shadow-lg p-4 p-md-5 rounded-4">
        
        <!-- Icon / Header -->
        <div class="text-center mb-4">
            <div class="icon-circle mx-auto mb-3 d-flex align-items-center justify-content-center">
                <i class="bi bi-key-fill fs-2 text-purple"></i>
            </div>
            <h3 class="fw-bold">Reset Password</h3>
            <p class="text-muted small">Set your new password below.</p>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <!-- Email -->
            <div class="form-floating mb-3">
                <input id="email" type="email" 
                       class="form-control @error('email') is-invalid @enderror" 
                       name="email" value="{{ $email ?? old('email') }}" 
                       required autofocus placeholder="Email">
                <label for="email">Email Address</label>
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <!-- Password -->
            <div class="form-floating mb-3">
                <input id="password" type="password" 
                       class="form-control @error('password') is-invalid @enderror" 
                       name="password" required placeholder="Password">
                <label for="password">New Password</label>
                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <!-- Confirm Password -->
            <div class="form-floating mb-4">
                <input id="password-confirm" type="password" 
                       class="form-control" 
                       name="password_confirmation" required placeholder="Confirm Password">
                <label for="password-confirm">Confirm Password</label>
            </div>

            <!-- Button -->
            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-purple btn-lg fw-semibold shadow-sm">
                    <i class="bi bi-arrow-repeat me-1"></i> Reset Password
                </button>
            </div>

            <div class="text-center text-muted small">
                Remembered? 
                <a href="{{ route('login') }}" class="fw-semibold text-purple text-decoration-none">Login</a>
            </div>
        </form>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<style>
    /* Clean animated gradient background */
    .reset-bg {
        background: linear-gradient(135deg, #f8faff, #eef3ff);
    }

    /* Floating Card (centered only) */
    .reset-card {
        background: #fff;
        max-width: 420px;
        width: 100%;
        animation: floaty 4s ease-in-out infinite;
        border-radius: 16px;
    }
    @keyframes floaty {
        0%, 100% { transform: translateY(0px); }
        50%      { transform: translateY(-8px); }
    }

    /* Icon circle */
    .icon-circle {
        width: 65px; height: 65px; border-radius: 50%;
        background: rgba(108, 99, 255, 0.1);
    }
    .text-purple { color: #6c63ff; }

    /* Buttons */
    .btn-purple {
        background: linear-gradient(135deg,#6c63ff,#2575fc);
        border: none; border-radius: 12px;
        color: #fff !important;
        transition: 0.3s ease;
    }
    .btn-purple:hover {
        background: linear-gradient(135deg,#5647d1,#1d63d3);
        transform: scale(1.02);
        box-shadow: 0 8px 18px rgba(0,0,0,0.12);
    }

    /* Inputs */
    .form-control {
        border-radius: 10px;
    }
    .form-control:focus {
        border-color: #6c63ff;
        box-shadow: 0 0 0 0.2rem rgba(108,99,255,0.2);
    }
</style>
@endpush
@endsection