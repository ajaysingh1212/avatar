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
        Schema::create('licenses', function (Blueprint $table) {

            $table->id();

            $table->string('license_key')->unique();

            $table->unsignedBigInteger('user_id')->nullable();
            // user who purchased license (added when buying)

            $table->string('product_name')->nullable();

            $table->string('plan_name')->nullable();

            $table->integer('max_devices')->default(1);

            $table->integer('validity_days')->nullable();

            $table->timestamp('issued_at')->nullable();

            $table->timestamp('expires_at')->nullable();

            $table->enum('status',['active','inactive','expired'])->default('inactive');

            $table->boolean('is_used')->default(false);
            // false = unused license
            // true = license already activated

            $table->string('purchase_reference')->nullable();

            $table->text('notes')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('licenses');
    }
};
