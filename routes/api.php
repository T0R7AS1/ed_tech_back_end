<?php

use Illuminate\Http\Request;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UserFavoriteProductsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::middleware([Authenticate::class])->group(function(){
    Route::get('/products', [ProductsController::class, 'index'])->name('products.index');
    Route::get('/favorites', [UserFavoriteProductsController::class, 'index'])->name('user_favorite_products.index');
    Route::post('/favorites/{product_id}', [UserFavoriteProductsController::class, 'store'])->name('user_favorite_products.store');
});

Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');