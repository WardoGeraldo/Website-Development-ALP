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
        Schema::create('payments', function (Blueprint $table) {
            $table->id('payment_id'); // Primary Key

            $table->foreignId('order_id')
                  ->constrained('orders', 'order_id')
                  ->onDelete('cascade');

            // Midtrans-related fields
            $table->string('transaction_id')->nullable(); // from Midtrans
            $table->string('payment_type')->nullable();   // e.g. bank_transfer, qris, gopay
            $table->string('transaction_status')->default('pending'); // e.g. pending, settlement, cancel
            $table->string('va_number')->nullable(); // for bank_transfer
            $table->string('bank')->nullable();      // bank name if applicable
            $table->string('pdf_url')->nullable();   // payment instruction PDF

            $table->decimal('amount', 10, 2); // Nominal total dibayar
            $table->timestamp('payment_date')->nullable(); // diisi saat payment sukses

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};