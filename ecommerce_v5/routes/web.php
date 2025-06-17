<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\PaymentDetailController;

Route::get('/', function () {
    return view('welcome');
});

// Grouping the documentation routes under "/api-docs"
Route::prefix('api-docs')->group(function () {
    // Default introduction tab (first page)
    Route::get('/', function () {
        return view('apiDocs.sections.introduction');
    })->name('api-docs');

    // Other documentation sections based on sidebar
    Route::get('/products', function () {
        return view('apiDocs.sections.products');
    })->name('api-docs.products');

    Route::get('/discounts', function () {
        return view('apiDocs.sections.discounts');
    })->name('api-docs.discounts');

    Route::get('/categories', function () {
        return view('apiDocs.sections.categories');
    })->name('api-docs.categories');

    Route::get('/inventories', function () {
        return view('apiDocs.sections.inventories');
    })->name('api-docs.inventories');

    Route::get('/order-details', function () {
        return view('apiDocs.sections.orderDetails');
    })->name('api-docs.orderDetails');

    Route::get('/documents', function () {
        return view('apiDocs.sections.documents');
    })->name('api-docs.documents');
});


Route::get('/download', function () {
    $path = public_path('files/Product_Documentation.docx'); // Adjust the path and filename

    if (file_exists($path)) {
        return response()->download($path);
    }
    abort(404);
})->name('file.product');

// Resource routes for web logic
Route::group(['prefix' => 'client', 'namespace' => 'App\Http\Controllers'], function () {
    Route::resource('products', ProductController::class);
    Route::resource('discounts', DiscountController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('inventories', InventoryController::class);
    Route::resource('orderDetails', OrderDetailController::class);
    Route::resource('orderItems', OrderItemController::class);
    Route::resource('payments', PaymentDetailController::class);
    Route::resource('users', \App\Http\Controllers\UserController::class);

});
