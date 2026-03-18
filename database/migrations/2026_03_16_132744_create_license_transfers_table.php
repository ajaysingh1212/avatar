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
        Schema::create('license_transfers', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('from_user_id')->nullable(); // admin
            $table->unsignedBigInteger('to_user_id');

            $table->integer('total_licenses');

            $table->unsignedBigInteger('created_by');

            $table->text('notes')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('license_transfers');
    }
};
