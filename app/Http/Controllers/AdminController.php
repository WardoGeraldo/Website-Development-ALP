<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    protected $products;
    protected $users;  // Add users array

    private function getDummyUsers()
    {
        return [
            1 => [
                'id' => 1,
                'name' => 'John Doe',
                'address' => '123 Main St, City, Country',
                'phone' => '123-456-7890',
                'email' => 'john@gmail.com',
                'gender' => 'Male',
                'dob' => '1990-05-15',
                'role' => 'Customer',
            ],
            2 => [
                'id' => 2,
                'name' => 'Kevin',
                'address' => '456 Main St, City, Country',
                'phone' => '0899-1829-2020',
                'email' => 'kevin@gmail.com',
                'gender' => 'Male',
                'dob' => '1992-07-20',
                'role' => 'Customer',
            ],
            3 => [
                'id' => 3,
                'name' => 'Sarah',
                'address' => '789 Main St, City, Country',
                'phone' => '0812-3456-7890',
                'email' => 'sarah@gmail.com',
                'gender' => 'Female',
                'dob' => '1994-03-18',
                'role' => 'Admin',
            ],
            4 => [
                'id' => 4,
                'name' => 'Michael Smith',
                'address' => '321 Elm St, City, Country',
                'phone' => '0821-3456-1234',
                'email' => 'michael.smith@gmail.com',
                'gender' => 'Male',
                'dob' => '1988-11-10',
                'role' => 'Customer',
            ],
            5 => [
                'id' => 5,
                'name' => 'Emily Johnson',
                'address' => '654 Oak St, City, Country',
                'phone' => '0857-9876-5432',
                'email' => 'emily.johnson@gmail.com',
                'gender' => 'Female',
                'dob' => '1995-06-22',
                'role' => 'Customer',
            ],
            6 => [
                'id' => 6,
                'name' => 'David Lee',
                'address' => '77 Pine Ave, City, Country',
                'phone' => '0878-2233-5566',
                'email' => 'david.lee@gmail.com',
                'gender' => 'Male',
                'dob' => '1991-03-09',
                'role' => 'Admin',
            ],
            7 => [
                'id' => 7,
                'name' => 'Olivia Brown',
                'address' => '98 Cedar Blvd, City, Country',
                'phone' => '0813-1122-3344',
                'email' => 'olivia.brown@gmail.com',
                'gender' => 'Female',
                'dob' => '1993-12-01',
                'role' => 'Customer',
            ],
            8 => [
                'id' => 8,
                'name' => 'James Wilson',
                'address' => '135 Birch Lane, City, Country',
                'phone' => '0838-4455-6677',
                'email' => 'james.wilson@gmail.com',
                'gender' => 'Male',
                'dob' => '1989-08-17',
                'role' => 'Customer',
            ],
        ];
    }

    public function index()
    {
        $products = Product::with(['images', 'stock'])->where('status_del', 0)->get();

        $productsData = $products->map(function ($product) {
            // Cari gambar primary
            $image = $product->images->where('is_primary', 1)->first();

            return [
                'id' => $product->product_id,
                'name' => $product->name,
                'price' => $product->price,
                'description' => $product->description,
                'category' => $product->category ? $product->category->name : null,
                'image' => $image
                    ? asset('images/products/' . $product->product_id . '/' . basename($image->url))
                    : asset('images/default.jpg'),
                'stock' => $this->getStockSizes($product),
            ];
        });

        return view('admin.productlist', [
            'products' => $productsData,
        ]);
    }

    public function edit($id)
    {
        $product = Product::with(['stock', 'images'])->where('product_id', $id)->firstOrFail();

        $productData = [
            'id' => $product->product_id,
            'name' => $product->name,
            'price' => $product->price,
            'description' => $product->description,
            'category' => $product->category ? $product->category->name : null,
            'images' => $product->images->map(function ($img) {
                return [
                    'id' => $img->id,
                    'url' => $img->url,
                    'is_primary' => $img->is_primary,
                ];
            })->toArray(),

            'stock' => [
                'xs' => $product->stock->where('size', 'XS')->first()->quantity ?? 0,
                's' => $product->stock->where('size', 'S')->first()->quantity ?? 0,
                'm' => $product->stock->where('size', 'M')->first()->quantity ?? 0,
                'l' => $product->stock->where('size', 'L')->first()->quantity ?? 0,
                'xxl' => $product->stock->where('size', 'XXL')->first()->quantity ?? 0,
                'one_size' => $product->stock->where('size', 'ONE SIZE')->first()->quantity ?? 0, // Tambahin
            ],
        ];

        return view('admin.edit-product', ['product' => $productData]);
    }

    public function deleteImage(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $imagePath = public_path($request->input('image_url'));
        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }

        // Delete record dari database juga kalau ada
        $product->images()->where('url', 'like', '%' . basename($imagePath))->delete();

        return back()->with('success', 'Image deleted successfully!');
    }




    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'stock' => 'required|array',
            'primary_image' => 'nullable|exists:product_images,id',
        ]);

        $product = Product::with('images')->where('product_id', $id)->firstOrFail();
        $product->name = $validated['name'];
        $product->price = $validated['price'];
        $product->save();

        // Update stock per size
        foreach ($validated['stock'] as $size => $qty) {
            $stock = $product->stock()->where('size', $size)->first();
            if ($stock) {
                $stock->quantity = $qty;
                $stock->save();
            }
        }

        // Update Primary Image
        if ($request->filled('primary_image')) {
            // Reset semua gambar jadi non-primary
            $product->images()->update(['is_primary' => 0]);

            // Set gambar yang dipilih jadi primary
            $product->images()->where('id', $request->primary_image)->update(['is_primary' => 1]);
        }

        // Upload new images (kalau ada)
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                $filename = $imageFile->getClientOriginalName();
                $destinationPath = public_path('images/products/' . $product->product_id);

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                $imageFile->move($destinationPath, $filename);

                $product->images()->create([
                    'url' => 'images/products/' . $product->product_id . '/' . $filename,
                    'is_primary' => 0, // new image not primary by default
                ]);
            }
        }

        return redirect()->route('admin.dashboard')->with('success', 'Product updated successfully!');
    }

    public function updateImage(Request $request, $id)
    {
        $request->validate([
            'new_image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $image = \App\Models\ProductImage::findOrFail($id);

        // Hapus file lama
        if (file_exists(public_path($image->url))) {
            unlink(public_path($image->url));
        }

        // Upload file baru
        $file = $request->file('new_image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $destinationPath = public_path('images/products/' . $image->product_id);
        $file->move($destinationPath, $filename);

        // Update record database
        $image->url = 'images/products/' . $image->product_id . '/' . $filename;
        $image->save();

        return back()->with('success', 'Image updated successfully!');
    }





    private function getStockSizes($product)
    {
        // Ini ukuran yang kamu mau tampilkan di edit form
        $standardSizes = ['xs', 's', 'm', 'l', 'xl', 'xxl', 'one size'];

        // Initialize semua ukuran ke 0
        $stockSizes = array_fill_keys($standardSizes, 0);

        foreach ($product->stock as $stock) {
            $size = strtolower($stock->size);
            if (isset($stockSizes[$size])) {
                $stockSizes[$size] += $stock->quantity;
            }
        }

        return $stockSizes;
    }




    // Display edit form
    public function editUser($id)
    {
        $users = $this->getDummyUsers();

        if (!isset($users[$id])) {
            abort(404);
        }

        $user = $users[$id];

        return view('admin.user-list', compact('user'));
    }

    // Handle form submission (simulate update)
    public function updateUser(Request $request, $id)
    {
        $data = $request->only(['name', 'email', 'address', 'phone', 'gender', 'dob', 'role']);

        // Simulate "updated" user
        $user = array_merge(['id' => $id], $data);

        // Get the full dummy list again (not updated for real)
        $users = $this->getDummyUsers();

        // Redirect to the user list with success flash message
        return redirect()->route('admin.userlist')->with('success', 'User updated successfully (temporarily)');
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

    public function userDetails($id)
    {
        // Check if user exists in dummy data
        if (!isset($this->users[$id])) {
            abort(404, 'User not found');
        }

        $user = $this->users[$id];

        // Return a view with user data
        return view('admin.user-details', compact('user'));
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

    public function promoList()
    {
        // Dummy promo data
        $promos = [
            [
                'id' => 1,
                'title' => 'Spring Sale',
                'description' => 'Get up to 30% off on spring collection!',
                'start_date' => '2025-04-01',
                'end_date' => '2025-04-30',
                'promo_code' => 'SPRING30',
                'discount' => '30%',
            ],
            [
                'id' => 2,
                'title' => 'Black Friday Special',
                'description' => 'Flat 50% off on all items.',
                'start_date' => '2025-11-25',
                'end_date' => '2025-11-29',
                'promo_code' => 'BLACKFRI50',
                'discount' => '50%',
            ],
            [
                'id' => 3,
                'title' => 'New Year Promo',
                'description' => 'Celebrate the new year with 20% off.',
                'start_date' => '2025-12-28',
                'end_date' => '2026-01-05',
                'promo_code' => 'NEWYEAR20',
                'discount' => '20%',
            ],
        ];

        // Pass the promo data to the view
        return view('admin.promo-list', compact('promos'));
    }

    public function showPromoDetails($id)
    {
        // Dummy promo data (same as promoList)
        $promos = [
            1 => [
                'id' => 1,
                'title' => 'Spring Sale',
                'description' => 'Get up to 30% off on spring collection!',
                'start_date' => '2025-04-01',
                'end_date' => '2025-04-30',
                'promo_code' => 'SPRING30',
                'discount' => '30%',
            ],
            2 => [
                'id' => 2,
                'title' => 'Black Friday Special',
                'description' => 'Flat 50% off on all items.',
                'start_date' => '2025-11-25',
                'end_date' => '2025-11-29',
                'promo_code' => 'BLACKFRI50',
                'discount' => '50%',
            ],
            3 => [
                'id' => 3,
                'title' => 'New Year Promo',
                'description' => 'Celebrate the new year with 20% off.',
                'start_date' => '2025-12-28',
                'end_date' => '2026-01-05',
                'promo_code' => 'NEWYEAR20',
                'discount' => '20%',
            ],
        ];


        if (!isset($promos[$id])) {
            abort(404, 'Promo not found');
        }

        $promo = $promos[$id];

        return view('admin.promo-details', compact('promo'));
    }

    // Update promo handler
    public function updatePromo(Request $request, $id)
    {
        $request->validate([
            'promo_code' => 'required|string|max:20',
            'description' => 'required|string',
            'discount' => 'required|numeric|min:1|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Your dummy data update logic here (simulate)
        // Then redirect with success message
        return redirect()->route('admin.promo.list')->with('success', 'Promo updated successfully!');
    }

    public function createPromo()
    {
        // Show the form to create a new promo
        return view('admin.create-promo');
    }

    public function storePromo(Request $request)
    {
        // Validate input
        $request->validate([
            'promo_code' => 'required|string',
            'description' => 'required|string',
            'discount' => 'required|numeric|min:1|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Simulate saving promo: in real app save to DB, here just redirect

        // Redirect back to promo list with success message
        return redirect()->route('admin.promo.list')->with('success', 'Promo created successfully!');
    }

    public function destroy($id)
    {
        if (!isset($this->products[$id])) {
            abort(404, 'Product not found');
        }

        // Simulate deletion by unsetting the product from the dummy array
        unset($this->products[$id]);

        // Since this is dummy data, the deletion won't persist unless you handle persistence differently

        return redirect()->route('admin.dashboard')->with('success', 'Product deleted successfully.');
    }

    public function dashboardView()
    {
        // Dummy data, ganti sesuai logikamu nanti
        $totalProducts = 100;
        $totalUsers = 50;
        $totalSales = 120000000;
        $totalPromos = 4;

        $todayRevenue = 1250000;
        $weekRevenue = 8400000;

        $topProducts = [
            ['name' => 'Pastel shirt', 'sold' => 40, 'stock' => ['s' => 10, 'm' => 20, 'l' => 5, 'xxl' => 5]],
            ['name' => 'Denim Baggy Jeans', 'sold' => 32, 'stock' => ['s' => 5, 'm' => 15, 'l' => 8, 'xxl' => 4]],
            ['name' => 'Sunkist Cap', 'sold' => 32, 'stock' => ['s' => 5, 'm' => 15, 'l' => 8, 'xxl' => 4]],
            ['name' => 'Brown Leather Bag', 'sold' => 32, 'stock' => ['s' => 5, 'm' => 15, 'l' => 8, 'xxl' => 4]],
            ['name' => 'Abstract Leather Bag', 'sold' => 32, 'stock' => ['s' => 5, 'm' => 15, 'l' => 8, 'xxl' => 4]],
        ];

        $topCustomers = [
            ['name' => 'Nadya Zahra', 'email' => 'nadya@example.com', 'orders' => 8, 'totalSpent' => 1250000],
            ['name' => 'Dewi Lestari', 'email' => 'dewi@example.com', 'orders' => 7, 'totalSpent' => 900000],
            ['name' => 'Intan Maharani', 'email' => 'dewi@example.com', 'orders' => 8, 'totalSpent' => 880000],
        ];

        $salesMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'May'];
        $salesData = [2000000, 2500000, 1800000, 3000000, 3500000];

        $categoryLabels = ['Top', 'Bottom', 'Accessories'];
        $categoryData = [40, 30, 30];

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalUsers',
            'totalSales',
            'totalPromos',
            'todayRevenue',
            'weekRevenue',
            'topProducts',
            'topCustomers',
            'salesMonths',
            'salesData',
            'categoryLabels',
            'categoryData'
        ));
    }
}
