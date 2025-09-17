@extends('layouts.app')

@section('content')

<div class="login-wrapper d-flex align-items-center justify-content-center">

    <div class="login-card d-flex flex-column flex-md-row shadow-lg rounded-4 overflow-hidden w-100" style="max-width: 960px;">
        
        <!-- Left Side (Form Section) -->
        <div class="login-left glass-card p-4 p-md-5 flex-fill">
            <h3 class="fw-bold mb-4 text-center">{{ __('Sign In') }}</h3>
            
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input id="email" type="email" 
                        class="form-control nice-input @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" 
                        required autofocus placeholder="you@example.com">
                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" type="password" 
                        class="form-control nice-input @error('password') is-invalid @enderror"
                        name="password" required placeholder="••••••••">
                    @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Remember + Forgot -->
                <div class="d-flex justify-content-between align-items-center mb-3 small text-muted">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" 
                            name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">Remember me</label>
                    </div>
                    @if (Route::has('password.request'))
                        <a class="text-decoration-none fw-semibold" href="{{ route('password.request') }}">
                            Forgot Password?
                        </a>
                    @endif
                </div>

                <!-- Submit -->
                <div class="d-grid mb-3">
                    <button type="submit" class="btn btn-gradient fw-bold">
                        Sign In
                    </button>
                </div>

                <!-- Social Logins -->
                <!-- <div class="text-center text-muted small mb-3">Or sign in with</div>
                <div class="d-flex gap-2 justify-content-center">
                    <a href="#" class="btn btn-social rounded-pill px-3">
                        <i class="bi bi-google me-2"></i> Google
                    </a>
                    <a href="#" class="btn btn-social rounded-pill px-3">
                        <i class="bi bi-apple me-2"></i> Apple
                    </a>
                </div> -->

                <!-- Register Redirect -->
                <div class="text-center text-muted small mt-4">
                    Don’t have an account? 
                    <a href="{{ route('register') }}" class="text-decoration-none fw-semibold">Register</a>
                </div>
            </form>
        </div>

        <!-- Right Side (Image + Overlay) -->
        <div class="login-right d-flex flex-column justify-content-center text-white p-5 flex-fill">
            <div>
                <h2 class="fw-bold mb-3">Welcome Back!</h2>
                <p class="lead">Easily manage your events, bookings, and vendors.</p>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    /* --- GLOBAL PALETTE --- */
    :root {
        --primary-1:#4F46E5; /* Indigo 600 */
        --primary-2:#3B82F6; /* Blue 500 */
    }

    /* Start below navbar */
    .login-wrapper {
        padding-top: 80px; /* Adjust if your navbar is taller */
        min-height: 100vh;
        background: url('https://images.pexels.com/photos/17057017/pexels-photo-17057017.jpeg') center/cover no-repeat fixed;
        position: relative;
    }
    .login-wrapper::before {
        content:"";
        position:absolute; inset:0;
        background: rgba(17,24,39,0.55); /* dark overlay for readability */
        backdrop-filter: blur(2px);
    }
    .login-wrapper > * { position: relative; z-index: 1; }

    /* Glass style card */
    .glass-card {
        background: rgba(255,255,255,0.1);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border-radius: 1rem;
        border: 1px solid rgba(255,255,255,0.25);
        color:#fff;
    }
    .glass-card h3 { color:#fff; }

    /* Inputs */
    .nice-input {
        border-radius: .7rem;
        border:1px solid rgba(255,255,255,0.3);
        background: rgba(255,255,255,0.15);
        color:#fff;
    }
    .nice-input::placeholder { color:rgba(255,255,255,0.55); }
    .nice-input:focus {
        background:rgba(255,255,255,0.22);
        border-color:var(--primary-2);
        box-shadow:0 0 0 .25rem rgba(59,130,246,0.35);
        color:#fff;
    }

    /* Main login button */
    .btn-gradient {
        background: linear-gradient(135deg,var(--primary-1),var(--primary-2));
        border:none;
        border-radius:.8rem;
        color:#fff;
        padding:.9rem;
        font-size:1.05rem;
        box-shadow:0 8px 18px rgba(59,130,246,0.45);
        transition: all .2s ease-in-out;
    }
    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow:0 12px 26px rgba(59,130,246,0.55);
    }

    /* Social Buttons */
    .btn-social {
        border:1px solid rgba(255,255,255,0.4);
        background:rgba(255,255,255,0.2);
        color:#fff;
        transition:.2s;
    }
    .btn-social:hover {
        background:rgba(255,255,255,0.3);
        border-color:var(--primary-2);
    }

    /* Right side image overlay stays */
    .login-right {
        background: linear-gradient(180deg, rgba(79,70,229,.6), rgba(59,130,246,.7)),
                    url('https://images.pexels.com/photos/17057017/pexels-photo-17057017.jpeg') center/cover no-repeat;
        position: relative;
    }
    .login-right > * { position: relative; z-index: 1; }

    /* Make the helper links inside login white */
    .login-left a {
        color: #fff !important;
    }

    .login-left a:hover {
        color: var(--primary-2) !important; /* nice blue accent on hover */
        text-decoration: underline;
    }

    @media(max-width:768px){
        .login-card{flex-direction:column;}
        .login-right{min-height:220px; text-align:center;}
    }
</style>
@endpush

@endsection