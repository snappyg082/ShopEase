<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\SmsController;

// sms routes
Route::middleware(['auth'])->group(function () {
    Route::get('/sms', [SmsController::class, 'index'])->name('sms.index');
    Route::get('/sms/{sms}', [SmsController::class, 'show'])->name('sms.show');
});
Route::get('/', function () {
    return redirect()->route('chat.view');
});

Route::middleware(['auth'])->group(function () {
    // Open chat page
    Route::get('/index', [ChatController::class, 'index'])
        ->name('index');

    // Send message (AJAX)
    Route::post('/chat', [ChatController::class, 'chat'])
        ->name('chat.send');
});
//Search route
Route::get('/search', [SearchController::class, 'index'])
    ->name('global.search');

//product routes
Route::get('/products', [ProductController::class, 'index'])
    ->name('products.index');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
Route::get('shop/products/search', [ProductController::class, 'search'])->name('shop.products.search');

// Dashboard routes
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
Route::get('/', [DashboardController::class, 'index'])->name('home');

// shop routes
Route::get('/shop/products', [ShopController::class, 'products'])->name('shop.products');
Route::get('/shop/carts', [ShopController::class, 'carts'])->name('shop.carts');
Route::get('/shop/orders', [ShopController::class, 'orders'])->name('shop.orders');

// AuthenticatedSession routes
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// checkout route
Route::get('/checkout', [CheckoutController::class, 'index'])
    ->name('checkout')
    ->middleware('auth');

// Auth routes
Route::middleware('auth')->group(function () {

    // Profile management
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::get('/profile.show', [ProfileController::class, 'show'])->name('show.');
    });

    // Cart routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::patch('/carts/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/carts/create', [CartController::class, 'store'])->name('cart.store');


    // Orders
    Route::get('/orders/{order}/notifications', [OrderController::class, 'viewNotifications'])->name('orders.notifications');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::patch('/orders/create/{id}', [OrderController::class, 'update'])->name('orders.create');
    Route::post('/orders/create', [OrderController::class, 'store'])->name('orders.store');
});

require __DIR__ . '/auth.php';
