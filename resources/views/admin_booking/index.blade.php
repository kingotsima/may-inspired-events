@extends('layouts.app')

@section('title','Admin Event Bookings')

@section('content')
<div class="admin-event-bookings-page">

    <!-- Hero Header -->
    <section class="bookings-hero text-white py-5 mb-5">
        <div class="container text-center" data-aos="fade-down">
            <h1 class="fw-bold display-6">🎉 Admin Event Bookings</h1>
            <p class="lead opacity-75">Manage all event bookings submitted by users</p>
        </div>
    </section>

    <div class="container">

        <!-- Top Controls -->
        <div class="mb-4 d-flex justify-content-between align-items-center" data-aos="fade-up">
            <h4 class="fw-bold text-primary mb-0">All Bookings</h4>
            <a href="{{ route('admin.event-bookings.create') }}" class="btn btn-gradient fw-semibold">
                <i class="bi bi-plus-circle"></i> Create New Booking
            </a>
        </div>

        <!-- Bookings Table -->
        @if($bookings->count())
            <div class="card shadow-sm border-0 rounded-4" data-aos="fade-up">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle table-hover">
                            <thead class="table-light fw-semibold text-uppercase small">
                                <tr>
                                    <th>#</th>
                                    <th>User</th>
                                    <th>Event Name</th>
                                    <th>Event Date</th>
                                    <th>Guests</th>
                                    <th>Budget</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookings as $booking)
                                <tr data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                                    <td>{{ $booking->id }}</td>
                                    <td>{{ $booking->user->name ?? 'N/A' }}</td>
                                    <td>{{ $booking->event_name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($booking->event_date)->format('d M Y') }}</td>
                                    <td>{{ $booking->guests ?? '-' }}</td>
                                    <td>{{ $booking->budget ? '₦'.number_format($booking->budget,2) : '-' }}</td>
                                    <td>{{ $booking->amount ? '₦'.number_format($booking->amount,2) : '-' }}</td>
                                    <td>
                                        <span class="badge 
                                            @if($booking->status == 'pending') bg-warning text-dark
                                            @elseif($booking->status == 'approved') bg-success
                                            @elseif($booking->status == 'rejected') bg-danger
                                            @else bg-secondary
                                            @endif">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $booking->created_at->format('d M Y H:i') }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.event-bookings.show',$booking->id) }}" 
                                           class="btn btn-sm btn-outline-primary rounded-pill mb-1">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                        @if($booking->status == 'pending')
                                            <form action="{{ route('admin.event-bookings.approve', $booking->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success rounded-pill mb-1">
                                                    <i class="bi bi-check-circle"></i> Approve
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.event-bookings.reject', $booking->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger rounded-pill mb-1">
                                                    <i class="bi bi-x-circle"></i> Reject
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <div class="mt-4 d-flex justify-content-center" data-aos="fade-up">
                {{ $bookings->links('pagination::bootstrap-5') }}
            </div>
        @else
            <div class="alert alert-info text-center shadow-sm rounded py-4" data-aos="zoom-in">
                <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                No admin event bookings found.
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<style>
    /* Hero */
    .bookings-hero {
        background: linear-gradient(135deg, #6a11cb, #2575fc);
        border-radius: 0 0 30px 30px;
    }

    /* Gradient CTA Button */
    .btn-gradient {
        background: linear-gradient(135deg, #36d1dc, #5b86e5);
        color: #fff !important;
        border: none;
        border-radius: 12px;
        transition: .3s;
    }
    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0,0,0,.2);
    }

    /* Table */
    .table {
        border-collapse: separate;
        border-spacing: 0 6px;
    }
    .table-hover tbody tr:hover {
        background: rgba(37,117,252,0.05);
    }
    .table thead th {
        font-size: 0.85rem;
        letter-spacing: 0.5px;
    }

    .badge {
        font-size: 0.8rem;
        padding: 0.45em 0.75em;
    }

    /* Pagination Pills */
    .pagination .page-item .page-link {
        border-radius: 12px;
        margin: 0 4px;
        color: #2575fc;
        font-weight: 600;
    }
    .pagination .page-item.active .page-link {
        background: #2575fc;
        border-color: #2575fc;
        color: #fff;
        box-shadow: 0 0 10px rgba(37,117,252,0.3);
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