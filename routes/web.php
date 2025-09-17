<?php

use Illuminate\Support\Facades\Auth;
//VENDOR 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\VendorAvailabilityController;
use App\Http\Controllers\VendorDashboardController;
use App\Http\Controllers\VendorController;
//SHOW HOMEPAGE FEATURED SERVICES
use App\Http\Controllers\WelcomeController;
//SERVICE
use App\Http\Controllers\ServiceController;
//BOOKING
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Admin\CheckInController;
use App\Http\Controllers\BookingDashboardController;
//NOTIFICATION
use App\Http\Controllers\Admin\AdminVendorController;
//ADMIN
use App\Http\Controllers\Admin\AdminBookingController;
//LOGIN AND REGISTER AUTHENTICATION
use App\Http\Controllers\Admin\AdminDashboardController;
//ADMIN EVENT BOOKING
// use App\Http\Controllers\AdminEventBookingController;
use App\Http\Controllers\Vendor\VendorServiceController;
use App\Http\Controllers\Admin\AdminEventBookingController;
// use App\Http\Controllers\Admin\AdminEventBookingController as AdminEventBooking;
//TESTIMONIALS
use App\Http\Controllers\TestimonialController;



//Featured Services on Homepage
Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

//Terms
Route::view('/terms', 'terms')->name('terms');
Route::view('/privacy', 'privacy')->name('privacy');

// routes/web.php
Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');



// Default home (after login, redirect based on role)
// Route::get('/', function () {
//     return view('welcome');
// });

//*** LOGIN AND REGISTER ROUTES ***//
Auth::routes();

//PROFILE ROUTE
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});



//*** CLIENT ROUTES (normal users) ***/
Route::middleware(['auth'])->group(function () {
    // Client dashboard
    Route::get('/client/dashboard', function () {
        return view('client.dashboard');
    })->name('client.dashboard');

    // Client bookings
    Route::get('/client/bookings', [BookingDashboardController::class, 'client'])
        ->name('client.bookings');

    // Book a service
    Route::post('/services/{service}/book', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/booking/callback', [BookingController::class, 'callback'])->name('booking.callback');

    // Vendor onboarding (any normal user can apply)
    Route::get('/vendor/apply', [App\Http\Controllers\VendorController::class, 'create'])->name('vendor.apply');
    Route::post('/vendor/apply', [App\Http\Controllers\VendorController::class, 'store'])->name('vendor.store');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
});
//Read All Notifications
Route::post('/notifications/read-all', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])
    ->name('notifications.readAll');


// Client submits testimonial
Route::post('/testimonials', [TestimonialController::class, 'store'])
    ->middleware('auth')
    ->name('testimonials.store');

// Admin testimonial management
Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::get('/admin/testimonials', [TestimonialController::class, 'index'])->name('admin.testimonials.index');
    Route::post('/admin/testimonials/{testimonial}/approve', [TestimonialController::class, 'approve'])->name('admin.testimonials.approve');
    Route::delete('/admin/testimonials/{testimonial}', [TestimonialController::class, 'destroy'])->name('admin.testimonials.destroy');

    Route::get('/admin/testimonials/create', [TestimonialController::class, 'create'])->name('admin.testimonials.create');
    Route::post('/admin/testimonials/store', [TestimonialController::class, 'storeAdmin'])->name('admin.testimonials.storeAdmin');
});
//Add tstimonial
Route::get('/testimonials/form', function () {
    return view('testimonials.form');
})->middleware('auth')->name('testimonials.form');


//*** VENDOR ROUTES ***/
Route::middleware(['auth','role:Vendor', 'vendor.active'])->group(function () {
    // Vendor dashboard
    Route::get('/vendor/dashboard', [\App\Http\Controllers\VendorDashboardController::class, 'index'])
        ->name('vendor.dashboard');

    // Vendor bookings
    Route::get('/vendor/bookings', [BookingDashboardController::class,'vendor'])->name('vendor.bookings');

    // Delete a single image
    Route::delete('/vendor/services/{service}/images/{image}', [VendorServiceController::class, 'destroyImage'])
        ->name('vendor.services.images.destroy');

    // Resource routes for services
    Route::resource('/vendor/services', VendorServiceController::class)->names([
        'index'   => 'vendor.services.index',
        'create'  => 'vendor.services.create',
        'store'   => 'vendor.services.store',
        'edit'    => 'vendor.services.edit',
        'update'  => 'vendor.services.update',
        'destroy' => 'vendor.services.destroy',
        'show'    => 'vendor.services.show',
    ]);
});
    Route::get('/vendor/availability', [VendorAvailabilityController::class, 'index'])
        ->name('vendor.availability')
        ->middleware(['auth', 'role:Vendor']);
    Route::put('/vendor/availability', [VendorAvailabilityController::class, 'update'])
        ->name('vendor.availability.update')
        ->middleware(['auth', 'role:Vendor']);

    //To show list of vendors
    Route::get('/vendors', [VendorController::class, 'index'])->name('vendors.index');
    //To show vendors profile
    Route::get('/vendors/{vendor}', [VendorController::class, 'show'])->name('vendors.show');
    //To show a particular vendors services
    Route::get('/vendors/{vendor}/services', [VendorController::class, 'services'])->name('vendors.services');

    // Vendor Profile Edit
    Route::middleware(['auth','role:Vendor','vendor.active'])->group(function () {
        Route::get('/vendor/profile/edit', [App\Http\Controllers\VendorController::class, 'edit'])
            ->name('vendor.profile.edit');
        Route::put('/vendor/profile/update', [App\Http\Controllers\VendorController::class, 'update'])
            ->name('vendor.profile.update');
    });





