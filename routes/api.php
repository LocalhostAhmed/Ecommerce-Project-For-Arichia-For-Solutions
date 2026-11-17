<?php

use App\Http\Controllers\Api\Admin\AdminAuthController as AdminAdminAuthController;
use App\Http\Controllers\Api\Admin\EmailVerificationController;
use App\Http\Controllers\Api\Admin\InventoryController as AdminInventoryController;
use App\Http\Controllers\Api\Admin\OrderAdminController;
use App\Http\Controllers\Api\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Api\Admin\ReviewAdminController;
use App\Http\Controllers\Api\Admin\SettingController;
use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CouponController;
use App\Http\Controllers\Api\InventoryAlertController;
use App\Http\Controllers\Api\InventoryController;
use App\Http\Controllers\Api\Manager\ManagerAuthController;
use App\Http\Controllers\Api\Manager\ManagerController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductImageController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\SuperAdmin\SuperAdminAuthController;
use App\Http\Controllers\Api\SuperAdmin\SuperAdminController;
use App\Http\Controllers\Api\Support\SupportAuthController;
use App\Http\Controllers\Api\Support\SupportController;
use App\Http\Controllers\Api\WishlistController;
use App\Http\Controllers\Api\CheckoutController;
use Illuminate\Support\Facades\Route;




// Public authentication routes.
Route::prefix('auth')->name('auth.')->group(function () {
    Route::post('/register', [AuthController::class, 'register',])->middleware('throttle:5,1')->name('register');
    Route::post('/login', [AuthController::class, 'login',])->middleware('throttle:5,1')->name('login');
});


// Protected routes.

Route::get('/profile', [AuthController::class, 'profile',])->name('profile');
Route::post('/logout', [AuthController::class, 'logout',])->name('logout');


// Done

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{product}', [ProductController::class, 'show']);

Route::middleware(['auth:admin', 'can:manage-products'])->group(function () {
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{product}', [ProductController::class, 'update']);
    Route::delete('/products/{product}', [ProductController::class, 'destroy']);
});

// Public endpoints.
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{category}', [CategoryController::class, 'show',]);

Route::middleware(['auth:admin', 'can:manage-categories'])->group(function () {
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::patch('/categories/{category}', [CategoryController::class, 'update',]);
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy',]);
});




Route::patch('/profile', [ProfileController::class, 'update']);




Route::get('/addresses', [AddressController::class, 'index']);
Route::post('/addresses', [AddressController::class, 'store']);
Route::get('/addresses/{address}', [AddressController::class, 'show']);
Route::patch('/addresses/{address}', [AddressController::class, 'update']);
Route::delete('/addresses/{address}', [AddressController::class, 'destroy']);
Route::patch('/addresses/{address}/default', [AddressController::class, 'setDefault']);




// Public: view a product's gallery.
Route::get('/products/{product}/images', [ProductImageController::class, 'index']);

// Admin-only: manage product images.
Route::middleware(['auth:admin', 'can:manage-products'])->group(function () {
    Route::post('/products/{product}/images', [ProductImageController::class, 'store']);
    Route::patch('/products/{product}/images/{image}/primary', [ProductImageController::class, 'setPrimary']);
    Route::delete('/products/{product}/images/{image}', [ProductImageController::class, 'destroy']);
});


Route::get('/products/{product}/inventory', [InventoryController::class, 'show']);

