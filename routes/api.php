<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\ProductImageController;
use App\Http\Controllers\Api\InventoryAlertController;
use App\Http\Controllers\Api\InventoryController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\WishlistController;
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\Admin\OrderAdminController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\Admin\ReviewAdminController;

// Public authentication routes.
Route::prefix('auth')->name('auth.')->group(function () {

    Route::post('/register', [
        AuthController::class,
        'register',
    ])->middleware('throttle:5,1')->name('register');

    Route::post('/login', [
        AuthController::class,
        'login',
    ])->middleware('throttle:5,1')->name('login');
});

// Email verification.
// Keep this route name exactly as verification.verify.
Route::get('/email/verify/{id}/{hash}', [
    AuthController::class,
    'verifyEmail',
])->middleware([
    'signed',
    'throttle:10,1',
])->name('verification.verify');

// Protected routes.
Route::middleware('auth:sanctum')->prefix('auth')->name('auth.')->group(function () {

    Route::post('/email/resend', [
        AuthController::class,
        'resendVerificationEmail',
    ])->middleware('throttle:3,1')->name('verification.resend');

    Route::get('/profile', [
        AuthController::class,
        'profile',
    ])->name('profile');

    Route::post('/logout', [
        AuthController::class,
        'logout',
    ])->name('logout');
});


Route::get('/products', [ProductController::class, 'index']);
Route::post('/products', [ProductController::class, 'store']);
Route::get('/products/{product}', [ProductController::class, 'show']);
Route::put('/products/{product}', [ProductController::class, 'update']);
Route::delete('/products/{product}', [ProductController::class, 'destroy']);

// Public endpoints.
Route::get('/categories', [CategoryController::class, 'index']);

Route::get('/categories/{category}', [
    CategoryController::class,
    'show',
]);

Route::get('/categories/{category}/products', [
    CategoryController::class,
    'products',
]);

// Protected endpoints: authenticated administrators only.
Route::middleware(['auth:sanctum', 'can:manage-categories'])->group(function () {
    Route::post('/categories', [CategoryController::class, 'store']);

    Route::patch('/categories/{category}', [
        CategoryController::class,
        'update',
    ]);

    Route::delete('/categories/{category}', [
        CategoryController::class,
        'destroy',
    ]);
});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show']);

    Route::patch('/profile', [ProfileController::class, 'update']);
});


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/addresses', [AddressController::class, 'index']);

    Route::post('/addresses', [AddressController::class, 'store']);

    Route::get('/addresses/{address}', [AddressController::class, 'show']);

    Route::patch('/addresses/{address}', [AddressController::class, 'update']);

    Route::delete('/addresses/{address}', [AddressController::class, 'destroy']);

    Route::patch(
        '/addresses/{address}/default',
        [AddressController::class, 'setDefault']
    );
});



// Public: view a product's gallery.
Route::get(
    '/products/{product}/images',
    [ProductImageController::class, 'index']
);

// Admin-only: manage product images.
Route::middleware(['auth:sanctum', 'can:manage-products'])->group(function () {
    Route::post(
        '/products/{product}/images',
        [ProductImageController::class, 'store']
    );

    Route::patch(
        '/products/{product}/images/{image}/primary',
        [ProductImageController::class, 'setPrimary']
    );

    Route::delete(
        '/products/{product}/images/{image}',
        [ProductImageController::class, 'destroy']
    );
});


Route::get('/products/{product}/inventory', [InventoryController::class, 'show']);

Route::middleware(['auth:sanctum', 'can:manage-products'])->group(function () {
    Route::post('/products/{product}/inventory/add',    [InventoryController::class, 'add']);
    Route::post('/products/{product}/inventory/remove', [InventoryController::class, 'remove']);
    Route::put('/products/{product}/inventory',        [InventoryController::class, 'set']);

    Route::post('/inventory/bulk-update', [InventoryController::class, 'bulkUpdate']);
    Route::get('/inventory/movements',   [InventoryController::class, 'movements']);

    Route::get('/inventory/low-stock',    [InventoryAlertController::class, 'lowStock']);
    Route::get('/inventory/out-of-stock', [InventoryAlertController::class, 'outOfStock']);
    Route::get('/inventory/summary',      [InventoryAlertController::class, 'summary']);
});



Route::prefix('cart')->group(function () {
    Route::get('/',              [CartController::class, 'show']);
    Route::post('/items',         [CartController::class, 'addItem']);
    Route::put('/items/{item}',  [CartController::class, 'updateItem']);
    Route::delete('/items/{item}',  [CartController::class, 'removeItem']);
    Route::delete('/',              [CartController::class, 'clear']);
    Route::get('/subtotal',      [CartController::class, 'subtotal']);
});


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/cart/merge', [CartController::class, 'merge']);
});



Route::middleware('auth:sanctum')->prefix('wishlist')->group(function () {
    Route::get('/',                          [WishlistController::class, 'index']);
    Route::post('/items',                     [WishlistController::class, 'store']);
    Route::delete('/items/{product}',           [WishlistController::class, 'destroy']);
    Route::post('/items/{product}/move-to-cart', [WishlistController::class, 'moveToCart']);
});



Route::middleware('auth:sanctum')->group(function () {
    Route::post('/checkout/preview', [CheckoutController::class, 'preview']);
    Route::post('/checkout',         [CheckoutController::class, 'place']);

    Route::get('/orders',                       [OrderController::class, 'index']);
    Route::get('/orders/{order}',               [OrderController::class, 'show']);
    Route::get('/orders/{order}/tracking',      [OrderController::class, 'tracking']);
    Route::post('/orders/{order}/cancel',        [OrderController::class, 'cancel']);
});


Route::middleware(['auth:sanctum', 'can:manage-products'])
    ->prefix('admin')
    ->group(function () {
        Route::get('/orders',                   [OrderAdminController::class, 'index']);
        Route::patch('/orders/{order}/status',    [OrderAdminController::class, 'updateStatus']);
    });



Route::get('/products/{product}/reviews', [ReviewController::class, 'index']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/products/{product}/reviews',   [ReviewController::class, 'store']);
    Route::put('/reviews/{review}',             [ReviewController::class, 'update']);
    Route::delete('/reviews/{review}',             [ReviewController::class, 'destroy']);
    Route::get('/reviews/mine',                 [ReviewController::class, 'mine']);
    Route::post('/reviews/{review}/helpful',     [ReviewController::class, 'helpful']);
});


Route::middleware(['auth:sanctum', 'can:manage-products'])
    ->prefix('admin')
    ->group(function () {
        Route::get('/reviews',                     [ReviewAdminController::class, 'index']);
        Route::get('/reviews/pending/count',       [ReviewAdminController::class, 'pendingCount']);
        Route::patch('/reviews/{review}/moderate',   [ReviewAdminController::class, 'moderate']);
        Route::delete('/reviews/{review}',            [ReviewAdminController::class, 'destroy']);
    });


Route::middleware('auth:sanctum')->prefix('notifications')->group(function () {
    Route::get('/',                    [NotificationController::class, 'index']);
    Route::patch('/read-all',            [NotificationController::class, 'markAllAsRead']);
    Route::patch('/{id}/read',           [NotificationController::class, 'markAsRead']);
    Route::delete('/{id}',                [NotificationController::class, 'destroy']);
});
