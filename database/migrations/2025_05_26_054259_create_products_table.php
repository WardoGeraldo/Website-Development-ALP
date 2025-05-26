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
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id'); // Primary Key
            $table->string('name');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2); // Harga produk
            $table->foreignId('category_id') // FK ke categories
                  ->constrained('product_categories', 'category_id')
                  ->onDelete('cascade');
            $table->boolean('status_del')->default(false); // Soft delete manual
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};