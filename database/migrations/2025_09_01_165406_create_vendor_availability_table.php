<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// database/migrations/2025_09_03_000002_create_vendor_availability_table.php
return new class extends Migration {
    public function up(): void {
        Schema::create('vendor_availability', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->boolean('is_blocked')->default(false);
            $table->timestamps();

            $table->unique(['vendor_id','date','start_time','end_time']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('vendor_availability');
    }
};

