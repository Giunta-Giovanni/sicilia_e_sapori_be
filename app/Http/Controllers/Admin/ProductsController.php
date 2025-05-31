<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Allergen;
use App\Models\Beverage;
use App\Models\Category;
use App\Models\Food;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::orderby('category_id', 'asc')->get();
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $type = $request->query('type');
        $products = Product::orderby('category_id', 'asc')->get();
        $categories = Category::all();
        $allergens = Allergen::all();


        return view('products.create', compact('type', 'products', 'categories', 'allergens'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //salvataggio dei dati
        $data = $request->all();

        $validated = $request->validate([
            'type' => 'required|in:food,drink',
            // campi comuni
            'category_id' => 'required|exists:categories,id',
            'name_it' => 'required|string|max:50',
            'name_eng' => 'nullable|string|max:50',
            'description_it' => 'nullable|string',
            'description_eng' => 'nullable|string',
            'primary_price' => ['required', 'regex:/^\d{1,2}([,.]\d{1,2})?$/'],
            'secondary_price' => ['nullable', 'regex:/^\d{1,2}([,.]\d{1,2})?$/'],

            // campi specifici per food
            'is_spicy' => 'nullable|boolean',
            'is_vegetarian' => 'nullable|boolean',

            // campi specifici per drink
            'alcohol_volume' => ['nullable', 'regex:/^\d{1,3}([,.]\d)?$/'],
            'primary_size' => ['integer', 'between:1,9999'],
            'secondary_size' => ['nullable', 'integer', 'between:1,9999'],
            'is_alcholic' => 'nullable|boolean',
        ]);
        // validazione dei dati
        // normalizza i decimali
        $validated['primary_price'] = str_replace(',', '.', $validated['primary_price']);
        $validated['secondary_price'] = isset($validated['secondary_price']) ? str_replace(',', '.', $validated['secondary_price']) : null;
        $validated['alcohol_volume'] = isset($validated['alcohol_volume']) ? str_replace(',', '.', $validated['alcohol_volume']) : null;

        // dd($validated);
        // dd($data);

        //creiamo un nuovo prodotto
        $newProduct = new Product();

        $newProduct->type = $validated['type'];
        $newProduct->category_id = $validated['category_id'];
        $newProduct->name_it = $validated['name_it'];
        $newProduct->name_eng = $validated['name_eng'];
        $newProduct->description_it = $validated['description_it'];
        $newProduct->description_eng = $validated['description_eng'];
        $newProduct->primary_price = $validated['primary_price'];
        $newProduct->secondary_price = $validated['secondary_price'];

        $newProduct->save();


        if ($validated['type'] === "food") {
            // ricaviamoci il nuovo id 
            $newfood = new Food();

            $newfood->product_id = $newProduct->id;
            $newfood->is_spicy = $validated['is_spicy'];
            $newfood->is_vegetarian = $validated['is_vegetarian'];

            $newfood->save();
        } elseif ($validated['type'] === "drink") {

            $newBeverage = new Beverage();

            $newBeverage->product_id = $newProduct->id;
            $newBeverage->is_alcholic = $validated['is_alcholic'];
            $newBeverage->alcohol_volume = $validated['alcohol_volume'];
            $newBeverage->primary_size = $validated['primary_size'];
            $newBeverage->secondary_size = $validated['secondary_size'];

            $newBeverage->save();
        }
        return redirect()->route('products.show', $newProduct);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $allergens = Allergen::all();

        return view('products.edit', compact('product', 'categories', 'allergens'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
