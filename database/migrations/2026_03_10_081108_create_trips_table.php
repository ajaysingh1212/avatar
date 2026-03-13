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
        Schema::create('trips', function (Blueprint $table) {

            $table->id();
            $table->string('imei');

            $table->timestamp('start_time');
            $table->timestamp('end_time')->nullable();

            $table->decimal('start_lat',10,7);
            $table->decimal('start_lng',10,7);

            $table->decimal('end_lat',10,7)->nullable();
            $table->decimal('end_lng',10,7)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
