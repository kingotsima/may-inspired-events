@extends('layouts.app')

@section('title','Share Your Testimonial')

@section('content')
<div class="testimonial-submit-page">

    <!-- Hero -->
    <section class="testimonial-hero text-white py-5 mb-5">
        <div class="container text-center" data-aos="fade-down">
            <h1 class="fw-bold display-6">💬 Share Your Experience</h1>
            <p class="lead opacity-75">Your feedback helps us grow & inspire others to plan their events with confidence</p>
        </div>
    </section>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                {{-- Success --}}
                <!-- @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert" data-aos="fade-up">
                        ✅ {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif -->

                {{-- Errors --}}
                @if($errors->any())
                    <div class="alert alert-danger rounded shadow-sm mb-4" data-aos="fade-up">
                        <strong>⚠ Please fix the following errors:</strong>
                        <ul class="mt-2 mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Card -->
                <div class="card shadow-lg border-0 rounded-4" data-aos="zoom-in">
                    <div class="card-body p-4">
                        <h3 class="fw-bold mb-4 text-center text-primary">We Value Your Feedback</h3>
                        <p class="text-muted text-center mb-4">
                            Your testimonial will be reviewed by our team before being published on 
                            <strong>{{ config('app.name','May Inspired Events') }}</strong>.
                        </p>

                        <!-- Form -->
                        <form action="{{ route('testimonials.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">Your Name</label>
                                <input type="text" name="name" id="name" 
                                       class="form-control form-control-lg shadow-sm" 
                                       value="{{ old('name') }}" 
                                       placeholder="Enter your full name" required>
                            </div>

                            <!-- Image -->
                            <div class="mb-3">
                                <label for="image" class="form-label fw-semibold">Profile Picture (optional)</label>
                                <input type="file" name="image" id="image" 
                                       class="form-control shadow-sm" accept="image/*">
                            </div>

                            <!-- Rating -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold d-block">Rating</label>
                                <div id="starRating" class="mb-2">
                                    @for($i=1;$i<=5;$i++)
                                        <i class="bi bi-star star" 
                                           data-value="{{ $i }}" 
                                           style="font-size: 1.8rem; cursor:pointer; transition:.2s;"></i>
                                    @endfor
                                </div>
                                <input type="hidden" name="rating" id="rating" value="{{ old('rating',0) }}" required>
                                <small class="text-muted">Click the stars to rate.</small>
                            </div>

                            <!-- Message -->
                            <div class="mb-3">
                                <label for="message" class="form-label fw-semibold">Your Testimonial</label>
                                <textarea name="message" id="message" rows="4" 
                                          class="form-control shadow-sm" 
                                          placeholder="Write your testimonial here..." required>{{ old('message') }}</textarea>
                            </div>

                            <!-- Submit -->
                            <div class="text-end">
                                <button type="submit" class="btn btn-gradient px-5 py-2 fw-bold">
                                    <i class="bi bi-send"></i> Submit
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<style>
    /* Hero */
    .testimonial-hero{
        background: linear-gradient(135deg,#6a11cb,#2575fc);
        border-radius: 0 0 30px 30px;
    }

    /* Card hover */
    .card:hover{
        transform: translateY(-4px);
        transition: 0.3s;
    }

    /* Inputs */
    .form-control:focus{
        border-color:#2575fc;
        box-shadow:0 0 0 0.25rem rgba(37,117,252,0.25);
    }

    /* Gradient button */
    .btn-gradient{
        background: linear-gradient(135deg,#36d1dc,#5b86e5);
        border:none;
        border-radius: 50px;
        color:#fff !important;
        transition:.3s;
    }
    .btn-gradient:hover{
        transform:translateY(-2px);
        box-shadow:0 6px 15px rgba(0,0,0,.2);
    }

    /* Stars */
    #starRating .bi-star,
    #starRating .bi-star-fill{
        transition: transform .2s;
    }
    #starRating .bi-star:hover{
        transform: scale(1.2);
        color: gold;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
AOS.init({ duration:900, once:true, offset:70 });

document.addEventListener("DOMContentLoaded", function() {
    const stars = document.querySelectorAll("#starRating .star");
    const ratingInput = document.getElementById("rating");

    stars.forEach(star => {
        star.addEventListener("click", function() {
            const rating = this.getAttribute("data-value");
            ratingInput.value = rating;

            stars.forEach(s => {
                s.classList.remove("bi-star-fill","text-warning");
                s.classList.add("bi-star");
            });
            for(let i=0;i<rating;i++){
                stars[i].classList.remove("bi-star");
                stars[i].classList.add("bi-star-fill","text-warning");
            }
        });
    });

    // Restore old rating after validation error
    const oldRating = ratingInput.value;
    if(oldRating > 0){
        for(let i=0;i<oldRating;i++){
            stars[i].classList.remove("bi-star");
            stars[i].classList.add("bi-star-fill","text-warning");
        }
    }
});
</script>
@endpush