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
        Schema::create('wishlists', function (Blueprint $table) {
            $table->id('wishlist_id'); // Primary Key

            $table->foreignId('user_id') // FK ke users
                  ->constrained('users', 'user_id')
                  ->onDelete('cascade');

            $table->foreignId('product_id') // FK ke products
                  ->constrained('products', 'product_id')
                  ->onDelete('cascade');

            $table->timestamps(); // created_at & updated_at

            // Optional: prevent duplicate product for the same user
            $table->unique(['user_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wishlists');
    }
};