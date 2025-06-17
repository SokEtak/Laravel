<?php

use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\DiscountController;
use App\Http\Controllers\API\InventoryController;
use App\Http\Controllers\API\OrderDetailController;
use App\Http\Controllers\API\OrderItemController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\PaymentDetailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('app/download', function () {
    return response()->download(storage_path('app/private/C++ DIS.pdf'));
})->name('app.download');

Route::group(['prefix' => 'v1','namespace'=>'App\Http\Controllers'],function () {
    Route::apiResource('products', ProductController::class);
    Route::apiResource('discounts', DiscountController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::apiResource('inventories', InventoryController::class);
    Route::apiResource('orderDetails', OrderDetailController::class);
    Route::apiResource('orderItems', OrderItemController::class);
    Route::apiResource('users', UserController::class);
    Route::apiResource('payments', PaymentDetailController::class);
});


