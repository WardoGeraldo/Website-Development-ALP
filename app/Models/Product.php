<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Jika nama tabel kamu adalah 'products', ini bisa diabaikan
    // protected $table = 'products';

    // Daftar kolom yang boleh diisi secara massal (mass assignment)
    protected $fillable = [
        'name',
        'category',
        'price',
        'image',
        'description', // Tambahkan jika kamu punya kolom deskripsi di DB
    ];
}
