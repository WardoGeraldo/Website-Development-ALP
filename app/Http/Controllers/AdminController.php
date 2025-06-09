<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Promo;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductStock;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\File;

class AdminController extends Controller
{
    protected $products;
    protected $users;  // Add users array

    public function userList()
    {
        $users = User::where('status_del', 0)->get(); // Hanya user aktif
        return view('admin.user-list', compact('users'));
    }



    public function index()
    {
        $products = Product::with(['images', 'stock', 'category'])->where('status_del', 0)->get();


        $productsData = $products->map(function ($product) {
            $image = $product->images->where('is_primary', 1)->first();

            return [
                'id' => $product->product_id,
                'name' => $product->name,
                'price' => $product->price,
                'description' => $product->description,
                'category' => $product->category ? $product->category->name : null,
                'image' => $image
                    ? asset($image->url) // ⬅️ CUKUP pake asset($image->url)
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

        $categories = ProductCategory::all(); // ⬅️ Fetch semua kategori

        $productData = [
            'id' => $product->product_id,
            'name' => $product->name,
            'price' => $product->price,
            'description' => $product->description,
            'category_id' => $product->category_id, // simpen id bukan name
            'images' => $product->images->map(function ($img) {
                return [
                    'product_image_id' => $img->product_image_id,
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
                'one_size' => $product->stock->where('size', 'ONE SIZE')->first()->quantity ?? 0,
            ],
        ];

        return view('admin.edit-product', [
            'product' => $productData,
            'categories' => $categories, // ⬅️ Pass ke view
        ]);
    }


    public function deleteImage(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $imagePath = public_path($request->input('image_url'));
        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }

        $product->images()->where('url', 'like', '%' . basename($imagePath))->delete();

        return redirect()->route('admin.product.edit', ['id' => $id])->with('delete_success', 'Image deleted successfully!');
    }


    public function update(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:product_categories,category_id',
            'description' => 'nullable|string',
            'stock' => 'required|array',
            'stock.*' => 'nullable|integer|min:0', // Quantity minimal 0
        ]);

        // Cari product
        $product = Product::where('product_id', $id)->firstOrFail();

        // Update data produk
        $product->update([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'description' => $validated['description'] ?? null,
            'category_id' => $validated['category_id'], // 🟢 pakai id dari select
        ]);


        // Update stock
        foreach ($validated['stock'] as $size => $quantity) {
            ProductStock::updateOrCreate(
                [
                    'product_id' => $product->product_id,
                    'size' => strtoupper(str_replace('_', ' ', $size)), // Format size ke UPPER
                ],
                [
                    'quantity' => $quantity ?? 0,
                    'low_stock_threshold' => 5, // <-- Hardcode 5
                    'status_del' => 0,          // <-- Hardcode 0
                ]
            );
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

    public function replaceImage(Request $request, $id, $image_id)
    {
        $request->validate([
            'new_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048', // Validasi file gambar
        ]);

        // Cari gambar yang mau direplace
        $image = ProductImage::where('product_image_id', $image_id)
            ->where('product_id', $id)
            ->firstOrFail();

        // Hapus file lama
        if (file_exists(public_path($image->url))) {
            unlink(public_path($image->url));
        }

        // Simpan file baru manual
        $newImage = $request->file('new_image');
        $fileName = uniqid() . '.' . $newImage->getClientOriginalExtension(); // Biar random filename
        $destinationPath = 'images/products/' . $id; // contoh: images/products/12

        // Pastikan foldernya ada
        if (!file_exists(public_path($destinationPath))) {
            mkdir(public_path($destinationPath), 0755, true); // recursive mkdir
        }

        // Move file ke folder tujuan
        $newImage->move(public_path($destinationPath), $fileName);

        // Update database
        $image->update([
            'url' => $destinationPath . '/' . $fileName, // images/products/12/filename.jpg
        ]);

        return redirect()->route('admin.product.edit', ['id' => $id])->with('success', 'Image replaced successfully.');
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

    // Display edit user form
    public function editUser($id)
    {
        $user = User::where('user_id', $id)->firstOrFail(); // Cari user berdasarkan user_id

        return view('admin.user-details', compact('user')); // Asumsi viewnya admin/user-edit.blade.php
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::where('user_id', $id)->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->user_id . ',user_id',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20', // <--- ini harus `phone`, sesuai input
            'role' => 'required|in:admin,customer',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'role' => $request->role,
            // 'gender' => $request->gender, // <-- ini belum ada
            'birthdate' => $request->dob, // <-- ini juga belum ada
        ]);


        return redirect()->route('admin.userlist')->with('success', 'User updated successfully!');
    }

    public function create()
    {
        $categories = ProductCategory::where('status_del', 0)->get();
        return view('admin.create-product', compact('categories'));
    }


    // Method to handle the form submission for adding a new product
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:product_categories,category_id',
            'description' => 'nullable|string',
            'images' => 'required|array|max:4', // Max 4 images
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048' // 2MB per image
        ]);

        // Simpan produk baru
        $product = Product::create([
            'name' => $validated['name'],
            'price' => $validated['price'],
            'category_id' => $validated['category_id'],
            'description' => $validated['description'] ?? null,
        ]);

        // Upload images
        if ($request->hasFile('images')) {
            $destinationPath = public_path('images/products/' . $product->product_id); // <-- Ganti ke product_id

            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0777, true, true);
            }

