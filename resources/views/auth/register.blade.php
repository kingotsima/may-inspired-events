@extends('layouts.app')

@section('content')
<div class="login-wrapper d-flex align-items-center justify-content-center">
  <div class="register-card d-flex flex-column flex-md-row shadow-lg rounded-4 overflow-hidden w-100" style="max-width: 1100px;">

    <!-- Left Side -->
    <div class="register-left d-flex flex-column justify-content-between text-white p-5 flex-fill">
      <div class="brand-badge d-inline-flex align-items-center gap-2">
          <span class="brand-dot"></span>
          <span class="fw-semibold">MAY INSPIRED EVENTS</span>
      </div>

      <div class="mt-5">
          <h2 class="fw-bold mb-3 display-6">Create your Account</h2>
          <p class="lead opacity-75">Connect with vendors, book services, and start planning amazing events today!</p>

          <ul class="list-unstyled mt-4 small opacity-75">
              <li class="d-flex align-items-center gap-2 mb-2">
                  <i class="bi bi-check-circle-fill text-accent"></i> Book trusted vendors in minutes
              </li>
              <li class="d-flex align-items-center gap-2 mb-2">
                  <i class="bi bi-check-circle-fill text-accent"></i> Secure payments and simple refunds
              </li>
              <li class="d-flex align-items-center gap-2">
                  <i class="bi bi-check-circle-fill text-accent"></i> Smart dashboard for all your events
              </li>
          </ul>
      </div>

      <div class="small opacity-75">
          <span class="me-2"><i class="bi bi-shield-lock-fill"></i></span> Your data is protected
      </div>
    </div>

    <!-- Right Side (Form) -->
    <div class="register-right glass-card p-4 p-md-5 flex-fill">
        <h3 class="fw-bold mb-4 text-center">{{ __('Sign Up') }}</h3>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input id="name" type="text"
                    class="form-control nice-input @error('name') is-invalid @enderror"
                    name="name" value="{{ old('name') }}" placeholder="Enter your full name" required autofocus>
                @error('name')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input id="email" type="email"
                    class="form-control nice-input @error('email') is-invalid @enderror"
                    name="email" value="{{ old('email') }}" placeholder="you@example.com" required>
                @error('email')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3 position-relative">
                <label for="password" class="form-label">Password</label>
                <div class="input-group">
                    <input id="password" type="password"
                        class="form-control nice-input @error('password') is-invalid @enderror"
                        name="password" placeholder="Create a strong password" required>
                    <button type="button" class="btn btn-outline-light password-toggle" data-target="#password" aria-label="Toggle password">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
                @error('password')
                    <span class="invalid-feedback d-block">{{ $message }}</span>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-3 position-relative">
                <label for="password-confirm" class="form-label">Confirm Password</label>
                <div class="input-group">
                    <input id="password-confirm" type="password" class="form-control nice-input"
                        name="password_confirmation" placeholder="Re-enter your password" required>
                    <button type="button" class="btn btn-outline-light password-toggle" data-target="#password-confirm" aria-label="Toggle password">
                        <i class="bi bi-eye"></i>
                    </button>
                </div>
            </div>

            <!-- Terms -->
            <div class="form-check mb-4 small text-muted">
                <input class="form-check-input" type="checkbox" id="agree" required>
                <label class="form-check-label" for="agree">
                    I agree to the
                    <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal" class="text-decoration-none">Terms & Conditions</a>
                    and
                    <a href="#" data-bs-toggle="modal" data-bs-target="#privacyModal" class="text-decoration-none">Privacy Policy</a>
                </label>
            </div>

            <!-- Submit -->
            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-gradient fw-bold">
                    Join us →
                </button>
            </div>

            <!-- Social Logins -->
            <!-- <div class="text-center text-muted small mb-3">Or sign up with</div>
            <div class="d-flex gap-2 justify-content-center">
                <a href="#" class="btn btn-social rounded-pill px-3"><i class="bi bi-google me-2"></i>Google</a>
                <a href="#" class="btn btn-social rounded-pill px-3"><i class="bi bi-apple me-2"></i>Apple</a>
            </div> -->

            <!-- Already registered -->
            <div class="text-center text-muted small mt-4">
                Already have an account?
                <a href="{{ route('login') }}" class="text-decoration-none fw-semibold">Login</a>
            </div>
        </form>
    </div>
  </div>
