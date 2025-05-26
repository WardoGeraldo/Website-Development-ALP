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
        Schema::create('carts', function (Blueprint $table) {
            $table->id('cart_id'); // Primary Key

            $table->foreignId('user_id') // FK ke users
                  ->constrained('users', 'user_id')
                  ->onDelete('cascade');

            $table->foreignId('product_id') // FK ke products
                  ->constrained('products', 'product_id')
                  ->onDelete('cascade');

            $table->enum('product_size', ['XS','S', 'M', 'L', 'XL', 'XXL']);
            $table->integer('product_qty')->default(1);

            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};