            foreach ($request->file('images') as $index => $image) {
                $fileName = 'product_' . $product->product_id . '_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();

                $image->move($destinationPath, $fileName);

                $product->images()->create([
                    'url' => 'images/products/' . $product->product_id . '/' . $fileName,
                    'is_primary' => $index == 0 ? 1 : 0,
                ]);
            }
        }


        return redirect()->route('admin.dashboard')->with('success', 'Product created successfully!');
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

    public function deleteUser($id)
    {
        try {
            $user = User::where('user_id', $id)->firstOrFail();

            $user->update([
                'status_del' => 1
            ]);

            return redirect()->route('admin.userlist')->with('success', 'User deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.userlist')->with('error', 'Failed to delete user: ' . $e->getMessage());
        }
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
        // Ambil semua promo dari DB yang status_del = 0
        $promos = Promo::where('status_del', 0)->get();

        return view('admin.promo-list', compact('promos'));
    }

    public function showPromoDetails($id)
    {
        // Ambil promo dari database berdasarkan promo_id
        $promo = Promo::where('promo_id', $id)->where('status_del', 0)->firstOrFail();

        return view('admin.promo-details', compact('promo'));
    }


    // Update promo handler
    public function updatePromo(Request $request, $id)
    {
        $request->validate([
            'promo_code' => 'required|string|max:20',
            'discount' => 'required|numeric|min:1|max:100',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $promo = Promo::findOrFail($id);

        $promo->update([
            'code' => $request->promo_code,         // dari input promo_code
            'discount_amount' => $request->discount, // dari input discount
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return redirect()->route('admin.promo.list')->with('success', 'Promo updated successfully!');
    }


    public function createPromo()
    {
        // Show the form to create a new promo
        return view('admin.create-promo');
    }

    public function storePromo(Request $request)
{
    $request->validate([
        'promo_code' => 'required|string|max:20',
        'description' => 'required|string',
        'discount' => 'required|numeric|min:1|max:100',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
    ]);

    Promo::create([
        'code' => $request->promo_code,             
        'description' => $request->description,
        'discount_amount' => $request->discount,    
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'status_del' => 0,
    ]);

    return redirect()->route('admin.promo.list')->with('success', 'Promo created successfully!');
}



    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);

            // Soft delete the product by updating status_del to 1
            $product->update(['status_del' => 1]);

            // Soft delete related images
            $product->images()->update(['status_del' => 1]);

            // Soft delete related stock
            $product->stock()->update(['status_del' => 1]);

            return redirect()->route('admin.dashboard')->with('success', 'Product deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('admin.dashboard')->with('error', 'Failed to delete product: ' . $e->getMessage());
        }
    }



    public function dashboardView()
    {
        // Ambil jumlah total produk yang tidak soft delete (status_del = 0)
        $totalProducts = \App\Models\Product::where('status_del', 0)->count();

        // Ambil jumlah total user
        $totalUsers = \App\Models\User::count();

        // Ambil jumlah total sales dari table orders (anggap total_price field di orders)
        $totalSales = \App\Models\Order::sum('total_price');

        // Ambil jumlah promo aktif (anggap promo yang start_date <= today dan end_date >= today)
        $totalPromos = \App\Models\Promo::whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->count();

        // Revenue hari ini
        $todayRevenue = \App\Models\Order::whereDate('created_at', now())->sum('total_price');

        // Revenue 7 hari terakhir
        $weekRevenue = \App\Models\Order::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->sum('total_price');

        // Top 5 products paling banyak terjual
        $topProducts = \App\Models\OrderDetails::selectRaw('product_id, SUM(quantity) as sold')
            ->groupBy('product_id')
            ->orderByDesc('sold')
            ->with('product') // Relasi ke Product
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->product->name ?? 'Unknown',
                    'sold' => $item->sold,
                    'stock' => $item->product->stock->pluck('quantity', 'size')->toArray() ?? [],
                ];
            });

        // Top 5 Customers based on total spending
        $topCustomers = \App\Models\Order::selectRaw('user_id, SUM(total_price) as totalSpent, COUNT(*) as orders')
            ->groupBy('user_id')
            ->orderByDesc('totalSpent')
            ->with('user')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->user->name ?? 'Unknown',
                    'email' => $item->user->email ?? 'Unknown',
                    'orders' => $item->orders,
                    'totalSpent' => $item->totalSpent,
                ];
            });

        // Sales Trend (per bulan) — contoh 5 bulan terakhir
        $salesMonths = [];
        $salesData = [];
        for ($i = 4; $i >= 0; $i--) {
            $month = now()->subMonths($i)->format('M'); // Jan, Feb, etc
            $salesMonths[] = $month;
            $total = \App\Models\Order::whereMonth('created_at', now()->subMonths($i)->month)
                ->whereYear('created_at', now()->subMonths($i)->year)
                ->sum('total_price');
            $salesData[] = $total;
        }

        // Category Distribution
        $categoryLabels = [];
        $categoryData = [];

        $categories = ProductCategory::withCount(['products' => function ($query) {
            $query->where('status_del', 0); // cuma produk aktif
        }])->get();

        foreach ($categories as $category) {
            $categoryLabels[] = $category->name;
            $categoryData[] = $category->products_count;
        }

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
