@extends('layouts.app')

@section('title', 'My Notifications')

@section('content')
<div class="notifications-page">

    <!-- Hero -->
    <section class="notif-hero text-white py-5 mb-5">
        <div class="container text-center" data-aos="zoom-in">
            <h1 class="fw-bold display-5">📬 My Notifications</h1>
            <p class="lead opacity-75">Stay updated with your latest activities</p>
        </div>
    </section>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold">Your Notifications</h4>
        @if($notifications->count())
            <form action="{{ route('notifications.readAll') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-sm btn-primary rounded-pill">
                    <i class="bi bi-check2-all me-1"></i> Mark All as Read
                </button>
            </form>
        @endif
        </div>
        @forelse($notifications as $notification)
            <div class="card notif-card mb-3 shadow border-0 rounded-4 {{ $notification->read_at ? '' : 'unread' }}" data-aos="fade-up">
                <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                    
                    <div class="mb-2 mb-md-0">
                        <p class="mb-1 fw-semibold">
                            <i class="bi {{ $notification->read_at ? 'bi-envelope-open' : 'bi-envelope-fill' }} text-{{ $notification->read_at ? 'secondary' : 'primary' }} me-2"></i>
                            {{ $notification->data['message'] ?? '' }}
                        </p>
                        
                        {{-- Extra info --}}
                        @if(isset($notification->data['event_name']))
                            <small class="text-muted">
                                Event: {{ $notification->data['event_name'] }} |
                                Status: {{ ucfirst($notification->data['status'] ?? '') }}
                            </small>
                        @elseif(isset($notification->data['service']))
                            <small class="text-muted">
                                Service: {{ $notification->data['service'] }} |
                                Ref: {{ $notification->data['reference'] }} |
                                Amount: ₦{{ number_format($notification->data['amount'] ?? 0, 2) }}
                            </small>
                        @endif
                    </div>

                    {{-- Mark as Read button --}}
                    @if(!$notification->read_at)
                        <form action="{{ route('notifications.read', $notification->id) }}" method="POST" class="ms-md-3">
                            @csrf
                            <button class="btn btn-sm btn-outline-success rounded-pill">Mark as Read</button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-5" data-aos="zoom-in">
                <i class="bi bi-bell-slash display-4 text-muted mb-3"></i>
                <p class="text-muted fs-5">You have no notifications at the moment.</p>
            </div>
        @endforelse

        {{-- Pagination --}}
        @if($notifications->hasPages())
            <div class="mt-5 d-flex justify-content-center" data-aos="fade-up">
                {{ $notifications->links('pagination::bootstrap-5') }}
            </div>
        @endif

    </div>
</div>

{{-- Styles + AOS --}}
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<style>
    /* Hero Section */
    .notif-hero {
        background: linear-gradient(135deg, #6a11cb, #2575fc);
        border-radius: 0 0 30px 30px;
    }

    /* Notification cards */
    .notif-card {
        transition: transform .3s ease, box-shadow .3s ease;
        border-left: 5px solid transparent;
    }
    .notif-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    .notif-card.unread {
        border-left: 5px solid #2575fc;
        box-shadow: 0 6px 20px rgba(37,117,252,0.2);
        background: rgba(37,117,252,0.05);
    }

    .notif-card p {
        margin-bottom: 0.25rem;
    }

    /* Pagination pills */
    .pagination .page-item .page-link {
        border-radius: 12px;
        margin: 0 4px;
        font-weight: 600;
        color: #2575fc;
        transition: 0.3s;
    }
    .pagination .page-item.active .page-link {
        background: #2575fc;
        border-color: #2575fc;
        color: #fff;
        box-shadow: 0 0 8px rgba(37,117,252,0.3);
    }
    .pagination .page-item .page-link:hover {
        background: #6a11cb;
        color: #fff;
    }

    @media(max-width:576px){
        .notif-card { font-size: 0.9rem; }
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
@endsection