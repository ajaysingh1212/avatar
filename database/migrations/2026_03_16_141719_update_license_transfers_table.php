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
    Schema::table('license_transfer_items', function (Blueprint $table) {

    $table->decimal('price',10,2)->default(0);
    $table->decimal('discount',10,2)->default(0);
    $table->decimal('base_price',10,2)->default(0);
    $table->decimal('cgst',10,2)->default(0);
    $table->decimal('sgst',10,2)->default(0);
    $table->decimal('total',10,2)->default(0);

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
