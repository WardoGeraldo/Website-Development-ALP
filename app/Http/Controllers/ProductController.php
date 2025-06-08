<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    // Show all products
    public function index()
    {
        $products = Product::where('status_del', false)->get()->map(function ($product) {
            return [
                'id' => $product->product_id,
                'name' => $product->name,
                'price' => $product->price,
                'description' => $product->description,
                'category' => $this->mapCategoryIdToName($product->category_id),
                'image' => $this->getFirstImage($product->product_id),
            ];
        });

        return view('store', compact('products'));
    }

    // Show single product
    public function show($id)
    {
        $product = Product::findOrFail($id);

        $images = $this->getAllImages($id);

        return view('product-detail', [
            'product' => [
                'product_id' => $product->product_id, // supaya product id nyambung
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'sizes' => DB::table('product_stocks')
                ->where('product_id', $id)
                ->where('quantity', '>', 0)
                ->pluck('size')
                ->unique()
                ->values()
                ->toArray(),
                'images' => $images,
            ]
        ]);
    }

    protected function getFirstImage($productId)
    {
        $directory = public_path("images/products/{$productId}");

        if (!File::exists($directory)) {
            return asset('fotoBaju.jpg'); // fallback image
        }

        $files = File::files($directory);
        $filtered = array_filter($files, function ($file) {
            return in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png', 'webp']);
        });

        if (count($filtered) > 0) {
            $firstFile = reset($filtered);
            return asset("images/products/{$productId}/" . $firstFile->getFilename());
        }

        return asset('fotoBaju.jpg');
    }

    protected function getAllImages($productId)
    {
        $directory = public_path("images/products/{$productId}");

        if (!File::exists($directory)) {
            return [asset('fotoBaju.jpg')]; // fallback
        }

        $files = File::files($directory);
        $filtered = array_filter($files, function ($file) {
            return in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png', 'webp']);
        });

        if (count($filtered) > 0) {
            return array_map(function ($file) use ($productId) {
                return asset("images/products/{$productId}/" . $file->getFilename());
            }, $filtered);
        }

        return [asset('fotoBaju.jpg')]; // fallback
    }

    // Show best seller (currently first 4 products)
    public function home()
    {
        $products = Product::where('status_del', false)->take(4)->get()->map(function ($product) {
            return [
                'id' => $product->product_id,
                'name' => $product->name,
                'price' => $product->price,
                'description' => $product->description,
                'category' => $this->mapCategoryIdToName($product->category_id),
                'image' => $this->getFirstImage($product->product_id),
                'sizes' => ['XS', 'S', 'M', 'L', 'XL', 'XXL', 'One Size'],
            ];
        });

        return view('home', ['bestSellers' => $products]);
    }
    

    // Helper: map category ID to name
    protected function mapCategoryIdToName($categoryId)
    {
        return match ($categoryId) {
            1 => 'top',
            2 => 'bottom',
            3 => 'bag',
            4 => 'accessories',
            default => 'unknown',
        };
    }
}
