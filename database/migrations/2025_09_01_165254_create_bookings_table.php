<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            
            // Foreign keys
            $table->foreignId('event_id')->nullable()->constrained()->cascadeOnDelete();// client
            $table->foreignId('service_id')->constrained()->cascadeOnDelete(); // service
            
            // Amount column: large enough for big bookings
            $table->decimal('amount', 15, 2); // max ~ 999,999,999,999,999.99
            
            // Booking status and type
            $table->string('status')->default('pending'); // pending|paid|cancelled
            $table->string('type')->default('service');   // service or event
            
            // Unique reference for Paystack
            $table->string('reference')->unique();
            
            // Optional details for admin events
            $table->json('details')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('bookings');
    }
};
