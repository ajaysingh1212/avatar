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
        Schema::create('wallet_transactions', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('wallet_id');

            $table->string('transaction_id')->unique();

            $table->enum('type',['credit','debit']);

            $table->decimal('amount',15,2);

            $table->decimal('before_balance',15,2);

            $table->decimal('after_balance',15,2);

            $table->enum('status',['pending','approved','rejected'])->default('pending');

            $table->text('remarks')->nullable();

            $table->unsignedBigInteger('approved_by')->nullable();

            $table->timestamp('approved_at')->nullable();

            $table->unsignedBigInteger('created_by_id')->nullable();

            $table->unsignedBigInteger('updated_by_id')->nullable();

            $table->ipAddress('created_ip')->nullable();

            $table->ipAddress('updated_ip')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_transactions');
    }
};
