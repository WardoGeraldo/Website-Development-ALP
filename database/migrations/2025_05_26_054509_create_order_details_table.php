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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id('order_details_id'); // Primary Key

            $table->foreignId('order_id') // FK ke orders
                  ->constrained('orders', 'order_id')
                  ->onDelete('cascade');

            $table->foreignId('product_id') // FK ke products
                  ->constrained('products', 'product_id')
                  ->onDelete('cascade');

            $table->enum('product_size', ['XS','S', 'M', 'L', 'XL', 'XXL']);
            $table->integer('quantity')->default(1);
            $table->decimal('price', 10, 2); // Harga saat order (bukan harga saat ini)

            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};