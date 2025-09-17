@extends('layouts.app')

@section('title','Welcome to May Inspired Events')

@section('content')
<!-- Hero Section -->
<section class="hero-section d-flex align-items-center text-center text-white">
  <div class="overlay"></div>

  <!-- Content inside -->
  <div class="hero-content text-center px-4">
    <h1 class="display-3 fw-bold mb-3 animate__animated animate__fadeInDown">
      Plan Your Events With <span class="text-warning">Ease</span>
    </h1>
    <p class="lead mb-4 animate__animated animate__fadeInUp animate__delay-1s">
      Verified vendors, secure payments, and stress-free planning—all in one place.
    </p>
    <div class="d-flex justify-content-center gap-3 flex-wrap animate__animated animate__fadeInUp animate__delay-2s">
      <a href="{{ route('services.index') }}" class="btn btn-warning btn-lg fw-bold px-4 shadow-lg rounded-pill">
        Browse Services
      </a>
      <a href="{{ route('admin.booking.event.form') }}" class="btn btn-outline-light btn-lg fw-bold px-4 rounded-pill">
        Book Admin
      </a>
    </div>
  </div>
</section>



<!-- About Section -->
<section class="py-5 bg-light">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-6 mb-4 mb-md-0">
        <img src="https://images.pexels.com/photos/33914523/pexels-photo-33914523.jpeg" class="img-fluid rounded shadow" alt="About May Inspired Events">
      </div>
      <div class="col-md-6 text-center text-md-start">
        <h2 class="fw-bold mb-3">About {{ config('app.name', 'May Inspired Events') }}</h2>
        <p class="text-muted">
          We connect clients with top-rated vendors for catering, photography, venues, and more.
          Enjoy secure payments, transparent reviews, and smooth event planning at your fingertips.
        </p>
        <a href="{{ route('services.index') }}" class="btn btn-primary mt-3">Check Out Available Services</a>
      </div>
    </div>
  </div>
</section>

<!-- Features Section -->
<section class="py-5">
  <div class="container text-center">
    <h2 class="fw-bold mb-5">Why Choose Us?</h2>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="feature-card p-4 h-100 shadow-sm">
          <i class="bi bi-shield-lock text-warning display-4 mb-3"></i>
          <h5 class="fw-bold">Secure Payments</h5>
          <p class="text-muted small">Pay confidently with our integrated payment gateway.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-card p-4 h-100 shadow-sm">
          <i class="bi bi-people text-info display-4 mb-3"></i>
          <h5 class="fw-bold">Verified Vendors</h5>
          <p class="text-muted small">Work only with trusted vendors approved by our team.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-card p-4 h-100 shadow-sm">
          <i class="bi bi-calendar-event text-danger display-4 mb-3"></i>
          <h5 class="fw-bold">Easy Booking</h5>
          <p class="text-muted small">Reserve services and receive instant booking confirmations online.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Featured Services -->
<section class="py-5 bg-light">
  <div class="container">
    <h2 class="text-center fw-bold mb-5">Featured Services</h2>

    <div class="row justify-content-center g-4">
      @forelse($featuredServices as $service)
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 shadow service-card border-0">
            <img src="{{ $service->images->first() ? asset('storage/'.$service->images->first()->filename) : 'https://via.placeholder.com/400x250?text=No+Image' }}"
                 class="card-img-top rounded-top"
                 alt="{{ $service->title }}">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title fw-bold mb-2">
                <a href="{{ route('services.show', $service) }}" class="text-decoration-none text-dark">
                  {{ Str::limit($service->title,30) }}
                </a>
              </h5>
              <p class="card-text small text-muted">{{ Str::limit($service->description,70) }}</p>
              <div class="mt-auto">
                <p class="fw-bold text-primary mb-2">
                  ₦{{ number_format($service->base_price,2) }}
                  @if($service->price_unit)
                    <span class="text-muted">/ {{ $service->price_unit }}</span>
                  @endif
                </p>
                <a href="{{ route('services.show',$service) }}" class="btn btn-outline-primary btn-sm w-100">View Details</a>
              </div>
            </div>
          </div>
        </div>
      @empty
        <div class="col-12">
          <p class="text-center text-muted fs-5">
            There are no available vendor services right now, please check back later.
          </p>
        </div>
      @endforelse
    </div>

    @if($featuredServices->count())
    <div class="d-flex justify-content-center mt-4">
      {{ $featuredServices->links() }}
    </div>
    @endif
  </div>
</section>

