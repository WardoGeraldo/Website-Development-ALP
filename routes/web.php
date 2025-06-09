<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\MidtransCallbackController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Middleware\CheckRoleMiddleWare; // ⬅️ tambahkan ini
use Carbon\Cli\Invoker;

/*
|--------------------------------------------------------------------------
| Web Routes — Veravia
|--------------------------------------------------------------------------
*/

// — Public routes (siapa saja) —
Route::get('/', [ProductController::class, 'home'])->name('home');
Route::get('/home', [HomeController::class, 'show']);
Route::get('/store', [ProductController::class, 'index'])->name('store.show');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
Route::get('/size-chart', fn() => view('size-chart'))->name('size.chart');
Route::get('/support', [SupportController::class, 'show'])->name('support.show');



// Forgot Password Form
Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
// Forgot Password Submit (POST)
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');


// Reset password form
Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

// — Guest routes (hanya untuk yang belum login) —
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'show'])->name('login');
    Route::post('/login_auth', [AuthController::class, 'login_auth'])->name('login.auth');

    Route::get('/register', [AuthController::class, 'auth_register'])->name('register');
    Route::post('/register', [AuthController::class, 'storeRegister'])->name('register.store');
});



// — Semua route di sini hanya untuk yang sudah login —
Route::middleware('manual_auth')->group(function () {
    // Logout
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // — Customer area —
    Route::middleware([CheckRoleMiddleWare::class . ':customer'])->group(function () {
        Route::get('/wishlist', [WishlistController::class, 'show'])->name('wishlist.show');
        Route::post('/wishlist/add', [WishlistController::class, 'add'])->name('wishlist.add');
        Route::delete('/wishlist/remove', [WishlistController::class, 'remove'])->name('wishlist.remove');
        Route::get('/order-history', [CartController::class, 'orderHistory'])->name('order.history');

        Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
        Route::post('/cart/update', [CartController::class, 'bulkUpdate'])->name('cart.bulkUpdate');
        Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
        Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
        Route::post('/cart/apply-promo', [CartController::class, 'applyPromo'])->name('cart.applyPromo');
        Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
        Route::get('/cart/checkout/detail', [CartController::class, 'checkoutDetail'])->name('cart.checkoutDetail');
        Route::post('/checkout/shipment', [CartController::class, 'storeShipment'])->name('checkout.shipment');
        Route::post('/checkout/process', [CartController::class, 'processCheckout'])->name('cart.processCheckout');
        // Route::get('/midtrans/notification', [CartController::class, 'handleNotification']);
        Route::post('/midtrans/callback', [MidtransCallbackController::class, 'handle']);
        // Route::get('/order/shipment-detail', [ShipmentController::class, 'show'])->name('shipment.show');
        Route::get('/shipment/{order_id}', [CartController::class, 'showShipment'])->name('shipment.show');
        Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
        Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');
        Route::post('/support', [SupportController::class, 'store'])->name('support.store');
    });

    // — Admin area —
    Route::prefix('admin')->middleware([CheckRoleMiddleWare::class . ':admin'])->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');

        Route::get('/dashboard', [AdminController::class, 'dashboardView'])->name('admin.dash');
        Route::get('/product/create', [AdminController::class, 'create'])->name('admin.product.create');
        Route::post('/product', [AdminController::class, 'store'])->name('admin.product.store');
        Route::get('/product/{id}/edit', [AdminController::class, 'edit'])->name('admin.product.edit');
        Route::put('/product/{id}', [AdminController::class, 'update'])->name('admin.product.update');
        Route::delete('/product/{id}', [AdminController::class, 'destroy'])->name('admin.product.delete');
        Route::delete('/admin/product/{id}/image', [AdminController::class, 'deleteImage'])->name('admin.product.image.delete');
        Route::put('/admin/product/image/{id}', [AdminController::class, 'updateImage'])->name('admin.product.image.update');
        Route::put('/admin/product/{id}/image/{image_id}/replace', [AdminController::class, 'replaceImage'])->name('admin.product.image.replace');





        Route::get('/promos', [AdminController::class, 'promoList'])->name('admin.promo.list');
        Route::get('/promo/create', [AdminController::class, 'createPromo'])->name('admin.promo.create');
        Route::post('/promo/store', [AdminController::class, 'storePromo'])->name('admin.promo.store');
        Route::get('/promo/{id}/edit', [AdminController::class, 'showPromoDetails'])->name('admin.promo.details');
        Route::put('/promo/{id}', [AdminController::class, 'updatePromo'])->name('admin.promo.update');

        Route::get('/sales', [InvoiceController::class, 'salesList'])->name('admin.sales.index');
        Route::get('/invoice/{sales_id}', [InvoiceController::class, 'index'])->name('admin.invoice.index');
        Route::put('/admin/shipment/{shipment_id}', [InvoiceController::class, 'updateShipmentStatus'])->name('admin.shipment.update');

        Route::get('/users', [AdminController::class, 'userList'])->name('admin.userlist');
        Route::get('/user/{id}', [AdminController::class, 'userDetails'])->name('admin.user.details');
        Route::get('/user/{id}/edit', [AdminController::class, 'editUser'])->name('admin.user.edit');
        Route::put('/user/{id}/update', [AdminController::class, 'updateUser'])->name('admin.user.update');
        Route::delete('/admin/user/delete/{id}', [AdminController::class, 'deleteUser'])->name('admin.user.delete');
    });
});
