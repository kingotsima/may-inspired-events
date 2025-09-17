@extends('layouts.app')

@section('title','All Bookings')

@section('content')
<div class="admin-bookings-page">

    <!-- Hero Section -->
    <section class="bookings-hero text-white py-5 mb-5">
        <div class="container text-center" data-aos="fade-down">
            <h1 class="fw-bold display-6">📚 All Bookings</h1>
            <p class="lead opacity-75">Manage and review all client bookings</p>
        </div>
    </section>

    <div class="container">

        <!-- Filters -->
        <div class="card shadow-sm border-0 rounded-4 mb-4" data-aos="fade-up">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.bookings.index') }}" class="row g-3">
                    <div class="col-md-3">
                        <input type="text" name="user" class="form-control form-control-lg shadow-sm" 
                               placeholder="Search by Client" value="{{ request('user') }}">
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="vendor" class="form-control form-control-lg shadow-sm" 
                               placeholder="Search by Vendor" value="{{ request('vendor') }}">
                    </div>
                    <div class="col-md-2">
                        <select name="status" class="form-select form-select-lg shadow-sm">
                            <option value="">All Status</option>
                            <option value="pending" @selected(request('status')==='pending')>Pending</option>
                            <option value="paid" @selected(request('status')==='paid')>Paid</option>
                            <option value="cancelled" @selected(request('status')==='cancelled')>Cancelled</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-grid">
                        <button class="btn btn-gradient btn-lg shadow-sm">🔍 Filter</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Bookings Table -->
        <div class="card shadow border-0 rounded-4" data-aos="fade-up">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Ref</th>
                                <th>Client</th>
                                <th>Vendor</th>
                                <th>Service</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookings as $booking)
                                <tr data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                                    <td><code>{{ $booking->reference }}</code></td>
                                    <td>{{ $booking->user->name }}</td>
                                    <td>{{ $booking->service->vendor->business_name ?? '-' }}</td>
                                    <td>{{ $booking->service->title }}</td>
                                    <td><strong>₦{{ number_format($booking->amount,2) }}</strong></td>
                                    <td>
                                        <span class="badge bg-{{ $booking->status=='paid'?'success':($booking->status=='pending'?'warning text-dark':'danger') }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $booking->created_at->format('d M Y') }}</td>
                                    <td>
                                        <a href="{{ route('admin.bookings.show',$booking) }}" class="btn btn-sm btn-outline-primary rounded-pill">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        <i class="bi bi-inbox fs-3"></i>
                                        <p class="mb-0">No bookings found</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-4 d-flex justify-content-center" data-aos="fade-up">
            {{ $bookings->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
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

    /* Filter Card */
    .btn-gradient {
        background: linear-gradient(135deg,#36d1dc,#5b86e5);
        color:#fff !important;
        border: none;
        border-radius: 10px;
        font-weight: 600;
        transition: .3s;
    }
    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0,0,0,.2);
    }

    /* Table Styling */
    .table {
        border-collapse: separate;
        border-spacing: 0 6px;
    }
    .table thead {
        font-size: 0.95rem;
        text-transform: uppercase;
    }
    .table-hover tbody tr:hover {
        background: rgba(37,117,252,0.05);
    }

    /* Badges */
    .badge {
        font-size: 0.8rem;
        padding: 0.45em 0.8em;
    }

    /* Pagination */
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
        box-shadow: 0 0 8px rgba(37,117,252,0.3);
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