<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HeroeController;
use App\Http\Controllers\NinjasController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/ninjas',[NinjasController::class,"index"] )->name('ninjas.index');
Route::get('/ninjas/create', [NinjasController::class,"create"])->name('ninjas.create');
Route::post('/ninjas', [NinjasController::class,"store"])->name('ninjas.store');
Route::get('/ninjas/{id}', [NinjasController::class,"show"] )->name('ninjas.show');