<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('bookings', 'type')) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->string('type')->default('service');
            });
        }
    }


    public function down()
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
