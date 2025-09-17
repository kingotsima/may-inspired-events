<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
{
    Schema::create('admin_event_bookings', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('event_name');
        $table->date('event_date');
        $table->integer('guests')->nullable();
        $table->decimal('budget', 12, 2)->nullable();
        $table->text('details')->nullable();
        $table->string('status')->default('pending');
        $table->decimal('amount', 12, 2)->nullable();
        $table->timestamps();

    });
}



    public function down(): void
    {
        Schema::dropIfExists('admin_event_bookings');
    }
};

