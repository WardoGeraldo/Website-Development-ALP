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
        Schema::create('product_stocks', function (Blueprint $table) {
            $table->id('product_stock_id'); // Primary Key
            $table->foreignId('product_id') // FK ke products
                  ->constrained('products', 'product_id')
                  ->onDelete('cascade');

            $table->enum('size', ['XS','S', 'M', 'L', 'XL', 'XXL']);
            $table->integer('quantity')->default(0);
            $table->integer('low_stock_threshold')->default(5); // default alert limit
            $table->boolean('status_del')->default(false); // soft delete manual

            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_stocks');
    }
};