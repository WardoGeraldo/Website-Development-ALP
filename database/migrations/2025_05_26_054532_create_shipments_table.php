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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id('shipment_id');

            $table->foreignId('order_id')
                  ->constrained('orders', 'order_id')
                  ->onDelete('cascade');

            // Contact & delivery address fields
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('address_line1');            // e.g. Jl. Example No. 123
            $table->string('address_line2')->nullable(); // apartment, suite, etc
            $table->string('city');
            $table->string('zip_code');
            $table->string('phone');

            // Pengiriman status & waktu
            $table->timestamp('shipment_date')->nullable();
            $table->enum('delivery_status', [
                'processing', 'shipped', 'delivered', 'returned'
            ])->default('processing');

            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};