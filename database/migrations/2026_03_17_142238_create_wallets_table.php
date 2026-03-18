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
        Schema::create('wallets', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('user_id');

            $table->string('wallet_number')->unique();

            $table->decimal('balance',15,2)->default(0);

            $table->enum('status',['pending','approved','rejected'])->default('pending');

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
        Schema::dropIfExists('wallets');
    }
};
