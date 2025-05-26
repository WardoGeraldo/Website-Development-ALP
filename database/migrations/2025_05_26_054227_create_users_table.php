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
        Schema::create('users', function (Blueprint $table) {
            $table->id('user_id'); // Primary Key
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->text('address')->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->date('birthdate')->nullable();
            $table->enum('role', ['customer', 'admin'])->default('customer');
            $table->boolean('status_del')->default(false); // Soft delete indicator
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};