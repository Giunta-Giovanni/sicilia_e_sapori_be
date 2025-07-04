<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{

    // funzione index elaborata con richiesta di categorie
    public function index(Request $request)
    {
        //mi salvo la richiesta
        $categoryId = $request->query('category');

        // se la richiesta è esistente
        if ($categoryId) {
            // mi ricavo solo i prodotti della categoria
            $products = Product::with(['category', 'food', 'beverage', 'allergens'])
                ->where('category_id', $categoryId)
                ->get();
        } else {
            //altrimenti prendi tutti i prodotti e li ordino per prezzo
            $products = Product::with(['category', 'food', 'beverage', 'allergens'])
                ->orderBy('primary_price', 'asc')
                ->get();
        }

        // richiamo il metodo privato per organizzare il data in uscita
        $filtered = $products->map(function ($product) {
            return $this->filterProduct($product);
        });

        // ritorno la risposta 
        return response()->json(
            [
                'success' => true,
                'data' => $filtered
            ]
        );
    }

    // funzione index grezza
    public function indexDb()
    {
        // ricavo i prodotti con le tabelle associate
        $products = Product::with(['category', 'food', 'beverage', 'allergens'])->get();

        // ritorno la risposta 
        return response()->json(
            [
                'success' => true,
                'data' => $products
            ]
        );
    }

    // funzione show elaborata
    public function show(Product $product)
    {

        // carico i dati del prodotto dal db
        $product->load(['category', 'food', 'beverage', 'allergens']);

        // ritorno la risposta 
        return response()->json([
            'success' => true,
            'data' => $this->filterProduct($product)
        ]);
    }

    // Funzione privata di filtraggio
    private function filterProduct(Product $product)
    {
        //mi salvo il prodotto filtrati
        $filtered  = [
            'id' => $product->id, //id prodotto
            'type' => $product->type, // tipo di prodotto
            'category_id' => $product->category_id, //id della categoria
            'category_name' => $product->category->name, // nome della categoria
            'name_it' => $product->name_it, // nome in italiano
            'name_en' => $product->name_eng, // nome in inglese
            'description_it' => $product->description_it, // descrizione in italiano
            'description_en' => $product->description_eng, // descrizione in inglese
            'primary_price' => $product->primary_price, // prezzo primario
            'secondary_price' => $product->secondary_price, // prezzo secondario
        ];
        // -----funzione per creare un array semplice di allergeni-------
        // if ($product->allergens) {
        //     $allergens = [];
        //     foreach ($product->allergens as $allergen) {
        //         array_push($allergens, $allergen->name);
        //     };
        //     $filteredproduct['allergens'] = $allergens;
        // }

        // se il prodotto ha almeno un allergene associato
        if ($product->allergens->isNotEmpty()) {
            // aggiungo al prodotto filtrato un array contenente solo i nomi degli allergeni
            $filtered['allergens'] = $product->allergens->pluck('name');
        }

        //se il prodotto è un cibo e il prodotto è associato alla tabella food
        if ($product->type === 'food' && $product->food) {
            // aggiungiamo se piccante
            $filtered['is_spicy'] = $product->food->is_spicy;
            // aggiungiamo se vegetariano
            $filtered['is_vegetarian'] = $product->food->is_vegetarian;
        }

        // se il prodotto e una bevanda e e il prodotto è associato alla tabella bevande
        if ($product->type === 'drink' && $product->beverage) {
            // aggiungiamo se è alcolico
            $filtered['is_alcholic'] = $product->beverage->is_alcholic;
            // aggiungiamo la percentuale alcolica
            $filtered['alcohol_volume'] = $product->beverage->alcohol_volume;
            // aggiungiamo la dimensione primaria
            $filtered['primary_size'] = $product->beverage->primary_size;
            // aggiungiamo la dimensione secondaria
            $filtered['secondary_size'] = $product->beverage->secondary_size;
        }

        return $filtered;
    }
}
