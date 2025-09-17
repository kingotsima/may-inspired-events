@extends('layouts.app')

@section('title', 'Privacy Policy')

@section('content')
<div class="container py-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body p-5">
            <h1 class="fw-bold mb-4">🔒 Privacy Policy</h1>
            <p class="text-muted">Last updated: {{ now()->toFormattedDateString() }}</p>

            <h4 class="mt-4">1. Information We Collect</h4>
            <p>
                We collect personal details such as your name, email, phone number, and
                payment information to provide you with event services.
            </p>

            <h4 class="mt-4">2. How We Use Information</h4>
            <p>
                Your information is used to process bookings, confirm payments, and
                communicate with you regarding your account and events.
            </p>

            <h4 class="mt-4">3. Sharing of Information</h4>
            <p>
                We do not sell your data. Limited information may be shared with vendors
                only to fulfill bookings. Payments are processed securely via Paystack.
            </p>

            <h4 class="mt-4">4. Data Security</h4>
            <p>
                We use secure encryption and modern technologies to keep your information safe.
            </p>

            <h4 class="mt-4">5. Your Rights</h4>
            <p>
                You may request deletion of your account or data by contacting us at
                <a href="mailto:kingotsima@gmail.com">kingotsima@gmail.com</a>.
            </p>

            <div class="mt-5">
                <a href="{{ route('register') }}" class="btn btn-dark rounded-pill px-4">← Back to Register</a>
            </div>
        </div>
    </div>
</div>
@endsection
