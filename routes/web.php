<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';


Route::get('/home', function () {
    return view('main_pages.home');
});


Route::get('/products', function () {
    return view('main_pages.products');
});


Route::get('/category', function () {
    return view('main_pages.category');
});


Route::get('/search_page', function () {
    return view('main_pages.search_page');
});


Route::get('/product_details', function () {
    return view('main_pages.product_details');
});


Route::get('/brands', function () {
    return view('main_pages.Brands');
});


Route::get('/brand_products', function () {
    return view('main_pages.Brands_products');
});