//*** SERVICE ROUTES (public catalog) ***/
Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');


//*** ADMIN ROUTES ***/
Route::middleware(['auth','role:Admin'])->prefix('admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class,'index'])->name('admin.dashboard');

    // Vendor management
    Route::get('/vendors', [AdminVendorController::class, 'index'])->name('admin.vendors.index');
    Route::post('/vendors/{vendor}/approve', [AdminVendorController::class, 'approve'])->name('admin.vendors.approve');
    Route::post('/vendors/{vendor}/reject', [AdminVendorController::class, 'reject'])->name('admin.vendors.reject');

    // New routes for suspend, restore, delete
    Route::post('/vendors/{vendor}/suspend', [AdminVendorController::class, 'suspend'])->name('admin.vendors.suspend');
    Route::post('/vendors/{vendor}/restore', [AdminVendorController::class, 'restore'])->name('admin.vendors.restore');
    Route::delete('/vendors/{vendor}', [AdminVendorController::class, 'destroy'])->name('admin.vendors.destroy');



    // Booking management
    Route::get('/bookings', [AdminBookingController::class,'index'])->name('admin.bookings.index');
    Route::get('/bookings/{booking}', [AdminBookingController::class,'show'])->name('admin.bookings.show');
});

//*** CHECKIN ROUTES (Admin & Vendor) ***/
Route::middleware(['auth','role:Admin|Vendor'])->prefix('checkin')->group(function () {
    Route::get('/', [CheckInController::class,'index'])->name('checkin.index');
    Route::post('/verify', [CheckInController::class,'verify'])->name('checkin.verify');
});


//*** ADMIN EVENT BOOKING ***//
Route::middleware('auth')->group(function() {
    Route::get('/admin-booking/event', [\App\Http\Controllers\AdminEventBookingController::class, 'create'])
        ->name('admin.booking.event.form');
    Route::post('/admin-booking/event', [\App\Http\Controllers\AdminEventBookingController::class, 'store'])
        ->name('admin.booking.event');
});



//ADMIN DASHBOARD HANDLING BOOKING ROUTE
Route::middleware(['auth','role:Admin'])->prefix('admin')->group(function () {
    Route::get('/admin-bookings', [AdminBookingController::class, 'adminBookings'])
        ->name('admin.bookings.admin.index');
    Route::post('/admin-bookings/{booking}/approve', [AdminBookingController::class, 'approve'])
        ->name('admin.bookings.admin.approve');
    Route::post('/admin-bookings/{booking}/reject', [AdminBookingController::class, 'reject'])
        ->name('admin.bookings.admin.reject');
});

Route::get('/admin-bookings/{booking}', [AdminBookingController::class, 'showAdminBooking'])
    ->name('admin.bookings.admin.show');


// Admin Event Bookings (full CRUD + approve/reject)
// Admin Event Bookings
Route::prefix('admin')->name('admin.')->middleware(['auth','role:Admin'])->group(function () {

    // List all event bookings
    Route::get('event-bookings', [AdminEventBookingController::class, 'index'])
        ->name('event-bookings.index');

    // Show create booking form
    Route::get('event-bookings/create', [AdminEventBookingController::class, 'create'])
        ->name('event-bookings.create');

    // Store new booking
    Route::post('event-bookings', [AdminEventBookingController::class, 'store'])
        ->name('event-bookings.store');

    // Show single booking
    Route::get('event-bookings/{booking}', [AdminEventBookingController::class, 'show'])
        ->name('event-bookings.show');

    // Approve booking
    Route::post('event-bookings/{booking}/approve', [AdminEventBookingController::class, 'approve'])
        ->name('event-bookings.approve');

    // Reject booking
    Route::post('event-bookings/{booking}/reject', [AdminEventBookingController::class, 'reject'])
        ->name('event-bookings.reject');
});

