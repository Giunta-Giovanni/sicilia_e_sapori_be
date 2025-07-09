<?php

use App\Http\Controllers\Admin\AllergensController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


// Rotta principale: homepage pubblica
Route::get('/', function () {
    return view('home');
});

// Rotta per la dashboard (visibile solo a utenti autenticati e verificati)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rotte protette da autenticazione (profilo utente)
Route::middleware(['auth', 'verified'])->group(function () {
    // Modifica profilo
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Aggiorna profilo
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Cancella profilo
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


/** ROTTE CRUD (ADMIN AREA) **/
// Rotte Crud Prodotti - accessibili solo se autenticati e verificati
Route::resource('products', ProductsController::class)
    ->middleware(['auth', 'verified']);

// Rotte Crud Categorie - accessibili solo se autenticati e verificati
Route::resource('categories', CategoriesController::class)
    ->middleware(['auth', 'verified']);

// Rotte Crud Allergeni - accessibili solo se autenticati e verificati
Route::resource('allergens', AllergensController::class)
    ->middleware(['auth', 'verified']);

// Inclusione delle rotte di autenticazione generate da Laravel Breeze
require __DIR__ . '/auth.php';