<!-- Testimonials Carousel -->
<section class="py-5 bg-light">
  <div class="container">

      <div class="text-center mb-4">
        <h2 class="fw-bold mb-3">What People Say 💬</h2>
        @auth
          <a href="{{ route('testimonials.form') }}" class="btn btn-gradient btn-sm rounded-pill px-3">Post Testimonial</a>
        @endauth
      </div>

    @if(!empty($testimonials) && count($testimonials) > 0)
    <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">

        @foreach($testimonials as $index => $testimonial)
          @if($testimonial->status === 'approved')
          <div class="carousel-item {{ $index==0?'active':'' }}">
            <div class="d-flex justify-content-center">
              <div class="card testimonial-card shadow-sm text-center p-4">

                <!-- Avatar -->
                <div class="avatar-wrapper mx-auto mb-3">
                  @if($testimonial->image)
                  <img src="{{ asset('storage/'.$testimonial->image) }}" alt="{{ $testimonial->name }}" class="rounded-circle avatar-img">
                  @else
                  <div class="default-avatar rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-person-fill text-white fs-2"></i>
                  </div>
                  @endif
                </div>

                <!-- Message -->
                <p class="testimonial-message">"{{ Str::limit($testimonial->message, 100) }}"</p>

                @if(strlen($testimonial->message) > 100)
                <button class="btn btn-link text-primary p-0 small" 
                        data-bs-toggle="modal" 
                        data-bs-target="#testimonialModal{{ $testimonial->id }}">
                    Read More
                </button>
                @endif

                <!-- Stars -->
                <div class="mb-2 text-warning">
                  @for($i=1;$i<=5;$i++)
                    @if($i<=$testimonial->rating)
                      <i class="bi bi-star-fill"></i>
                    @else
                      <i class="bi bi-star"></i>
                    @endif
                  @endfor
                </div>

                <!-- Name -->
                <strong>- {{ $testimonial->name }}</strong>

              </div>
            </div>
          </div>
          @endif
        @endforeach
      </div>

      <!-- Controls -->
      <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
      </button>
    </div>

    <!-- Modals for Full Testimonial -->
    @foreach($testimonials as $testimonial)
    <div class="modal fade" id="testimonialModal{{ $testimonial->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg rounded-4">
            <div class="modal-header">
                <h5 class="modal-title">Testimonial by {{ $testimonial->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                @if($testimonial->image)
                    <img src="{{ asset('storage/'.$testimonial->image) }}" class="rounded-circle avatar-img mb-3">
                @else
                    <div class="default-avatar mb-3"><i class="bi bi-person-fill"></i></div>
                @endif
                <p class="fst-italic">"{{ $testimonial->message }}"</p>
                <div class="text-warning mb-2">
                    @for($i=1;$i<=5;$i++)
                        @if($i<=$testimonial->rating) <i class="bi bi-star-fill"></i>
                        @else <i class="bi bi-star"></i>
                        @endif
                    @endfor
                </div>
                <strong>- {{ $testimonial->name }}</strong>
            </div>
            </div>
        </div>
    </div>
    @endforeach

    @else
    <p class="text-center text-muted">No testimonials yet. Be the first to share your experience!</p>
    @endif

  </div>
</section>

<!-- CTA -->
<section class="cta-section text-white text-center py-5">
  <div class="container">
    <h2 class="fw-bold mb-3">Ready to Start Planning?</h2>
    <p class="lead mb-4">Browse top vendors and book your services effortlessly today.</p>
    <a href="{{ route('services.index') }}" class="btn btn-light btn-lg px-5">Get Started</a>
  </div>
</section>
@endsection

@push('styles')
<style>
/* HERO SECTION */
.hero-section {
  position: relative;
  min-height: 90vh;  /* was 100vh, reduced */
  width: 100%;
  margin: 0;
  padding: 0;
  background: url('https://images.pexels.com/photos/4717550/pexels-photo-4717550.jpeg') 
              center/cover no-repeat;
  display: flex;
  align-items: center;
  justify-content: center;
}
.hero-section .overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(135deg, rgba(15,23,42,.65), rgba(30,41,59,.75));
  backdrop-filter: blur(3px);
}

.hero-content {
  position: relative;
  z-index: 1;
  max-width: 900px;
  margin: 0 auto;
  background: rgba(255,255,255,0.06);
  backdrop-filter: blur(16px) saturate(170%);
  border-radius: 1rem;
  border: 1px solid rgba(255,255,255,0.15);
  padding: 2.5rem 2rem;
  box-shadow: 0 8px 32px rgba(0,0,0,.35);
}

/* .hero-section .position-relative {
  max-width: 900px;           
  margin: auto;               
  z-index: 1;
  background: rgba(255,255,255,0.06);
  backdrop-filter: blur(14px) saturate(170%);
  border-radius: 1rem;
  border: 1px solid rgba(255,255,255,0.15);
  padding: 2.5rem 2rem;
  box-shadow: 0 8px 32px rgba(0,0,0,.35);
} */

/* Headline + Subtitle */
.hero-section h1 {
  font-size: clamp(2rem, 5vw, 3.5rem);
  line-height: 1.2;
  background: linear-gradient(135deg, #4F46E5, #3B82F6);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}
.hero-section h1 .text-warning {
  color: #FFD54F !important; /* accent highlight */
}
.hero-section p {
  font-size: 1.25rem;
  color: rgba(255,255,255,0.85);
}

/* Buttons styled like login/register buttons */
.hero-section .btn-warning {
  background: linear-gradient(135deg,#FBBF24,#F59E0B);
  border: none;
  border-radius: 999px;
  color: #111 !important;
  box-shadow: 0 8px 20px rgba(251,191,36,.4);
  transition: .25s;
}
.hero-section .btn-warning:hover {
  transform: translateY(-2px) scale(1.02);
  box-shadow: 0 12px 28px rgba(251,191,36,.55);
}

.hero-section .btn-outline-light {
  border:2px solid rgba(255,255,255,0.6);
  border-radius:999px;
  color:#fff;
  transition: .25s;
}
.hero-section .btn-outline-light:hover {
  background:rgba(255,255,255,0.1);
  border-color:#fff;
  transform: translateY(-2px);
}

.feature-card { border-radius:15px;transition:.3s; }
.feature-card:hover { transform:translateY(-5px);box-shadow:0 8px 20px rgba(0,0,0,.15); }
.service-card { border-radius:15px;transition:.3s; }
.service-card:hover { transform:translateY(-5px);box-shadow:0 8px 20px rgba(0,0,0,.15); }
.cta-section { background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%); }
.carousel-control-prev-icon,.carousel-control-next-icon{ filter: invert(1); }

/* Testimonial Card */
.testimonial-card {
  max-width: 600px;
  border-radius: 18px;
  background: #fff;
  padding: 2rem 1.5rem;
  transition: all .3s ease;
  text-align: center;
}
.testimonial-card:hover { transform:translateY(-5px);box-shadow:0 10px 25px rgba(0,0,0,.15); }

/* Avatar */
.avatar-wrapper { width:90px;height:90px;margin-bottom:1rem; }
.avatar-img { width:100%;height:100%;object-fit:cover;
  border:4px solid #f0f0f0;box-shadow:0 4px 12px rgba(0,0,0,0.1);border-radius:50%; }
.default-avatar { width:90px;height:90px;
  background:linear-gradient(135deg,#6a11cb,#2575fc);
  border:4px solid #f0f0f0;box-shadow:0 4px 12px rgba(0,0,0,0.1);
  display:flex;align-items:center;justify-content:center; }
.default-avatar i { font-size:2rem;color:#fff; }

/* Truncated preview message */
.testimonial-message {
  font-size:.95rem;color:#555;line-height:1.5;margin-bottom:1rem;
  min-height:70px;max-height:100px;overflow:hidden;text-overflow:ellipsis;
}

/* Stars + Name */
.testimonial-card .text-warning { font-size:1rem;margin-bottom:.5rem; }
.testimonial-card strong { font-size:1rem;color:#222;margin-top:.5rem; }

/* Gradient button */
.btn-gradient { background:linear-gradient(135deg,#36d1dc,#5b86e5);color:#fff !important;
  border:none;transition:.3s; }
.btn-gradient:hover { transform:translateY(-2px);box-shadow:0 6px 15px rgba(0,0,0,.2); }

/* Modal styling */
.modal-content {
  border-radius: 18px;
  overflow: hidden;
}

.modal-body {
  padding: 2rem;
  max-height: 60vh;          /* limit height to 60% of screen */
  overflow-y: auto;          /* enable scroll if content too long */
  text-align: center;
}

.modal-body p {
  font-size: 1rem;
  color: #444;
  line-height: 1.6;
  margin-bottom: 1rem;
  word-wrap: break-word;     /* prevent overflow on long words */
}

</style>
@endpush
