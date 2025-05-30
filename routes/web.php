<?php

use App\Http\Controllers\Admin\AllergensController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rotte Crud Prodotti
Route::resource('products', ProductsController::class)
    ->middleware(['auth', 'verified']);

// Rotte Crud Categorie
Route::resource('categories', CategoriesController::class)
    ->middleware(['auth', 'verified']);

// Rotte Crud Allergeni
Route::resource('allergens', AllergensController::class)
    ->middleware(['auth', 'verified']);

require __DIR__ . '/auth.php';
