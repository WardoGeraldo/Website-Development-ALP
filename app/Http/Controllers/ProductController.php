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

    public function showBestSeller($id)
    {
        $products = $this->getProductsWithImages();

        if (isset($products[$id])) {
            $product = $products[$id];
            return view('product-detail-home', compact('product'));
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
                'name' => 'Pastel Shirt',
                'price' => 299000,
                'description' => 'A stylish shirt that could never go wrong for casual or professional work.',
                'category' => 'top',
                'image' => $this->getFirstImage(1),
                'sizes' => ['XS','S', 'M', 'L', 'XL','XXL'],
            ],
            2 => [
                'id' => 2,
                'name' => 'Black Veravia Signature Dress',
                'price' => 499000,
                'description' => 'A Stylish dress for modern look that will light up your charm',
                'category' => 'top',
                'image' => $this->getFirstImage(2),
                'sizes' => ['XS','S', 'M', 'L', 'XL','XXL'],
            ],
            3 => [
                'id' => 3,
                'name' => 'Oversized Pink Tee',
                'price' =>299000,
                'description' => 'Perfect for a smart casual look.',
                'category' => 'top',
                'image' => $this->getFirstImage(3),
                'sizes' => ['XS','S', 'M', 'L', 'XL','XXL'],
            ],
            4 => [
                'id' => 4,
                'name' => 'Long-Sleeved Green Shirt',
                'price' => 349000,
                'description' => 'A long-sleeved shirt with a premium wool',
                'category' => 'top',
                'image' => $this->getFirstImage(4),
                'sizes' => ['XS','S', 'M', 'L', 'XL','XXL'],
            ],
            5 => [
                'id' => 5,
                'name' => 'Pastel Fit Pants',
                'price' => 449000,
                'description' => 'A simple, yet fits with every top you have',
                'category' => 'bottom',
                'image' => $this->getFirstImage(5),
                'sizes' => ['XS','S', 'M', 'L', 'XL','XXL'],
            ],
            6 => [
                'id' => 6,
                'name' => 'Black Wool Underwear',
                'price' => 129000,
                'description' => 'Made with premium sheep wool to make you comfy',
                'category' => 'bottom',
                'image' => $this->getFirstImage(6),
                'sizes' => ['XS','S', 'M', 'L', 'XL','XXL'],
            ],
            7 => [
                'id' => 7,
                'name' => 'Denim Baggy Jeans',
                'price' => 649000,
                'description' => 'A simple, yet stylish baggy jeans to complement your outfit of the day.',
                'category' => 'bottom',
                'image' => $this->getFirstImage(7),
                'sizes' => ['XS','S', 'M', 'L', 'XL','XXL'],
            ],
            8 => [
                'id' => 8,
                'name' => 'Sunkist Cap',
                'price' => 249000,
                'description' => 'A stylish cap to complement your outfit during the day.',
                'category' => 'accessories',
                'image' => $this->getFirstImage(8),
                'sizes' => ['One Size Fits All'],
            ],
            9 => [
                'id' => 9,
                'name' => 'Brown Wisdom Cap',
                'price' => 249000,
                'description' => 'A simple, yet stylish cap to complement your outfit.',
                'category' => 'accessories',
                'image' => $this->getFirstImage(9),
                'sizes' => ['One Size Fits All'],
            ],
            10 => [
            'id' => 10,
                'name' => 'Brown Leather Bag',
                'price' => 1149000,
                'description' => 'A simple, yet real leathered bag with a sand color.',
                'category' => 'bag',
                'image' => $this->getFirstImage(10),
                'sizes' => ['One Size'],
            ],
            11 => [
                'id' => 11,
                'name' => 'Pink Captain Bag',
                'price' => 1549000,
                'description' => 'A sweet pastel pink look that will make you charm',
                'category' => 'bag',
                'image' => $this->getFirstImage(11),
                'sizes' => ['One Size'],
            ],
            12 => [
                'id' => 12,
                'name' => 'Abstract Leather Bag',
                'price' => 1649000,
                'description' => 'An abstract leather bag that will make you feel obsessed.',
                'category' => 'bag',
                'image' => $this->getFirstImage(12),
                'sizes' => ['One Size'],
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

    public function home()
    {
        $productController = new ProductController();
        $products = $productController->getAllProducts();

        $bestSellers = array_slice($products, 0, 4); // Top 4 items

        return view('home', compact('bestSellers'));
    }
}
