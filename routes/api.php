<?php

use App\Http\Controllers\Api\ProductsController; // importo controller gestione rotte prodotti
use Illuminate\Support\Facades\Route; // importo facciata gestione rotte

// INDEX
// Tutti i prodotti con output Elaborato
Route::get('products', [ProductsController::class, 'index']);

// Tutti i prodotti con output Grezzo
Route::get('db_products', [ProductsController::class, 'indexDb']);

// SHOW
Route::get('products/{product}', [ProductsController::class, 'show']);
