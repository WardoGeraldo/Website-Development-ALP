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
        Schema::create('product_images', function (Blueprint $table) {
            $table->id('product_image_id'); // Primary Key
            $table->foreignId('product_id') // FK ke products
                  ->constrained('products', 'product_id')
                  ->onDelete('cascade');

            $table->string('url'); // URL gambar
            $table->boolean('is_primary')->default(false); // True jika gambar utama
            $table->boolean('status_del')->default(false); // Soft delete manual

            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};