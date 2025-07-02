<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Allergen;
use App\Models\Category;
use App\Models\Food;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{

    public function index(Request $request)
    {
        $categoryId = $request->query('category');

        if ($categoryId) {
            //se ce il filtro category e non è vuoto
            $products = Product::with(['category', 'food', 'beverage', 'allergens'])
                ->where('category_id', $categoryId)
                ->get();
        } else {
            //altrimenti prendi tutti i prodotti
            $products = Product::with(['category', 'food', 'beverage', 'allergens'])
                ->orderBy('primary_price', 'asc')
                ->get();
        }

        $array = [];
        foreach ($products as $product) {

            $filteredproduct = [
                'id' => $product->id,
                'type' => $product->type,
                'category_id' => $product->category_id,
                'category_name' => $product->category->name,
                'name_it' => $product->name_it,
                'name_en' => $product->name_eng,
                'description_it' => $product->description_it,
                'description_en' => $product->description_eng,
                'primary_price' => $product->primary_price,
                'secondary_price' => $product->secondary_price,
            ];

            // if ($product->allergens) {
            //     $allergens = [];
            //     foreach ($product->allergens as $allergen) {
            //         array_push($allergens, $allergen->name);
            //     };
            //     $filteredproduct['allergens'] = $allergens;
            // }
            if ($product->allergens->isNotEmpty()) {
                $filteredproduct['allergens'] = $product->allergens->pluck('name');
            }

            if ($product->type === 'food' && $product->food) {
                $filteredproduct['is_spicy'] = $product->food->is_spicy;
                $filteredproduct['is_vegetarian'] = $product->food->is_vegetarian;
            }

            if ($product->type === 'drink' && $product->beverage) {
                $filteredproduct['is_alcholic'] = $product->beverage->is_alcholic;
                $filteredproduct['alcohol_volume'] = $product->beverage->alcohol_volume;
                $filteredproduct['primary_size'] = $product->beverage->primary_size;
                $filteredproduct['secondary_size'] = $product->beverage->secondary_size;
            }

            array_push($array, $filteredproduct);
        };
        // dd($array);

        return response()->json(
            [
                'success' => true,
                'data' => $array
            ]
        );
    }

    public function indexDb()
    {
        $products = Product::with(['category', 'food', 'beverage', 'allergens'])->get();

        return response()->json(
            [
                'success' => true,
                'data' => $products
            ]
        );
    }

    public function show(Product $product)
    {

        // carico i dati del prodotto dal db
        $product->load(['category', 'food', 'beverage', 'allergens']);

        // filtro il prodotto per gestire un output piu pulito
        $filteredProduct = [
            'id' => $product->id,
            'type' => $product->type,
            'category_id' => $product->category_id,
            'category_name' => $product->category->name,
            'name_it' => $product->name_it,
            'name_en' => $product->name_eng,
            'description_it' => $product->description_it,
            'description_en' => $product->description_eng,
            'primary_price' => $product->primary_price,
            'secondary_price' => $product->secondary_price,
        ];

        if ($product->allergens->isNotEmpty()) {
            $filteredProduct['allergens'] = $product->allergens->pluck('name');
        }

        if ($product->type === 'food' && $product->food) {
            $filteredProduct['is_spicy'] = $product->food->is_spicy;
            $filteredProduct['is_vegetarian'] = $product->food->is_vegetarian;
        }

        if ($product->type === 'drink' && $product->beverage) {
            $filteredProduct['is_alcholic'] = $product->beverage->is_alcholic;
            $filteredProduct['alcohol_volume'] = $product->beverage->alcohol_volume;
            $filteredProduct['primary_size'] = $product->beverage->primary_size;
            $filteredProduct['secondary_size'] = $product->beverage->secondary_size;
        }

        //invio risposta json
        return response()->json([
            'success' => true,
            'data' => $filteredProduct,
        ]);
    }
}
