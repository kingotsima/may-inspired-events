@extends('layouts.app')

@section('title', 'Add Service')

@section('content')
<div class="service-create">

    <!-- Hero Banner -->
    <section class="hero-create text-center text-white py-5 mb-5">
        <div class="container" data-aos="fade-down">
            <h1 class="fw-bold display-5 mb-3 animate-title">➕ Add New Service</h1>
            <p class="lead opacity-75">Grow your business by showcasing your service to thousands of clients.</p>
        </div>
    </section>

    <div class="container" data-aos="fade-up">
        <!-- Validation Errors -->
        @if($errors->any())
            <div class="alert alert-danger shadow-sm rounded-4">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Service Form -->
        <form action="{{ route('vendor.services.store') }}" method="POST" enctype="multipart/form-data" 
              class="service-form-card shadow-lg p-4 rounded-4 mt-4">
            @csrf

            {{-- Title --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Title</label>
                <input type="text" name="title" class="form-control form-control-lg shadow-sm" 
                       value="{{ old('title') }}" required placeholder="Enter a catchy title for your service">
            </div>

            {{-- Description --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Description</label>
                <textarea name="description" rows="4" class="form-control form-control-lg shadow-sm"
                          placeholder="Describe your service in detail">{{ old('description') }}</textarea>
            </div>

            {{-- Price Fields --}}
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Base Price (₦)</label>
                    <input type="number" name="base_price" class="form-control form-control-lg shadow-sm" 
                           value="{{ old('base_price') }}" required placeholder="e.g. 10000">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Price Unit (e.g. Per Hour, Per Event)</label>
                    <input type="text" name="price_unit" class="form-control form-control-lg shadow-sm" 
                           value="{{ old('price_unit') }}" required placeholder="Per Hour, Per Day">
                </div>
            </div>

            {{-- Category --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Category</label>
                <select name="category_id" id="categorySelect" class="form-select shadow-sm" required>
                    <option></option>
                    @foreach(\App\Models\Category::all() as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <small class="text-muted">Use the search box to quickly find your category</small>
            </div>

            {{-- Image Upload --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Upload Service Images</label>
                <input type="file" name="images[]" class="form-control form-control-lg shadow-sm" 
                       accept="image/*" multiple>
                <small class="text-muted">Upload multiple images (JPG, PNG, max 2MB each).</small>
            </div>

            <!-- Submit Button -->
            <div class="text-end mt-4">
                <button type="submit" class="btn btn-gradient-lg shadow-sm px-5"
                        onclick="this.disabled=true; this.form.submit();">
                    🚀 Publish Service
                </button>
            </div>
        </form>
    </div>
</div>

{{-- Styles --}}
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
/* Hero Banner */
.hero-create {
    background: linear-gradient(135deg, #6a11cb, #2575fc);
    border-radius: 0 0 30px 30px;
}
.animate-title {
    animation: fadeIn 1s ease-in-out, pulse 3s infinite;
}
@keyframes pulse {
    0% { text-shadow: 0 0 0 rgba(255,255,255,0.3);}
    50% { text-shadow: 0 0 15px rgba(255,255,255,0.8);}
    100% { text-shadow: 0 0 0 rgba(255,255,255,0.3);}
}

/* Form Card */
.service-form-card {
    border-left: 5px solid #2575fc;
    background: rgba(255,255,255,0.95);
    transition:.3s ease;
}
.service-form-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 30px rgba(0,0,0,0.15) !important;
}

/* Inputs */
.form-control, .form-select {
    border-radius: 12px;
}
.form-control:focus, .form-select:focus {
    border-color: #2575fc;
    box-shadow: 0 0 0 .2rem rgba(37,117,252,0.25);
}

/* Submit Button */
.btn-gradient-lg {
    background: linear-gradient(135deg,#4F46E5,#3B82F6);
    border:none;
    border-radius:12px;
    font-weight:bold;
    font-size:1.1rem;
    padding:.9rem 2rem;
    color:#fff;
    transition:.25s;
}
.btn-gradient-lg:hover {
    background: linear-gradient(135deg,#3B82F6,#4F46E5);
    transform: translateY(-2px);
    box-shadow:0 8px 18px rgba(0,0,0,0.25);
}

/* Select2 styling */
.select2-container--default .select2-selection--single {
    border-radius: 12px;
    border:1px solid #ced4da;
    height:3.2rem;
    padding:.5rem 1rem;
    font-size:1rem;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height:2.2rem;
    color:#444;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
    height:100%;
    right:10px;
}
/* Dropdown */
.select2-container .select2-dropdown {
    border-radius:12px;
    border:1px solid #ddd;
    box-shadow:0 6px 20px rgba(0,0,0,.1);
}
/* Limit dropdown height + scroll */
.select2-container .select2-results > .select2-results__options {
    max-height:200px;
    overflow-y:auto;
}
/* Search input styling inside dropdown */
.select2-container--default .select2-search--dropdown .select2-search__field {
    border-radius:8px;
    padding:.5rem .75rem;
    border:1px solid #ccc;
    font-size:.95rem;
}
.select2-container--default .select2-search--dropdown .select2-search__field:focus {
    border-color:#2575fc;
    box-shadow:0 0 0 .2rem rgba(37,117,252,0.25);
}
</style>
@endpush

{{-- Scripts --}}
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    AOS.init({ duration: 900, once: true });

    $(document).ready(function() {
        $('#categorySelect').select2({
            placeholder: '🔍 Search or select a category',
            allowClear: true,
            width: '100%'
        });
    });
</script>
@endpush
@endsection