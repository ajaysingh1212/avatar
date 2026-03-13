<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('live_locations', function (Blueprint $table) {

            $table->id();
            $table->string('imei')->unique();

            $table->decimal('latitude',10,7);
            $table->decimal('longitude',10,7);

            $table->integer('speed')->nullable();
            $table->integer('course')->nullable();

            $table->boolean('ignition')->default(false);
            $table->boolean('gps_valid')->default(true);

            $table->timestamp('tracked_at');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('live_locations');
    }
};
