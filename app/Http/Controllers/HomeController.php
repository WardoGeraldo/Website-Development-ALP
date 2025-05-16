<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Menampilkan homepage tanpa mengambil produk dari database
    public function show()
    {
        // Data statis untuk produk (ganti dengan data yang kamu inginkan)
        $products = [
            (object)[
                'id' => 1,
                'name' => 'Dress Elegan',
                'category' => 'Pakaian',
                'price' => 150000,
                'image' => 'fotoBaju.jpg'
            ],
            (object)[
                'id' => 2,
                'name' => 'Jaket Casual',
                'category' => 'Pakaian',
                'price' => 120000,
                'image' => 'fotoBaju.jpg'
            ],
            // Tambah produk lainnya jika perlu
        ];

        // Kirim data produk statis ke view 'home'
        return view('home', compact('products')) ;
    }
}
