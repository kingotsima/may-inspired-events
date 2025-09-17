<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'May Inspired Events'))</title>

    <!-- Bootstrap CSS & Icons -->
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    @stack('styles')
    <style>
        :root {
            --bg: #f5f6fa;
            --brand: #ffc107;
            --dark: #212529;
            --transition: 0.3s ease-in-out;
        }

        html, body { height: 100%; }

        body {
            background: var(--bg);
            font-family: "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            padding-top: 110px; /* space for fixed navbar */
        }

        /* Default pages get padding-top for navbar */
        body { padding-top: 120px; }
        @media (max-width: 992px) { body { padding-top: 150px; } }

        /* Auth & Home overrides */
        body.auth-page,
        body.home-page {
        padding-top: 0 !important; /* remove navbar spacing */
        }

        /* === Gradient Navbar === */
        .custom-navbar {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            padding: 0.9rem 2rem;
            border-radius: 50px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.25);

            position: fixed;
            top: 20px; left: 50%;
            transform: translateX(-50%);
            z-index: 1100;

            min-width: 70%;
            max-width: 95%;
        }

        .custom-navbar .navbar-brand {
            font-size: 1.4rem;
            font-weight: 700;
            color: #fff !important;
        }

        .custom-navbar .nav-link {
            color: rgba(255,255,255,0.85) !important;
            font-weight: 500;
            padding: 0.6rem 1.4rem;
            border-radius: 30px;
            transition: 0.3s;
            white-space: nowrap;
        }

        .custom-navbar .nav-link:hover,
        .custom-navbar .nav-link.active {
            color: #fff !important;
            background: rgba(255,255,255,0.15);
            box-shadow: 0 3px 10px rgba(0,0,0,0.15);
        }

        /* Notification Icon */
        .nav-icon {
            position: relative;
            font-size: 1.4rem;
            color: #fff !important;
            margin-left: 1.2rem;
            transition: transform 0.25s;
        }
        .nav-icon:hover { transform: scale(1.15); }
        .nav-icon .badge {
            position: absolute;
            top: -6px;
            right: -10px;
            font-size: 0.65rem;
            padding: 0.3em 0.5em;
            border-radius: 50%;
            background: #ffc107;
            color: #111;
            font-weight: bold;
        }

        /* Dropdown */
        .custom-navbar .dropdown-menu {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 6px 25px rgba(0,0,0,0.2);
        }
        .custom-navbar .dropdown-item:hover {
            background: rgba(0,0,0,0.05);
        }

        .navbar-toggler { border: none; }
        .navbar-toggler-icon { filter: invert(1); }

        /* Alerts */
        .alert { border-radius: .5rem; box-shadow: 0 3px 10px rgba(0,0,0,0.1); }

        /* Pulse Animation */
        @keyframes bellPulse {
            0%   { transform: scale(1); }
            50%  { transform: scale(1.15) rotate(-10deg); }
            70%  { transform: scale(1.15) rotate(10deg); }
            100% { transform: scale(1); }
        }
        .nav-icon.pulse {
            animation: bellPulse 1.5s infinite;
            transform-origin: top center;
        }

        /* Footer */
        .custom-footer {
            background: linear-gradient(135deg, #0f0c29, #302b63, #24243e);
            color: #fff;
            border-top-left-radius: 40px;
            border-top-right-radius: 40px;
            margin-top: 3rem;
            box-shadow: 0 -5px 20px rgba(0,0,0,0.3);
        }

        .custom-footer a { color: #ffc107; transition: 0.3s; }
        .custom-footer a:hover { color: #fff; }

        .social-icon {
            display:flex;align-items:center;justify-content:center;
            width:36px;height:36px;
            border-radius:50%;
            background:rgba(255,255,255,0.1);
            color:#fff;font-size:1.1rem;
            transition:0.3s;
        }
        .social-icon:hover { background:#ffc107; color:#111; }

        .footer-bottom {
            background: rgba(0,0,0,0.2);
            border-top: 1px solid rgba(255,255,255,0.1);
        }

        @media (max-width: 992px) {
            .custom-navbar { min-width: 90%; }
            .navbar-nav { text-align:center; }
        }

        body { padding-top: 120px; }
        @media (max-width: 992px) { body { padding-top: 150px; } }

        main.container { padding-bottom: 4rem; }
        .custom-footer { margin-top: 4rem; }

        /* Default: keep brand and hamburger neat in one row */
        .custom-navbar .navbar-brand {
        font-size: 1.35rem;
        font-weight: 700;
        white-space: nowrap;
        }

        /* Adjustments for small screens */
        @media (max-width: 576px) {
        .custom-navbar {
            padding: 0.6rem 1rem;          /* slightly tighter navbar padding */
        }
        .custom-navbar .navbar-brand {
            font-size: 1rem;               /* shrink the brand text */
        }
        .custom-navbar .navbar-toggler {
            padding: 0.2rem 0.35rem;       /* make hamburger button smaller */
            font-size: 0.9rem;
            line-height: 1;
        }
        .custom-navbar .navbar-toggler-icon {
            width: 1.2rem;
            height: 1.2rem;                /* shrink actual hamburger icon */
        }
        }

        /* For very small phones (iPhone SE etc.) */
        @media (max-width: 400px) {
        .custom-navbar .navbar-brand {
            font-size: 0.9rem;
        }
        .custom-navbar .navbar-toggler-icon {
            width: 1rem;
            height: 1rem;
        }
        }

        /* Container for floating alerts */
        .alert-container {
            position: fixed;
            top: 100px;              /* just below navbar (adjust if needed) */
            left: 50%;
            transform: translateX(-50%);
            z-index: 2000;           /* above everything */
            width: 90%;
            max-width: 600px;
        }

        /* Alert style */
        .custom-alert {
            border-radius: 12px !important;
            padding: 1rem 1.25rem;
            font-size: 0.95rem;
            font-weight: 500;
            margin-bottom: 0.75rem;
            color: #fff;
            opacity: 0.95;
            transition: all 0.4s ease-in-out;
        }

        .custom-alert.alert-success {
            background: linear-gradient(135deg,#4caf50,#43a047);
        }
        .custom-alert.alert-danger {
            background: linear-gradient(135deg,#f44336,#e53935);
        }
        .custom-alert .btn-close {
            filter: invert(1); /* make close button white */
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100 
    {{ request()->routeIs('login') || request()->routeIs('register') ? 'auth-page' : (request()->is('/') ? 'home-page' : '') }}">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg custom-navbar">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'May Inspired Events') }}
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                {{-- Public Links --}}
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('about') ? 'active' : '' }}" href="{{ url('/about') }}">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('contact') ? 'active' : '' }}" href="{{ url('/contact') }}">Contact</a>
                </li>

                {{-- Guest Links --}}
                @guest
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('login') ? 'active' : '' }}" href="{{ route('login') }}">Login</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('register') ? 'active' : '' }}" href="{{ route('register') }}">Register</a></li>
                @endguest

                {{-- Authenticated User Links --}}
                @auth
                    {{-- User Dashboard Dropdown --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDashboardMenu" data-bs-toggle="dropdown">User Dashboard</a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item {{ request()->routeIs('client.dashboard') ? 'active' : '' }}" 
                                href="{{ route('client.dashboard') }}">
                                    🏠 Dashboard
                                </a>
                            </li>
                            <li><a class="dropdown-item {{ request()->routeIs('services.*') ? 'active' : '' }}" href="{{ route('services.index') }}">Services</a></li>
                            <li><a class="dropdown-item {{ request()->routeIs('vendors.index') ? 'active' : '' }}" href="{{ route('vendors.index') }}">Vendors</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.booking.event.form') }}">Book Event</a></li>
                            @unless(Auth::user()->vendor)
                                <li><a class="dropdown-item" href="{{ route('vendor.apply') }}">Become a Vendor</a></li>
                            @endunless
                            <li><a class="dropdown-item" href="{{ route('client.bookings') }}">My Bookings</a></li>
                        </ul>
                    </li>
                @endauth

                {{-- Vendor & Admin roles (same as you already have) --}}
                @role('Vendor')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="vendorMenu" data-bs-toggle="dropdown">Vendor Panel</a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('vendor.dashboard') }}">🏠 Dashboard</a></li>
                            <li><a class="dropdown-item" href="{{ route('vendor.services.index') }}">My Services</a></li>
                            <li><a class="dropdown-item" href="{{ route('vendor.bookings') }}">Bookings</a></li>
                        </ul>
                    </li>
                @endrole

                @role('Admin')
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="adminMenu" data-bs-toggle="dropdown">Admin Panel</a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.vendors.index') }}">Vendors</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.bookings.index') }}">Service Bookings</a></li>
                            <li><a class="dropdown-item" href="{{ route('checkin.index') }}">Check-in</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.event-bookings.index') }}">Event Bookings</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.testimonials.index') }}">Manage Testimonials</a></li>
                        </ul>
                    </li>
                @endrole

                {{-- Profile + Logout --}}
                @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userMenu" data-bs-toggle="dropdown">
                            {{ explode(' ', Auth::user()->name)[0] }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('profile.show') }}">Profile</a></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endauth
            </ul>


            <!-- Notification Bell -->
            @auth
            <ul class="navbar-nav ms-3">
                <li class="nav-item">
                @php $notifCount = Auth::user()->unreadNotifications->count(); @endphp
                    <a href="{{ route('notifications.index') }}" class="nav-icon {{ $notifCount > 0 ? 'pulse' : '' }}">
                        <i class="bi bi-bell"></i>
                        @if($notifCount > 0)
                            <span class="badge">{{ $notifCount }}</span>
                        @endif
                    </a>
                </li>
            </ul>
            @endauth
        </div>
    </div>
