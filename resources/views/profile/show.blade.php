@extends('layouts.app')

@section('title','My Profile')

@section('content')
<div class="profile-page">

    <!-- Hero -->
    <section class="profile-hero text-white py-5 mb-5">
        <div class="container text-center" data-aos="fade-down">
            <h1 class="fw-bold display-6">👤 My Profile</h1>
            <p class="opacity-75">Manage your account information</p>
        </div>
    </section>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">

                <!-- Alerts -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert" data-aos="fade-down">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert" data-aos="fade-down">
                        <strong>⚠ Please fix the errors:</strong>
                        <ul class="mt-2 mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Content -->
                <div class="row g-4">
                    
                    <!-- Profile Info Card -->
                    <div class="col-md-5" data-aos="fade-right">
                        <div class="card shadow-lg rounded-4 border-0 h-100">
                            <div class="card-body text-center py-5">
                                <i class="bi bi-person-circle display-4 text-primary mb-3"></i>
                                <h5 class="fw-bold mb-3">Account Details</h5>
                                <p class="text-muted mb-1"><strong>Name:</strong> {{ $user->name }}</p>
                                <p class="text-muted"><strong>Email:</strong> {{ $user->email }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Update Form Card -->
                    <div class="col-md-7" data-aos="fade-left">
                        <div class="card shadow-lg rounded-4 border-0 h-100">
                            <div class="card-body">
                                <h5 class="fw-bold mb-4 text-center text-primary">Update Profile</h5>

                                <form action="{{ route('profile.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Name</label>
                                        <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control form-control-lg shadow-sm" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Email</label>
                                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control form-control-lg shadow-sm" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">New Password <span class="text-muted small">(leave blank to keep current)</span></label>
                                        <input type="password" name="password" class="form-control form-control-lg shadow-sm">
                                    </div>

                                    <div class="mb-4">
                                        <label class="form-label fw-semibold">Confirm New Password</label>
                                        <input type="password" name="password_confirmation" class="form-control form-control-lg shadow-sm">
                                    </div>

                                    <button type="submit" class="btn btn-gradient btn-lg w-100 fw-bold py-2">
                                        <i class="bi bi-save"></i> Update Profile
                                    </button>
                                </form>

                            </div>
                        </div>
                    </div>

                </div><!-- /row -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<style>
    /* Hero */
    .profile-hero {
        background: linear-gradient(135deg,#6a11cb,#2575fc);
        border-radius: 0 0 30px 30px;
    }
    /* Cards */
    .card { transition: transform .3s ease, box-shadow .3s ease; }
    .card:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 25px rgba(0,0,0,.1);
    }
    /* Inputs */
    .form-control {
        border-radius: 12px;
    }
    .form-control:focus {
        border-color:#2575fc;
        box-shadow:0 0 0 0.25rem rgba(37,117,252,0.25);
    }
    /* Gradient button */
    .btn-gradient {
        background: linear-gradient(135deg,#36d1dc,#5b86e5);
        border: none;
        border-radius: 12px;
        color: #fff !important;
        transition:.3s;
    }
    .btn-gradient:hover {
        transform: translateY(-2px);
        box-shadow:0 6px 15px rgba(0,0,0,.2);
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
AOS.init({ duration: 900, once: true, offset: 70 });
</script>
@endpush