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


Route::middleware('auth:api')->group(function(){
    Route::get('/products', [ProductsController::class, 'index']);
    Route::get('/favorites', [UserFavoriteProductsController::class, 'index']);
    Route::post('/add-to-favorites/{product_id}', [UserFavoriteProductsController::class, 'addToFavorites']);
    Route::post('/remove-from-favorites/{product_id}', [UserFavoriteProductsController::class, 'removeFromFavorites']);
    Route::get('/user/{user_id}', [AuthController::class, 'checkUser']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);