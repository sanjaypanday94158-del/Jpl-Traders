<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerAccountController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\StoreController;

Route::get('/', [StoreController::class, 'home'])->name('home');
Route::get('/products', [StoreController::class, 'products'])->name('products');
Route::get('/products/{sku}', [StoreController::class, 'product'])->name('product.show');
Route::get('/cart', [StoreController::class, 'cart'])->name('cart.index');
Route::post('/cart/items', [StoreController::class, 'addToCart'])->name('cart.items.store');
Route::patch('/cart/items/{slug}', [StoreController::class, 'updateCartItem'])->name('cart.items.update');
Route::delete('/cart/items/{slug}', [StoreController::class, 'removeCartItem'])->name('cart.items.destroy');
Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'store'])->middleware('throttle:10,1')->name('checkout.store');
Route::get('/track/{orderNumber}/{token}', [CheckoutController::class, 'track'])->name('orders.track');
Route::post('/track/{orderNumber}/{token}/cancel', [CheckoutController::class, 'cancelTrackedOrder'])
    ->middleware('throttle:5,1')
    ->name('orders.cancel-tracked');
Route::get('/track-order', [CheckoutController::class, 'trackingLookupForm'])->name('orders.track-lookup');
Route::post('/track-order', [CheckoutController::class, 'trackingLookup'])->middleware('throttle:5,1')->name('orders.track-lookup.submit');
Route::get('/customer/login', [CustomerAccountController::class, 'loginForm'])->name('customer.login');
Route::post('/customer/login', [CustomerAccountController::class, 'login'])->middleware('throttle:5,1')->name('customer.login.submit');
Route::get('/login', [CustomerAccountController::class, 'loginForm'])->name('login');
Route::get('/customer/register', [CustomerAccountController::class, 'registerForm'])->name('customer.register');
Route::post('/customer/register', [CustomerAccountController::class, 'register'])->middleware('throttle:5,1')->name('customer.register.submit');
Route::post('/customer/logout', [CustomerAccountController::class, 'logout'])->name('customer.logout');
Route::middleware('auth')->prefix('account')->group(function () {
    Route::get('/', [CustomerAccountController::class, 'index'])->name('account.index');
    Route::get('/orders/{orderNumber}', [CustomerAccountController::class, 'order'])->name('account.orders.show');
    Route::post('/orders/{orderNumber}/cancel', [CustomerAccountController::class, 'cancelOrder'])
        ->middleware('throttle:5,1')
        ->name('account.orders.cancel');
});
Route::get('/{page}', [StoreController::class, 'page'])
    ->where('page', 'about|services|institutional|contact|faq|quote')
    ->name('shop.page');
Route::post('/enquiry', [StoreController::class, 'submitEnquiry'])->name('enquiry.submit');
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])
    ->middleware('throttle:5,1')
    ->name('newsletter.subscribe');

Route::get('/api/products', [ProductApiController::class, 'index']);
Route::get('/api/products/{slug}', [ProductApiController::class, 'show']);

Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

Route::prefix('admin')->middleware('admin.session')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/products', [AdminController::class, 'products'])->name('admin.products');
    Route::post('/products', [AdminController::class, 'storeProduct'])->name('admin.products.store');
    Route::put('/products/{product}', [AdminController::class, 'updateProduct'])->name('admin.products.update');
    Route::get('/categories', [AdminController::class, 'categories'])->name('admin.categories');
    Route::post('/categories', [AdminController::class, 'storeCategory'])->name('admin.categories.store');
    Route::put('/categories/{category}', [AdminController::class, 'updateCategory'])->name('admin.categories.update');
    Route::delete('/categories/{category}', [AdminController::class, 'destroyCategory'])->name('admin.categories.destroy');
    Route::get('/brands', [AdminController::class, 'brands'])->name('admin.brands');
    Route::post('/brands', [AdminController::class, 'storeBrand'])->name('admin.brands.store');
    Route::put('/brands/{brand}', [AdminController::class, 'updateBrand'])->name('admin.brands.update');
    Route::get('/orders', [AdminController::class, 'orders'])->name('admin.orders');
    Route::get('/orders/{orderNumber}', [AdminController::class, 'order'])->name('admin.orders.show');
    Route::patch('/orders/{orderNumber}', [AdminController::class, 'updateOrderStatus'])->name('admin.orders.status');
    Route::post('/orders/{orderNumber}/collect-cod', [AdminController::class, 'collectCod'])->name('admin.orders.collect-cod');
    Route::get('/customers', [AdminController::class, 'customers'])->name('admin.customers');
    Route::get('/customers/{customerId}', [AdminController::class, 'customer'])->name('admin.customers.show');
    Route::get('/enquiries', [AdminController::class, 'enquiries'])->name('admin.enquiries');
});
