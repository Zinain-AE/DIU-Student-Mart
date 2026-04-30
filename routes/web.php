<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReviewController;

/*
|--------------------------------------------------------------------------
| Public & Global Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');

// Shopping Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove'); 
Route::patch('/update-cart', [CartController::class, 'update'])->name('cart.update');

// Reviews
Route::post('/reviews/store/{productId}', [ReviewController::class, 'store'])->name('reviews.store')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Shared Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->role === 'admin') return redirect()->route('admin.dashboard');
        if ($user->role === 'seller') return redirect()->route('seller.dashboard');
        return redirect()->route('products.index'); 
    })->name('dashboard');

    Route::post('/become-seller', [RoleController::class, 'becomeSeller'])->name('become.seller');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');

    // My Orders Flow
    Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.index');
    Route::delete('/orders/{id}/cancel', [OrderController::class, 'cancelOrder'])->name('orders.cancel');
});

/*
|--------------------------------------------------------------------------
| Admin Phase
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/products', [AdminController::class, 'products'])->name('products');
    Route::delete('/products/{id}', [AdminController::class, 'deleteProduct'])->name('products.delete');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::patch('/users/{id}/block', [AdminController::class, 'blockUser'])->name('users.block');
});

/*
|--------------------------------------------------------------------------
| Seller Phase
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'seller'])->prefix('seller')->name('seller.')->group(function () {
    Route::get('/dashboard', [SellerController::class, 'index'])->name('dashboard');
    
    // Inventory
    Route::get('/products/create', [SellerController::class, 'create'])->name('products.create');
    Route::post('/products/store', [SellerController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [SellerController::class, 'edit'])->name('products.edit');
    
    Route::match(['put', 'patch'], '/products/{id}', [SellerController::class, 'update'])->name('products.update');
    
    Route::delete('/products/{id}', [SellerController::class, 'delete'])->name('products.delete');

    // Order Management
    Route::get('/orders', [SellerController::class, 'orders'])->name('orders');
    Route::post('/orders/{id}/update-status', [SellerController::class, 'updateOrderStatus'])->name('orders.updateStatus');
});

require __DIR__.'/auth.php';