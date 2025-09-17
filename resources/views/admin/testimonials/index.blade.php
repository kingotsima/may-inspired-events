@extends('layouts.app')

@section('title','Manage Testimonials')

@section('content')
<div class="admin-testimonials-page">

    <!-- Hero Header -->
    <section class="testimonial-hero text-white py-5 mb-5">
        <div class="container text-center" data-aos="fade-down">
            <h1 class="fw-bold display-6">⭐ Manage Testimonials</h1>
            <p class="lead opacity-75">Review, approve, or delete customer feedback</p>
        </div>
    </section>

    <div class="container">

        <!-- Testimonials Table -->
        <div class="card shadow-sm border-0 rounded-4" data-aos="fade-up">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Message</th>
                                <th>Status</th>
                                <th>Rating</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($testimonials as $testimonial)
                                <tr data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                                    <td class="fw-bold">{{ $testimonial->name }}</td>
                                    <td class="text-muted" style="max-width: 300px;">
                                        {{ Str::limit($testimonial->message, 80) }}
                                    </td>
                                    <td>
                                        <span class="badge 
                                            @if($testimonial->status === 'approved') bg-success 
                                            @elseif($testimonial->status === 'pending') bg-warning text-dark 
                                            @else bg-secondary @endif">
                                            {{ ucfirst($testimonial->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($testimonial->rating)
                                            <span class="text-warning">
                                                @for($i = 0; $i < $testimonial->rating; $i++)
                                                    ★
                                                @endfor
                                            </span>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="text-center">

                                        <!-- View Button -->
                                        <button 
                                            class="btn btn-sm btn-info rounded-pill px-3 mb-1" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#viewTestimonial{{ $testimonial->id }}">
                                            <i class="bi bi-eye"></i> View
                                        </button>

                                        @if($testimonial->status === 'pending')
                                            <form action="{{ route('admin.testimonials.approve', $testimonial) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button class="btn btn-sm btn-success rounded-pill px-3 mb-1">
                                                    <i class="bi bi-check-circle"></i> Approve
                                                </button>
                                            </form>
                                        @endif
                                        <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="POST" class="d-inline">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger rounded-pill px-3 mb-1">
                                                <i class="bi bi-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        <i class="bi bi-inbox fs-4"></i> No testimonials yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $testimonials->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Move all modals OUTSIDE the table -->
@foreach($testimonials as $testimonial)
<div class="modal fade" id="viewTestimonial{{ $testimonial->id }}" tabindex="-1" aria-labelledby="viewTestimonialLabel{{ $testimonial->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="viewTestimonialLabel{{ $testimonial->id }}">Testimonial by {{ $testimonial->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-3"><strong>Message:</strong></p>
                <p class="text-muted">{{ $testimonial->message }}</p>
                <p class="mb-1"><strong>Status:</strong> 
                    <span class="badge 
                        @if($testimonial->status === 'approved') bg-success 
                        @elseif($testimonial->status === 'pending') bg-warning text-dark 
                        @else bg-secondary @endif">
                        {{ ucfirst($testimonial->status) }}
                    </span>
                </p>
                <p class="mb-1"><strong>Rating:</strong> 
                    @if($testimonial->rating)
                        <span class="text-warning">
                            @for($i = 0; $i < $testimonial->rating; $i++)
                                ★
                            @endfor
                        </span>
                    @else
                        N/A
                    @endif
                </p>
                @if($testimonial->image)
                    <p class="mt-3"><strong>Image:</strong></p>
                    <img src="{{ asset('storage/'.$testimonial->image) }}" alt="testimonial image" class="img-fluid rounded shadow">
                @endif
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded-pill px-3" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<style>
    .testimonial-hero {
        background: linear-gradient(135deg,#6a11cb,#2575fc);
        border-radius: 0 0 30px 30px;
    }
    .table-hover tbody tr:hover { background: rgba(37,117,252,0.05); }
    .badge { font-size: 0.85rem; padding: 0.45em 0.75em; }
    .btn-sm { font-size: 0.8rem; font-weight: 600; }
    .btn-success { background: linear-gradient(135deg,#28a745,#218838); border: none; }
    .btn-danger { background: linear-gradient(135deg,#dc3545,#a71d2a); border: none; }
    .btn-info { background: linear-gradient(135deg,#17a2b8,#117a8b); border: none; color: #fff; }
    .pagination .page-item .page-link {
        border-radius: 12px; margin: 0 4px; color: #2575fc; font-weight: 600;
    }
    .pagination .page-item.active .page-link {
        background: #2575fc; border-color: #2575fc; color: #fff; 
        box-shadow: 0 0 8px rgba(37,117,252,0.3);
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
AOS.init({ duration:900, once:true, offset:70 });
</script>
@endpush
