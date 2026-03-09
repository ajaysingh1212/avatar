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
    Schema::create('media', function (Blueprint $table) {

    $table->id();

    $table->string('model_type');
    $table->unsignedBigInteger('model_id');

    $table->uuid('uuid')->nullable();

    $table->string('collection_name')->nullable();
    $table->string('name')->nullable();

    $table->string('file_name');
    $table->string('mime_type')->nullable();

    $table->string('disk')->nullable();
    $table->string('conversions_disk')->nullable();

    $table->unsignedBigInteger('size')->nullable();

    $table->longText('manipulations')->nullable();
    $table->longText('custom_properties')->nullable();
    $table->longText('generated_conversions')->nullable();
    $table->longText('responsive_images')->nullable();

    $table->integer('order_column')->nullable();

    $table->timestamps();

    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
