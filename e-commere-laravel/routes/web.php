<?php

use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\Web\ProductController;
use Illuminate\Support\Facades\Route;

// Correcting import of the API controller
Route::get('/', function () {
    return view('welcome');
});

Route::get('/about', function() {
    return view('about');
});

//test download file
Route::get('app/download', function () {
    return response()->download(storage_path('app/private/C++ DIS.pdf'));
})->name('app.download');

// Web Routes (for browser)
Route::resource('products', ProductController::class);
Route::resource('categories', CategoryController::class);