Route::middleware(['auth:admin', 'can:manage-products'])->group(function () {
    Route::post('/products/{product}/inventory/add', [InventoryController::class, 'add']);
    Route::post('/products/{product}/inventory/remove', [InventoryController::class, 'remove']);
    Route::put('/products/{product}/inventory', [InventoryController::class, 'set']);
    Route::post('/inventory/bulk-update', [InventoryController::class, 'bulkUpdate']);
    Route::get('/inventory/movements', [InventoryController::class, 'movements']);
    Route::get('/inventory/low-stock', [InventoryAlertController::class, 'lowStock']);
    Route::get('/inventory/out-of-stock', [InventoryAlertController::class, 'outOfStock']);
    Route::get('/inventory/summary', [InventoryAlertController::class, 'summary']);
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


Route::middleware(['auth:admin', 'can:manage-products'])
    ->prefix('admin')
    ->group(function () {
        Route::get('/orders', [OrderAdminController::class, 'index']);
        Route::patch('/orders/{order}/status', [OrderAdminController::class, 'updateStatus']);
        Route::get('/coupons', [CouponController::class, 'index']);
        Route::post('/coupons', [CouponController::class, 'store']);
        Route::get('/coupons/{coupon}', [CouponController::class, 'show']);
        Route::put('/coupons/{coupon}', [CouponController::class, 'update']);
        Route::delete('/coupons/{coupon}', [CouponController::class, 'destroy']);
    });



Route::get('/products/{product}/reviews', [ReviewController::class, 'index']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/products/{product}/reviews',   [ReviewController::class, 'store']);
    Route::put('/reviews/{review}',             [ReviewController::class, 'update']);
    Route::delete('/reviews/{review}',             [ReviewController::class, 'destroy']);
    Route::get('/reviews/mine',                 [ReviewController::class, 'mine']);
    Route::post('/reviews/{review}/helpful',     [ReviewController::class, 'helpful']);
});


Route::middleware(['auth:admin', 'can:manage-products'])
    ->prefix('admin')
    ->group(function () {
        Route::get('/reviews', [ReviewAdminController::class, 'index']);
        Route::get('/reviews/pending/count', [ReviewAdminController::class, 'pendingCount']);
        Route::patch('/reviews/{review}/moderate', [ReviewAdminController::class, 'moderate']);
        Route::delete('/reviews/{review}', [ReviewAdminController::class, 'destroy']);
    });


Route::middleware('auth:sanctum')->prefix('notifications')->group(function () {
    Route::get('/',                    [NotificationController::class, 'index']);
    Route::patch('/read-all',            [NotificationController::class, 'markAllAsRead']);
    Route::patch('/{id}/read',           [NotificationController::class, 'markAsRead']);
    Route::delete('/{id}',                [NotificationController::class, 'destroy']);
});

Route::prefix('super-admin')->group(function () {
    Route::post('/register', [SuperAdminAuthController::class, 'register']);
    Route::post('/login', [SuperAdminAuthController::class, 'login']);
    Route::post('/logout', [SuperAdminAuthController::class, 'logout'])->middleware('auth:super_admin');
});

Route::middleware('auth:super_admin')->prefix('super-admin')->group(function () {
    Route::get('/dashboard', [SuperAdminController::class, 'dashboard']);
    Route::get('/users', [SuperAdminController::class, 'users']);
    Route::get('/admins', [SuperAdminController::class, 'admins']);
    Route::get('/products', [SuperAdminController::class, 'products']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{product}', [ProductController::class, 'update']);
    Route::delete('/products/{product}', [ProductController::class, 'destroy']);
    Route::get('/categories', [SuperAdminController::class, 'categories']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::patch('/categories/{category}', [CategoryController::class, 'update']);
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);
    Route::get('/inventory', [SuperAdminController::class, 'inventory']);
    Route::get('/orders', [SuperAdminController::class, 'orders']);
    Route::get('/reviews', [SuperAdminController::class, 'reviews']);
    Route::get('/coupons', [CouponController::class, 'index']);
    Route::post('/coupons', [CouponController::class, 'store']);
    Route::put('/coupons/{coupon}', [CouponController::class, 'update']);
    Route::delete('/coupons/{coupon}', [CouponController::class, 'destroy']);
    Route::get('/settings', [SuperAdminController::class, 'settings']);
    Route::put('/settings', [SuperAdminController::class, 'updateSettings']);
    Route::put('/profile', [SuperAdminController::class, 'updateProfile']);
});

Route::prefix('manager')->group(function () {
    Route::post('/register', [ManagerAuthController::class, 'register']);
    Route::post('/login', [ManagerAuthController::class, 'login']);
    Route::post('/logout', [ManagerAuthController::class, 'logout'])->middleware('auth:manager');
});

Route::middleware('auth:manager')->prefix('manager')->group(function () {
    Route::get('/dashboard', [ManagerController::class, 'dashboard']);
    Route::get('/users', [ManagerController::class, 'users']);
    Route::get('/products', [ManagerController::class, 'products']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{product}', [ProductController::class, 'update']);
    Route::delete('/products/{product}', [ProductController::class, 'destroy']);
    Route::get('/categories', [ManagerController::class, 'categories']);
    Route::post('/categories', [CategoryController::class, 'store']);
    Route::patch('/categories/{category}', [CategoryController::class, 'update']);
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);
    Route::get('/inventory', [ManagerController::class, 'inventory']);
    Route::get('/orders', [ManagerController::class, 'orders']);
    Route::get('/coupons', [ManagerController::class, 'coupons']);
    Route::post('/coupons', [CouponController::class, 'store']);
    Route::put('/coupons/{coupon}', [CouponController::class, 'update']);
    Route::delete('/coupons/{coupon}', [CouponController::class, 'destroy']);
    Route::get('/reviews', [ManagerController::class, 'reviews']);
    Route::get('/settings', [ManagerController::class, 'settings']);
    Route::put('/profile', [ManagerController::class, 'updateProfile']);
});

Route::prefix('support')->group(function () {
    Route::post('/register', [SupportAuthController::class, 'register']);
    Route::post('/login', [SupportAuthController::class, 'login']);
    Route::post('/logout', [SupportAuthController::class, 'logout'])->middleware('auth:support');
});

Route::middleware('auth:support')->prefix('support')->group(function () {
    Route::get('/dashboard', [SupportController::class, 'dashboard']);
    Route::get('/products', [SupportController::class, 'products']);
    Route::get('/categories', [SupportController::class, 'categories']);
    Route::get('/inventory', [SupportController::class, 'inventory']);
    Route::get('/orders', [SupportController::class, 'orders']);
    Route::get('/users', [SupportController::class, 'users']);
    Route::get('/reviews', [SupportController::class, 'reviews']);
    Route::put('/profile', [SupportController::class, 'updateProfile']);
});


// Admin public routes
Route::prefix('admin')->group(function () {
    Route::post('/register', [AdminAdminAuthController::class, 'register']);
    Route::post('/Admin_register', [AdminAdminAuthController::class, 'register']);
    Route::post('/login', [AdminAdminAuthController::class, 'login']);
    Route::post('/Admin_login', [AdminAdminAuthController::class, 'login']);
});

// Admin protected routes (using admin guard)
Route::prefix('admin')->middleware('auth:admin')->group(function () {
    Route::post('/logout', [AdminAdminAuthController::class, 'logout']);
    Route::post('/Admin_logout', [AdminAdminAuthController::class, 'logout']);
    Route::post('/email/verification-notification', [EmailVerificationController::class, 'resend'])
        ->middleware('throttle:6,1')
        ->name('admin.verification.send');
});

// Email verification link (signed URL, protected by admin guard)
Route::get('/admin/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])
    ->middleware(['signed', 'auth:admin', 'throttle:6,1'])
    ->name('admin.verification.verify');

Route::middleware('auth:admin')->group(function () {
    Route::get('/settings', [SettingController::class, 'index']);
    Route::put('/settings', [SettingController::class, 'update']);
});
