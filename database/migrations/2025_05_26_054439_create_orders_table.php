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
        Schema::create('orders', function (Blueprint $table) {
            $table->id('order_id'); // Primary Key

            $table->foreignId('user_id') // FK ke users
                  ->constrained('users', 'user_id')
                  ->onDelete('cascade');

            $table->foreignId('promo_id') // Nullable FK ke promos
                  ->nullable()
                  ->constrained('promos', 'promo_id')
                  ->onDelete('set null');

            $table->timestamp('order_date')->useCurrent();
            $table->enum('order_status', ['pending', 'paid', 'shipped', 'delivered', 'cancelled'])->default('pending');
            $table->decimal('total_price', 10, 2);

            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};