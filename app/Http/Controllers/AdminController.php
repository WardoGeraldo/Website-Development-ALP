<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    protected $products;



    public function __construct()
    {
        // Initialize products array here, now you can call $this->getFirstImage()
        $this->products = [
            1 => [
                'id' => 1,
                'name' => 'Oversized Tee',
                'price' => 299000,
                'image' => $this->getFirstImage(1),
                'category' => 'top',
            ],
            2 => [
                'id' => 2,
                'name' => 'Minimalist Hoodie',
                'price' => 499000,
                'image' => $this->getFirstImage(2),
                'category' => 'top',
            ],
            3 => [
                'id' => 3,
                'name' => 'Slim Fit Pants',
                'price' => 399000,
                'description' => 'Perfect for a smart casual look.',
                'image' => $this->getFirstImage(3),
                'category' => 'bottom'
            ],
            4 => [
                'id' => 4,
                'name' => 'Monochrome Cap',
                'price' => 149000,
                'description' => 'A simple, yet stylish cap to complement your outfit.',
                'image' => $this->getFirstImage(4),
                'category' => 'accessories'
            ],
            5 => [
                'id' => 5,
                'name' => 'Wisdom Cap',
                'price' => 169000,
                'description' => 'A fire, and stylish cap to extravaganze your outfit.',
                'image' => $this->getFirstImage(5),
                'category' => 'accessories'
            ],
        ];
    }

    public function index()
    {
        return view('admin.productlist', ['products' => $this->products]);
    }

    public function create()
    {
        // Return the view with an empty product data
        return view('admin.create-product');
    }

    // Method to handle the form submission for adding a new product
    public function store(Request $request)
    {
        // Simulate adding a new product to the dummy data
        $newProductId = count($this->products) + 1; // Generate a new ID

        // Store the new product data (in a real app, you'd use a database)
        $this->products[$newProductId] = [
            'id' => $newProductId,
            'name' => $request->name,
            'price' => $request->price,
            'category' => $request->category,
            'description' => $request->description,
            'image' => $this->storeImage($request->file('image'), $newProductId),
        ];

        // Redirect back with a success message
        return redirect()->route('admin.product.create')->with('success', 'Product added successfully!');
    }

    // Helper function to store the image
    private function storeImage($image, $productId)
    {
        // Save image in a folder based on the product ID (using a folder for each product)
        if ($image) {
            $path = public_path("images/products/{$productId}");
            if (!File::exists($path)) {
                File::makeDirectory($path, 0777, true);
            }

            // Save the image
            $imagePath = $image->storeAs("images/products/{$productId}", $image->getClientOriginalName(), 'public');
            return asset('storage/' . $imagePath);
        }

        // Return a default image if no image is uploaded
        return asset('images/default.jpg');
    }


    public function edit($id)
    {
        // Check if product exists in dummy data
        if (!isset($this->products[$id])) {
            abort(404, 'Product not found');
        }

        $product = $this->products[$id];

        // Return an edit view with the product data
        return view('admin.edit-product', compact('product'));
    }

    // Method to update product data
    public function update(Request $request, $id)
    {
        // Validate inputs
        $validated = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'category' => 'required|string',
            'description' => 'nullable|string',
        ]);

        // Update product data
        if (isset($this->products[$id])) {
            $this->products[$id]['name'] = $request->name;
            $this->products[$id]['price'] = $request->price;
            $this->products[$id]['category'] = $request->category;
            $this->products[$id]['description'] = $request->description;

            // Optionally handle image update as well
            if ($request->hasFile('image')) {
                $this->products[$id]['image'] = $this->storeImage($request->file('image'), $id);
            }

            return redirect()->route('admin.dashboard')->with('success', 'Product updated successfully!');
        }

        return redirect()->route('admin.dashboard')->with('error', 'Product not found');
    }


    // Helper method untuk ambil gambar pertama dari folder produk
    private function getFirstImage($productId)
    {
        $path = public_path("images/products/{$productId}");

        if (!File::exists($path)) {
            return asset('fotoBaju.jpg'); // fallback image with correct asset path
        }

        $files = array_filter(File::allFiles($path), function ($file) {
            return in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png', 'webp']);
        });

        if (count($files) > 0) {
            return asset("images/products/{$productId}/" . reset($files)->getBasename());
        }

        return asset('fotoBaju.jpg'); // fallback jika folder kosong
    }
}
