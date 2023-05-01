<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HelloWorldController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ShopController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [WelcomeController::class, 'index'])->name('welcome');

Route::middleware(['auth', 'verified'])->group(function() {
    Route::resource('products', ProductController::class)->middleware('can:isAdmin');

    Route::get('/users/list', [UserController::class, 'index'])->middleware('can:isAdmin');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->middleware('can:isAdmin');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show')->middleware('auth');

    Route::get('cart', [ProductController::class, 'cart'])->name('cart');
    Route::get('add-to-cart/{id}', [ProductController::class, 'addToCart'])->name('add_to_cart');
    Route::patch('update-cart', [ProductController::class, 'update_cart'])->name('update_cart');
    Route::delete('remove-from-cart', [ProductController::class, 'remove'])->name('remove_from_cart');

});
Route::get('/hello', [HelloWorldController::class, 'show']);
Route::get('lang/{lang}', ['as' => 'lang.switch', 'uses' => 'App\Http\Controllers\LanguageController@switchLang']);

Auth::routes(['verify' => true]);