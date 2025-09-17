<?php

// database/migrations/2025_09_04_000000_create_vendors_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('business_name');
            $table->text('bio')->nullable();
            $table->string('phone')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('verification_status')->default('pending'); // pending|approved|rejected
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('vendors');
    }
};
