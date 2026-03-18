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
        Schema::table('wallets', function (Blueprint $table) {

            $table->boolean('is_frozen')->default(false);

            $table->timestamp('frozen_at')->nullable();

            $table->unsignedBigInteger('frozen_by')->nullable();

            $table->decimal('daily_limit',15,2)->default(50000);

            $table->decimal('monthly_limit',15,2)->default(500000);

            $table->decimal('single_txn_limit',15,2)->default(10000);

            $table->decimal('daily_used',15,2)->default(0);

            $table->decimal('monthly_used',15,2)->default(0);

            $table->boolean('fraud_flag')->default(false);

            $table->integer('fraud_score')->default(0);

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
