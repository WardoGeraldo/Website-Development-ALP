<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        DB::statement("ALTER TABLE carts MODIFY COLUMN product_size ENUM('XS','S','M','L','XL','XXL','One Size') NOT NULL");
    }

    public function down()
    {
        // Revert if needed
        DB::statement("ALTER TABLE carts MODIFY COLUMN product_size ENUM('XS','S','M','L','XL','XXL') NOT NULL");
    }
};
