@extends('layouts.app')

@section('title', 'Terms & Conditions')

@section('content')
<div class="container py-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-5">
            <h1 class="fw-bold mb-4">📜 Terms & Conditions</h1>
            <p class="text-muted">Last updated: {{ now()->toFormattedDateString() }}</p>

            <h4 class="mt-4">1. Introduction</h4>
            <p>
                Welcome to May Inspired Events! These Terms & Conditions outline the rules and
                regulations for the use of our platform. By creating an account, you
                agree to comply with them.
            </p>

            <h4 class="mt-4">2. User Responsibilities</h4>
            <ul>
                <li>You must provide accurate and complete information when registering.</li>
                <li>You are responsible for keeping your account secure.</li>
                <li>You may not use the platform for fraudulent or illegal activities.</li>
            </ul>

            <h4 class="mt-4">3. Payments & Bookings</h4>
            <p>
                All payments for events, services, or bookings are made directly to the
                <strong>Admin of May Inspired Events</strong>. After successful payment, the Admin will
                remit the vendor’s share according to the agreed arrangement.  
            </p>
            <p>
                May Inspired Events charges a <strong>10% commission</strong> on every successful
                booking. This means the vendor will receive <strong>90% of the booking
                amount</strong> after deduction of the commission.
            </p>

            <h4 class="mt-4">4. Privacy</h4>
            <p>
                Your data is handled according to our
                <a href="{{ route('privacy') }}">Privacy Policy</a>. We do not sell or
                share your personal information without consent.
            </p>

            <h4 class="mt-4">5. Termination</h4>
            <p>
                We reserve the right to suspend or terminate accounts that violate our terms.
            </p>

            <h4 class="mt-4">6. Contact</h4>
            <p>
                If you have questions about these Terms, please contact us at
                <a href="mailto:kingotsima@gmail.com">kingotsima@gmail.com</a>.
            </p>

            <div class="mt-5">
                <a href="{{ route('register') }}" class="btn btn-dark rounded-pill px-4">← Back to Register</a>
            </div>
        </div>
    </div>
</div>
@endsection
