<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\WishlistController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Ini adalah semua route untuk aplikasi Veravia
*/

// Halaman utama dan /home mengarah ke home.blade.php
Route::get('/', [HomeController::class, 'show'])->name('home');
Route::get('/home', [HomeController::class, 'show']); // Tambahan supaya /home tidak 404

// Login
Route::get('/login', [AuthController::class, 'show'])->name('login.show');
Route::post('/login_auth', [AuthController::class, 'login_auth'])->name('login.auth');

// Register
Route::get('/register', [AuthController::class, 'auth_register'])->name('register');
// Route::post('/registers', [AuthController::class, 'storeRegister'])->name('register.store'); // Aktifkan jika siap

// Lupa password
Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email.custom');

// Store
Route::get('/store', [ProductController::class, 'index'])->name('store.show'); // Use ProductController to handle the store page

// Route for the product details page
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');

// Support
Route::get('/support', [SupportController::class, 'show'])->name('support.show');

//  Route::get('/cart', [CartController::class, 'show'])->name('cart.show');

// Route to view the cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');

Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');

Route::post('/cart/update', [CartController::class, 'bulkUpdate'])->name('cart.bulkUpdate');

// Route to edit quantity from the cart
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');

// Route to remove an item from the cart
Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

// Route to handle the checkout
Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

Route::post('/cart/apply-promo', [CartController::class, 'applyPromo'])->name('cart.applyPromo');

Route::get('/cart/checkout/detail', [CartController::class, 'checkoutDetail'])->name('cart.checkoutDetail');

Route::get('/wishlist', [WishlistController::class, 'show'])->name('wishlist.show');

Route::get('/order-history', [CartController::class, 'orderHistory'])->name('order.history');

// Logout
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');

// Show the edit form for a specific product
Route::get('/admin/product/{id}/edit', [AdminController::class, 'edit'])->name('admin.product.edit');

// Route to handle the form submission (update product)
Route::post('/admin/product/{id}', [AdminController::class, 'update'])->name('admin.product.update');

// Show the form for adding a new product
Route::get('/admin/product/create', [AdminController::class, 'create'])->name('admin.product.create');

// Handle the form submission for adding a new product
Route::post('/admin/product', [AdminController::class, 'store'])->name('admin.product.store');

// Route to admin's sales list
Route::get('/admin/sales', [SalesController::class, 'index'])->name('admin.sales.index');

// Route to Invoice page
Route::get('/admin/invoice/{sales_id}', [InvoiceController::class, 'index'])->name('admin.invoice.index');

// Route for User List
Route::get('/admin/users', [AdminController::class, 'userList'])->name('admin.userlist');

// Route for User Details
Route::get('/admin/user/{id}', [AdminController::class, 'userDetails'])->name('admin.user.details');

// Route for showing Promos
Route::get('/admin/promos', [AdminController::class, 'promoList'])->name('admin.promo.list');

// Route for create promos
Route::get('/admin/promo/create', [AdminController::class, 'createPromo'])->name('admin.promo.create');

// handle POST submission in promo
Route::post('/admin/promo/store', [AdminController::class, 'storePromo'])->name('admin.promo.store'); 

// Promo Details page
Route::get('/admin/promo/{id}/edit', [AdminController::class, 'showPromoDetails'])->name('admin.promo.details');

// Route for promo update
Route::put('/admin/promo/{id}', [AdminController::class, 'updatePromo'])->name('admin.promo.update');