</nav>

<!-- Main Content -->
<main class="{{ request()->is('/') || request()->routeIs('login') || request()->routeIs('register') ? 'p-0' : 'container' }} flex-grow-1">

    <!-- Floating Alerts -->
    <div class="alert-container">
        @if (session('success'))
            <div class="custom-alert alert-success shadow-lg d-flex align-items-center justify-content-between animate__animated animate__fadeInDown">
                <div>
                    <i class="bi bi-check-circle-fill me-2"></i>
                    {{ session('success') }}
                </div>
                <button type="button" class="btn-close ms-2" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="custom-alert alert-danger shadow-lg d-flex align-items-center justify-content-between animate__animated animate__fadeInDown">
                <div>
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    {{ session('error') }}
                </div>
                <button type="button" class="btn-close ms-2" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    @yield('content')

</main>

<!-- Footer -->
<footer class="custom-footer mt-auto">
    <div class="container py-5">
        <div class="row">
            <div class="col-md-3 mb-4 text-center text-md-start">
                <h5 class="fw-bold">{{ config('app.name', 'May Inspired Events') }}</h5>
                <p class="small text-light opacity-75">Plan your events with ease. Connect with vendors, book, and pay securely.</p>
            </div>
            <div class="col-md-3 mb-4 text-center text-md-start">
                <h6 class="fw-semibold text-uppercase text-light">Quick Links</h6>
                <ul class="list-unstyled">
                    <li><a href="{{ url('/') }}" class="footer-link text-decoration-none">Home</a></li>
                    <li><a href="{{ url('/about') }}" class="footer-link text-decoration-none">About</a></li>
                    <li><a href="{{ url('/contact') }}" class="footer-link text-decoration-none">Contact</a></li>
                    <li><a href="#" data-bs-toggle="modal" data-bs-target="#termsModal" class="footer-link text-decoration-none">Terms & Conditions</a></li>
                    <li><a href="#" data-bs-toggle="modal" data-bs-target="#privacyModal" class="footer-link text-decoration-none">Privacy Policy</a></li>
                </ul>
            </div>
            <div class="col-md-3 mb-4 text-center text-md-start">
                <h6 class="fw-semibold text-uppercase text-light">Contact</h6>
                <ul class="list-unstyled text-light small">
                    <li><i class="bi bi-geo-alt-fill me-2"></i> New York, USA</li>
                    <li><i class="bi bi-envelope-fill me-2"></i> kingotsima@gmail.com</li>
                    <li><i class="bi bi-telephone-fill me-2"></i> +1 234 567 890</li>
                </ul>
            </div>
            <div class="col-md-3 mb-4 text-center text-md-start">
                <h6 class="fw-semibold text-uppercase text-light">Subscribe</h6>
                <div class="d-flex gap-2 justify-content-center justify-content-md-start">
                    <a href="#" class="social-icon"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="social-icon"><i class="bi bi-twitter"></i></a>
                    <a href="#" class="social-icon"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="social-icon"><i class="bi bi-linkedin"></i></a>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom text-center py-3 small text-light opacity-75">
        &copy; {{ date('Y') }} {{ config('app.name', 'May Inspired Events') }}. All rights reserved.  
        <span class="d-block d-md-inline mt-1">| Designed by <strong>Simonbenedict Marvellous .O.</strong></span>
    </div>
