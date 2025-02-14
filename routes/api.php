<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/user', function (Request $request){
    return $request->user();
} )->middleware('auth:sanctum');

Route::apiResource('products', ProductController::class);

Route::apiResource('categories', CategoryController::class);

Route::post('/register', [AuthController::class,'register']);

Route::post('/login', [AuthController::class,'login']);

Route::delete('/logout', [AuthController::class,'logout'])->middleware('auth:sanctum');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/cart/add', [CartController::class, 'addToCart']);
    Route::get('/cart/{user_id}', [CartController::class, 'getCart']);
    Route::delete('/cart/remove/{cart_item_id}', [CartController::class, 'removeFromCart']);
    Route::post('/cart/checkout', [CartController::class, 'checkout']);
});
