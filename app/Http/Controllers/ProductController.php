<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    // Method untuk menampilkan semua produk
    public function index()
    {
        $products = $this->getProductsWithImages();
        return view('store', compact('products'));
    }

    // Method untuk menampilkan detail satu produk
    public function show($id)
    {
        $products = $this->getProductsWithImages();

        if (isset($products[$id])) {
            $product = $products[$id];
            return view('product-detail', compact('product'));
        } else {
            abort(404);
        }
    }

    // Kumpulan produk dengan image langsung dalam array
    protected function getProductsWithImages()
    {
        return [
            1 => [
                'id' => 1,
                'name' => 'Oversized Tee',
                'price' => 299000,
                'description' => 'A stylish oversized tee for casual wear.',
                'category' => 'top',
                'image' => $this->getFirstImage(1),
            ],
            2 => [
                'id' => 2,
                'name' => 'Minimalist Hoodie',
                'price' => 499000,
                'description' => 'Comfortable and sleek hoodie for a modern look.',
                'category' => 'top',
                'image' => $this->getFirstImage(2),
            ],
            3 => [
                'id' => 3,
                'name' => 'Slim Fit Pants',
                'price' => 399000,
                'description' => 'Perfect for a smart casual look.',
                'category' => 'bottom',
                'image' => $this->getFirstImage(3),
            ],
            4 => [
                'id' => 4,
                'name' => 'Grey Baggy jeans',
                'price' => 449000,
                'description' => 'A simple, yet stylish baggy jeans.',
                'category' => 'accessories',
                'image' => $this->getFirstImage(4),
            ],
            5 => [
                'id' => 5,
                'name' => 'Wisdom Cap',
                'price' => 169000,
                'description' => 'A fire, and stylish cap to extravaganze your outfit.',
                'category' => 'accessories',
                'image' => $this->getFirstImage(5),
            ],
            6 => [
                'id' => 6,
                'name' => 'Monochrome Cap',
                'price' => 149000,
                'description' => 'A simple, yet stylish cap to complement your outfit.',
                'category' => 'accessories',
                'image' => $this->getFirstImage(6),
            ],
        ];
    }

    // Helper method untuk ambil gambar pertama dari folder produk
    protected function getFirstImage($productId)
    {
        $path = public_path("images/products/{$productId}");

        if (!File::exists($path)) {
            return asset('fotoBaju.jpg'); // fallback image
        }

        $files = array_filter(File::allFiles($path), function ($file) {
            return in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png', 'webp']);
        });

        if (count($files) > 0) {
            return asset("images/products/{$productId}/" . reset($files)->getBasename());
        }

        return asset('fotoBaju.jpg'); // fallback jika folder kosong
    }

    public function getAllProducts()
    {
    return $this->getProductsWithImages();
    }
}
