@extends('layouts.app')

@section('title', 'Manage Vendors')

@section('content')
<div class="manage-vendors-page">

    <!-- Hero Section -->
    <section class="vendor-hero text-white py-5 mb-5">
        <div class="container text-center" data-aos="fade-down">
            <h1 class="fw-bold display-5">📋 Manage Vendors</h1>
            <p class="lead opacity-75">Review, approve, or reject vendor applications</p>
        </div>
    </section>

    <div class="container">

        {{-- Alerts --}}
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert" data-aos="fade-down">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row g-4">
            @forelse($vendors as $vendor)
                <div class="col-12 col-sm-6 col-md-4" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="card vendor-card shadow-sm h-100 border-0 rounded-4">
                        <div class="card-body d-flex flex-column">

                            <h5 class="card-title fw-bold text-dark mb-2">
                                <i class="bi bi-shop text-primary me-1"></i>
                                {{ $vendor->business_name }}
                            </h5>

                            <p class="mb-1">
                                <i class="bi bi-person me-1 text-secondary"></i>
                                <strong>User:</strong> {{ $vendor->user->name }}
                            </p>
                            <p class="mb-1">
                                <i class="bi bi-envelope text-muted me-1"></i>
                                <small>{{ $vendor->user->email }}</small>
                            </p>

                            <p class="mb-2">
                                <span class="badge 
                                    @if($vendor->verification_status == 'approved') bg-success
                                    @elseif($vendor->verification_status == 'rejected') bg-danger
                                    @elseif($vendor->verification_status == 'suspended') bg-secondary
                                    @else bg-warning text-dark @endif">
                                    {{ ucfirst($vendor->verification_status) }}
                                </span>
                            </p>

                            <!-- Action Buttons -->
                            <div class="mt-auto d-flex flex-wrap gap-2">
                                @if($vendor->verification_status == 'pending')
                                    <form action="{{ route('admin.vendors.approve', $vendor) }}" method="POST">@csrf
                                        <button class="btn btn-success btn-sm w-100">Approve</button>
                                    </form>
                                    <form action="{{ route('admin.vendors.reject', $vendor) }}" method="POST">@csrf
                                        <button class="btn btn-danger btn-sm w-100">Reject</button>
                                    </form>
                                @elseif($vendor->verification_status == 'approved')
                                    <form action="{{ route('admin.vendors.suspend', $vendor) }}" method="POST">@csrf
                                        <button class="btn btn-warning btn-sm w-100">Suspend</button>
                                    </form>
                                @elseif($vendor->verification_status == 'suspended')
                                    <form action="{{ route('admin.vendors.restore', $vendor) }}" method="POST">@csrf
                                        <button class="btn btn-success btn-sm w-100">Enable</button>
                                    </form>
                                @elseif($vendor->verification_status == 'rejected')
                                    <form action="{{ route('admin.vendors.approve', $vendor) }}" method="POST">@csrf
                                        <button class="btn btn-success btn-sm w-100">Re-Accept</button>
                                    </form>
                                    <form action="{{ route('admin.vendors.destroy', $vendor) }}" method="POST">@csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm w-100">Delete</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12" data-aos="fade-up">
                    <div class="alert alert-info text-center shadow-sm rounded">
                        <i class="bi bi-exclamation-circle"></i> No vendors found.
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-4 d-flex justify-content-center" data-aos="fade-up">
            {{ $vendors->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<style>
    /* Hero */
    .vendor-hero {
        background: linear-gradient(135deg, #6a11cb, #2575fc);
        border-radius: 0 0 30px 30px;
    }

    /* Vendor Card */
    .vendor-card {
        border-radius: 16px;
        transition: transform .3s ease, box-shadow .3s ease;
    }
    .vendor-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 28px rgba(0,0,0,0.15);
    }

    .vendor-card h5 {
        font-size: 1.15rem;
    }
    .vendor-card .badge {
        font-size: 0.85rem;
    }
    .btn-sm {
        font-size: 0.8rem;
        padding: 0.35rem 0.6rem;
        border-radius: 8px;
    }

    /* Pagination – rounded pills */
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
@endsection