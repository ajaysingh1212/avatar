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
        Schema::create('wallet_histories', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('wallet_id');

            $table->string('action');

            $table->text('description')->nullable();

            $table->unsignedBigInteger('performed_by');

            $table->string('module')->nullable();

            $table->ipAddress('ip')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_histories');
    }
};
