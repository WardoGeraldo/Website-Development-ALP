<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    protected $products;
    protected $users;  // Add users array



    public function __construct()
    {
        // Initialize products and users array here
        $this->products = $this->getDummyProducts();
        $this->users = $this->getDummyUsers();  // Initialize users
    }

    /**
     * Method to return the list of products (admin dashboard).
     */
    public function index()
    {
        return view('admin.productlist', ['products' => $this->products]);
    }

    /**
     * Method to return the list of users (admin user list).
     */
    public function userList()
    {
        return view('admin.user-list', ['users' => $this->users]);
    }

    /**
     * Helper method to get dummy products data.
     */
    private function getDummyProducts()
    {
        return [
            1 => [
                'id' => 1,
                'name' => 'Oversized Tee',
                'price' => 299000,
                'description' => 'A stylish oversized tee for casual wear.',
                'category' => 'top',
                'image' => $this->getFirstImage(1),
                'stock' => ['s' => 10, 'm' => 15, 'l' => 7, 'xxl' => 3],  // <- Add this
            ],
            2 => [
                'id' => 2,
                'name' => 'Minimalist Hoodie',
                'price' => 499000,
                'description' => 'Comfortable and sleek hoodie for a modern look.',
                'category' => 'top',
                'image' => $this->getFirstImage(2),
                'stock' => ['s' => 5, 'm' => 8, 'l' => 12, 'xxl' => 2],
            ],
            3 => [
                'id' => 3,
                'name' => 'Slim Fit Pants',
                'price' => 399000,
                'description' => 'Perfect for a smart casual look.',
                'category' => 'bottom',
                'image' => $this->getFirstImage(3),
                'stock' => ['s' => 5, 'm' => 8, 'l' => 12, 'xxl' => 2],

            ],
            4 => [
                'id' => 4,
                'name' => 'Grey Baggy jeans',
                'price' => 449000,
                'description' => 'A simple, yet stylish baggy jeans.',
                'category' => 'bottom',
                'image' => $this->getFirstImage(4),
                'stock' => ['s' => 5, 'm' => 8, 'l' => 12, 'xxl' => 2],

            ],
            5 => [
                'id' => 5,
                'name' => 'Wisdom Cap',
                'price' => 169000,
                'description' => 'A fire, and stylish cap to extravaganze your outfit.',
                'category' => 'accessories',
                'image' => $this->getFirstImage(5),
                'stock' => ['s' => 5, 'm' => 8, 'l' => 12, 'xxl' => 2],

            ],
            6 => [
                'id' => 6,
                'name' => 'Monochrome Cap',
                'price' => 149000,
                'description' => 'A simple, yet stylish cap to complement your outfit.',
                'category' => 'accessories',
                'image' => $this->getFirstImage(6),
                'stock' => ['s' => 5, 'm' => 8, 'l' => 12, 'xxl' => 2],

            ],
            7 => [
                'id' => 7,
                'name' => 'Yellow Leather Bag',
                'price' => 1149000,
                'description' => 'A simple, yet real leathered bag with a sunkissed flavor color.',
                'category' => 'bag',
                'image' => $this->getFirstImage(7),
                'stock' => ['s' => 5, 'm' => 8, 'l' => 12, 'xxl' => 2],

            ],
        ];
    }

    /**
     * Helper method to get dummy users data.
     */
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

        ];
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

    // Method to update product data
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'price' => 'required|numeric',
            'category' => 'required|string',
            'description' => 'nullable|string',
            'stock' => 'required|array',
            'stock.s' => 'required|integer|min:0',
            'stock.m' => 'required|integer|min:0',
            'stock.l' => 'required|integer|min:0',
            'stock.xxl' => 'required|integer|min:0',
        ]);

        if (isset($this->products[$id])) {
            $this->products[$id]['name'] = $request->name;
            $this->products[$id]['price'] = $request->price;
            $this->products[$id]['category'] = $request->category;
            $this->products[$id]['description'] = $request->description;
            $this->products[$id]['stock'] = $request->stock;

            if ($request->hasFile('image')) {
                $this->products[$id]['image'] = $this->storeImage($request->file('image'), $id);
            }

            // Save updated products back to session
            session(['products' => $this->products]);

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
        ['name' => 'Oversized Tee', 'sold' => 40, 'stock' => ['s'=>10, 'm'=>20, 'l'=>5, 'xxl'=>5]],
        ['name' => 'Minimalist Hoodie', 'sold' => 32, 'stock' => ['s'=>5, 'm'=>15, 'l'=>8, 'xxl'=>4]],
    ];

    $topCustomers = [
        ['name' => 'Nadya Zahra', 'email' => 'nadya@example.com', 'orders' => 8, 'totalSpent' => 1250000],
        ['name' => 'Dewi Lestari', 'email' => 'dewi@example.com', 'orders' => 7, 'totalSpent' => 900000],
        ['name' => 'Intan Maharani', 'email' => 'dewi@example.com', 'orders' => 8,'totalSpent' => 880000],
    ];

    $salesMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'May'];
    $salesData = [2000000, 2500000, 1800000, 3000000, 3500000];

    $categoryLabels = ['Top', 'Bottom', 'Accessories'];
    $categoryData = [40, 30, 30];

    return view('admin.dashboard', compact(
        'totalProducts', 'totalUsers', 'totalSales', 'totalPromos',
        'todayRevenue', 'weekRevenue', 'topProducts', 'topCustomers',
        'salesMonths', 'salesData', 'categoryLabels', 'categoryData'
    ));
}

}