</footer>

<!-- Terms & Conditions Modal -->
<div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="termsModalLabel">Terms & Conditions</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h6>1. Acceptance of Terms</h6>
        <p>By accessing or using our platform, you agree to comply with these Terms & Conditions. If you do not agree, you may not use the platform.</p>

        <h6>2. User Responsibilities</h6>
        <p>You agree to provide accurate information when registering and using the platform. Misuse of the platform, fraudulent activities, or violation of any policies may lead to suspension or termination of your account.</p>

        <h6>3. Event Bookings and Services</h6>
        <p>All bookings and services are subject to availability. Users are expected to read event details carefully before making payments.</p>

        <h6>4. Payments</h6>
        <p>All payments are made directly to the <strong>Admin</strong> through the platform. The Admin will then remit the agreed amount to the Vendor or Event Organizer after deducting a <strong>10% commission</strong> as service charges. The Admin is not responsible for any disputes arising outside the platform.</p>

        <h6>5. Refunds and Cancellations</h6>
        <p>Refund requests must be made in line with the event organizer’s policy. The platform only facilitates payments and does not guarantee refunds unless expressly stated.</p>

        <h6>6. Liability</h6>
        <p>The Admin is not liable for damages, losses, or disputes arising between Vendors and Clients beyond the agreed remittance terms. Vendors are solely responsible for delivering their services as described.</p>

        <h6>7. Modifications</h6>
        <p>We reserve the right to update these Terms & Conditions at any time. Continued use of the platform indicates acceptance of the updated terms.</p>
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
        <h6>1. Information We Collect</h6>
        <p>We collect personal details such as name, email, phone number, and payment information when you use our services.</p>

        <h6>2. Use of Information</h6>
        <p>Your information is used to process bookings, communicate with you, improve our platform, and ensure smooth transactions.</p>

        <h6>3. Sharing of Information</h6>
        <p>We do not sell or rent your information. However, we may share necessary details with event organizers or vendors to complete your bookings.</p>

        <h6>4. Data Protection</h6>
        <p>We implement industry-standard security measures to protect your personal data. However, we cannot guarantee complete security due to risks associated with online transactions.</p>

        <h6>5. Cookies</h6>
        <p>Our website uses cookies to enhance user experience, track activity, and provide personalized services.</p>

        <h6>6. Changes to Privacy Policy</h6>
        <p>We may update this Privacy Policy from time to time. Users will be notified of significant changes via email or platform notifications.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    setTimeout(() => {
        document.querySelectorAll('.custom-alert').forEach(el => {
            el.classList.add('animate__fadeOutUp');
            setTimeout(() => el.remove(), 600); // remove after fade
        });
    }, 5000); // 5 seconds
});
</script>
@stack('scripts')
</body>
</html>
