@extends('layouts.app')

@section('title','QR Code Check-in')

@section('content')
<div class="checkin-page">

    <!-- Hero -->
    <section class="checkin-hero text-white py-5 mb-5">
        <div class="container text-center" data-aos="fade-down">
            <h1 class="fw-bold display-6">🎟️ QR Code Check-in</h1>
            <p class="lead opacity-75">Scan guest tickets quickly and verify instantly</p>
        </div>
    </section>

    <div class="container d-flex justify-content-center">
        <div class="card shadow-lg border-0 rounded-4 p-4 text-center" style="max-width:400px;" data-aos="zoom-in">
            <h5 class="fw-bold mb-4 text-primary">Scanner</h5>
            <div id="reader" class="scanner border rounded-3"></div>
            <p id="result" class="mt-4 fw-semibold fs-6"></p>
        </div>
    </div>

</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<style>
    /* Hero */
    .checkin-hero {
        background: linear-gradient(135deg, #6a11cb, #2575fc);
        border-radius: 0 0 30px 30px;
    }

    /* Scanner Box */
    #reader {
        width: 100% !important;
        min-height: 300px;
        margin: 0 auto;
    }
    .scanner {
        box-shadow: 0 0 12px rgba(37,117,252,0.3);
        background: #fafafa;
    }

    /* Success/Failure Message */
    #result span {
        padding: 0.5rem 1rem;
        border-radius: 8px;
        display: inline-block;
        font-weight: 600;
        animation: fadePulse .6s ease-in-out;
    }

    @keyframes fadePulse {
        from { opacity: 0; transform: scale(0.9); }
        to   { opacity: 1; transform: scale(1); }
    }
</style>
@endpush

@push('scripts')
<script src="https://unpkg.com/html5-qrcode"></script>
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
    AOS.init({ duration: 900, once: true, offset: 70 });

    function onScanSuccess(decodedText, decodedResult) {
        fetch("{{ route('checkin.verify') }}", {
            method: "POST",
            headers: {
                "Content-Type":"application/json",
                "X-CSRF-TOKEN":"{{ csrf_token() }}"
            },
            body: JSON.stringify({ reference: decodedText })
        })
        .then(res => res.json())
        .then(data => {
            let result = document.getElementById("result");
            if(data.status === 'success') {
                result.innerHTML = `<span class="bg-success text-white">${data.message} (${data.client})</span>`;
            } else {
                result.innerHTML = `<span class="bg-danger text-white">${data.message}</span>`;
            }
        });
    }

    new Html5QrcodeScanner("reader", { fps: 10, qrbox: 250 }).render(onScanSuccess);
</script>
@endpush