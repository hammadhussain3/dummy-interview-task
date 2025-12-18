<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// ✅ Controllers imports (VERY IMPORTANT)
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Api\Customer\ProductController as CustomerProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    // 👤 CUSTOMER: View active products
    Route::get('/products', [CustomerProductController::class, 'index']);

    // 🛒 ORDERS
    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders', [OrderController::class, 'index']);

    // 🔐 ADMIN: Product management
    Route::prefix('admin')->middleware('role:admin')->group(function () {
        Route::apiResource('products', AdminProductController::class);
    });
});
