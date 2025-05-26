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
        Schema::create('promos', function (Blueprint $table) {
            $table->id('promo_id'); // Primary Key
            $table->string('code')->unique(); // Kode promo unik
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('discount_amount', 10, 2); // Nominal potongan harga

            $table->boolean('status_del')->default(false); // Soft delete
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promos');
    }
};