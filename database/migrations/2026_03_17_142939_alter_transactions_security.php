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
        Schema::table('wallet_transactions', function (Blueprint $table) {

        $table->boolean('is_locked')->default(false);

        $table->string('lock_token')->nullable();

        $table->timestamp('locked_at')->nullable();

        $table->boolean('rollback_status')->default(false);

        $table->string('device')->nullable();

        $table->string('user_agent')->nullable();

        $table->string('reference_id')->nullable();

        $table->string('currency')->default('INR');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