</div>

<!-- Terms & Conditions Modal -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="termsModalLabel">Terms & Conditions</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Your full terms content stays here (copied from previous code) -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Privacy Policy Modal -->
<div class="modal fade" id="privacyModal" tabindex="-1" aria-labelledby="privacyModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="privacyModalLabel">Privacy Policy</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- Your full privacy content stays here (copied from previous code) -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

@push('styles')
<style>
:root {
    --primary-1:#4F46E5;
    --primary-2:#3B82F6;
    --accent:#7C3AED;
    --accent-2:#22D3EE;
}

.login-wrapper {
    padding-top:80px;
    min-height:100vh;
    background:url('https://images.pexels.com/photos/17057017/pexels-photo-17057017.jpeg') center/cover no-repeat fixed;
    position:relative;
}
.login-wrapper::before {
    content:""; position:absolute; inset:0;
    background:rgba(17,24,39,0.55);
    backdrop-filter:blur(2px);
}
.login-wrapper>* {position:relative; z-index:1;}

.glass-card {
    background:rgba(255,255,255,0.1);
    backdrop-filter:blur(16px);
    border-radius:1rem;
    border:1px solid rgba(255,255,255,0.25);
    color:#fff;
}
.glass-card h3 {color:#fff;}

.register-left {
    background:linear-gradient(180deg, rgba(79,70,229,.6), rgba(59,130,246,.7)),
               url('https://images.pexels.com/photos/33914522/pexels-photo-33914522.jpeg') center/cover no-repeat;
    position:relative; color:#fff;
}
.register-left::before {content:""; position:absolute; inset:0; background:rgba(0,0,0,.4);}
.register-left>*{position:relative; z-index:1;}

.brand-badge {
    background: rgba(255,255,255,.12);
    border: 1px solid rgba(255,255,255,.25);
    padding:.35rem .6rem;
    border-radius:999px;
}
.brand-dot {
    width:10px; height:10px; border-radius:50%;
    background:linear-gradient(135deg,var(--accent),var(--accent-2));
    display:inline-block;
}

.nice-input {
    border-radius:.7rem;
    border:1px solid rgba(255,255,255,0.3);
    background:rgba(255,255,255,0.15);
    color:#fff;
}
.nice-input::placeholder {color:rgba(255,255,255,0.55);}
.nice-input:focus {
    background:rgba(255,255,255,0.22);
    border-color:var(--primary-2);
    box-shadow:0 0 0 .25rem rgba(59,130,246,0.35);
    color:#fff;
}

.btn-gradient {
    background:linear-gradient(135deg,var(--primary-1),var(--primary-2));
    border:none; border-radius:.8rem;
    color:#fff; padding:.9rem;
    font-size:1.05rem;
    box-shadow:0 8px 18px rgba(59,130,246,0.45);
    transition:all .2s ease-in-out;
}
.btn-gradient:hover {
    transform:translateY(-2px);
    box-shadow:0 12px 26px rgba(59,130,246,0.55);
}

.btn-social {
    border:1px solid rgba(255,255,255,0.4);
    background:rgba(255,255,255,0.2);
    color:#fff; transition:.2s;
}
.btn-social:hover {
    background:rgba(255,255,255,0.3);
    border-color:var(--primary-2);
}

/* Make important links in register page white */
.register-right a,
.form-check-label a,
.register-right .text-center a {
    color: #fff !important;
}

.register-right a:hover,
.form-check-label a:hover,
.register-right .text-center a:hover {
    color: var(--primary-2) !important; /* blue accent */
    text-decoration: underline;
}

/* Mobile */
@media (max-width:768px){
    .register-card{flex-direction:column;}
    .register-left{min-height:220px; text-align:center;}
}
</style>
@endpush

@push('scripts')
<script>
document.querySelectorAll('.password-toggle').forEach(function(btn){
    btn.addEventListener('click', function(){
        const input = document.querySelector(this.getAttribute('data-target'));
        const icon = this.querySelector('i');
        if(!input) return;
        input.type = input.type === 'password' ? 'text' : 'password';
        icon.classList.toggle('bi-eye');
        icon.classList.toggle('bi-eye-slash');
    });
});
</script>
@endpush
@endsection