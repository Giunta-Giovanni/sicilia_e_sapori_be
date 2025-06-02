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
    public function index(Request $request)
    {
        $categories = Category::orderBy('name')->get();

        $categoryId = $request->query('category');

        if ($categoryId) {
            // Se c'è un filtro category e non è vuoto
            $products = Product::where('category_id', $categoryId)->get();
        } else {
            // Altrimenti prendi tutti i prodotti
            $products = Product::all();
        }

        return view('products.index', compact('categories', 'products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $type = $request->query('type');
        $products = Product::orderby('category_id', 'asc')->get();
        $categories = Category::orderby('name')->get();
        $allergens = Allergen::orderby('name')->get();


        return view('products.create', compact('type', 'products', 'categories', 'allergens'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //salvataggio dei dati
        $data = $request->all();

        // validazione dei dati
        $validated = $request->validate(
            [
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
                'is_spicy' => 'required_if:type,food|boolean',
                'is_vegetarian' => 'required_if:type,food|boolean',

                // campi specifici per drink
                'alcohol_volume' => 'required_if:type,drink|regex:/^\d{1,3}([,.]\d)?$/',
                'primary_size' => 'required_if:type,drink|integer|between:0,9999',
                'secondary_size' => 'nullable|integer|between:0,9999',
                'is_alcholic' => 'required_if:type,drink|boolean',
            ],
            // messaggi di errore personalizzati
            [

                //nomi
                'name_it.required' => 'Il nome in italiano è obbligatorio.',
                'name_it.max' => 'Il nome in italiano non può superare i 50 caratteri.',
                'name_eng.max' => 'Il nome in inglese non può superare i 50 caratteri.',

                // prezzi
                'primary_price.required' => 'Il prezzo principale è obbligatorio.',
                'primary_price.regex' => 'Il prezzo deve essere un numero minore di 100 (es. 12,50 o 12.50)',
                'secondary_price.regex' => 'Il prezzo deve essere un numero minore di 100 (es. 12,50 o 12.50).',

                // food
                'is_spicy.required_if' => 'Indica se il piatto è piccante.',
                'is_spicy.boolean' => 'Il campo "piccante" deve essere vero o falso.',
                'is_vegetarian.required_if' => 'Indica se il piatto è vegetariano.',
                'is_vegetarian.boolean' => 'Il campo "vegetariano" deve essere vero o falso.',


                // drink
                'alcohol_volume.required_if' => 'Inserisci il volume alcolico della bevanda.',
                'alcohol_volume.regex' => 'Il volume alcolico non è valido. Usa un formato come "12.5".',
                'primary_size.required_if' => 'Indica la dimensione principale della bevanda.',
                'primary_size.integer' => 'La dimensione principale deve essere un numero intero.',
                'primary_size.between' => 'La dimensione principale deve essere tra 0 e 9999.',
                'secondary_size.integer' => 'La dimensione secondaria deve essere un numero intero.',
                'secondary_size.between' => 'La dimensione secondaria deve essere tra 0 e 9999.',
                'is_alcholic.required_if' => 'Indica se la bevanda è alcolica.',
                'is_alcholic.boolean' => 'Il campo "alcolica" deve essere vero o falso.',
            ]
        );

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

        // dobbiamo controllare se la nostra richiesta ha la chiave allergens
        if ($request->has('allergens')) {
            // aggiungiamo gli allergens nella tabella pivot
            $newProduct->allergens()->attach($data['allergens']);
        } else {
            // se non riceviamo i tags eliminiamoli 
            $newProduct->allergens()->detach();
        }
        //dopo aver salvato tutti i dati del prodotto 
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
        $categories = Category::orderby('name')->get();
        $allergens = Allergen::orderby('name')->get();

        return view('products.edit', compact('product', 'categories', 'allergens'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product, Beverage $beverage, Food $food)
    {

        // dd($request);

        //salvataggio dei dati
        $data = $request->all();

        // dd($data);

        // validazione dei dati
        $validated = $request->validate(
            [
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
                'is_spicy' => 'required_if:type,food|boolean',
                'is_vegetarian' => 'required_if:type,food|boolean',

                // campi specifici per drink
                'alcohol_volume' => 'required_if:type,drink|regex:/^\d{1,3}([,.]\d)?$/',
                'primary_size' => 'required_if:type,drink|integer|between:0,9999',
                'secondary_size' => 'nullable|integer|between:0,9999',
                'is_alcholic' => 'required_if:type,drink|boolean',
            ],
            // messaggi di errore personalizzati
            [

                //nomi
                'name_it.required' => 'Il nome in italiano è obbligatorio.',
                'name_it.max' => 'Il nome in italiano non può superare i 50 caratteri.',
                'name_eng.max' => 'Il nome in inglese non può superare i 50 caratteri.',

                // prezzi
                'primary_price.required' => 'Il prezzo principale è obbligatorio.',
                'primary_price.regex' => 'Il prezzo deve essere un numero minore di 100 (es. 12,50 o 12.50)',
                'secondary_price.regex' => 'Il prezzo deve essere un numero minore di 100 (es. 12,50 o 12.50).',

                // food
                'is_spicy.required_if' => 'Indica se il piatto è piccante.',
                'is_spicy.boolean' => 'Il campo "piccante" deve essere vero o falso.',
                'is_vegetarian.required_if' => 'Indica se il piatto è vegetariano.',
                'is_vegetarian.boolean' => 'Il campo "vegetariano" deve essere vero o falso.',


                // drink
                'alcohol_volume.required_if' => 'Inserisci il volume alcolico della bevanda.',
                'alcohol_volume.regex' => 'Il volume alcolico non è valido. Usa un formato come "12.5".',
                'primary_size.required_if' => 'Indica la dimensione principale della bevanda.',
                'primary_size.integer' => 'La dimensione principale deve essere un numero intero.',
                'primary_size.between' => 'La dimensione principale deve essere tra 0 e 9999.',
                'secondary_size.integer' => 'La dimensione secondaria deve essere un numero intero.',
                'secondary_size.between' => 'La dimensione secondaria deve essere tra 0 e 9999.',
                'is_alcholic.required_if' => 'Indica se la bevanda è alcolica.',
                'is_alcholic.boolean' => 'Il campo "alcolica" deve essere vero o falso.',
            ]
        );

        // codifica dati corretta
        $validated['primary_price'] = str_replace(',', '.', $validated['primary_price']);
        $validated['secondary_price'] = isset($validated['secondary_price']) ? str_replace(',', '.', $validated['secondary_price']) : null;
        $validated['alcohol_volume'] = isset($validated['alcohol_volume']) ? str_replace(',', '.', $validated['alcohol_volume']) : null;

        // dd($validated);

        $product->type = $validated['type'];
        $product->category_id = $validated['category_id'];
        $product->name_it = $validated['name_it'];
        $product->name_eng = $validated['name_eng'];
        $product->description_it = $validated['description_it'];
        $product->description_eng = $validated['description_eng'];
        $product->primary_price = $validated['primary_price'];
        $product->secondary_price = $validated['secondary_price'];

        $product->update();

        // modifichiamo i dati particolari del prodotto
        if ($validated['type'] === 'food') {
            // se c'e stato errore elimina la bevanda con lo stesso id
            Beverage::where('product_id', $product->id)->delete();

            $food = Food::firstOrNew(['product_id' => $product->id]);
            $food->is_spicy = $validated['is_spicy'];
            $food->is_vegetarian = $validated['is_vegetarian'];

            $food->save();
        } elseif ($validated['type'] === 'drink') {
            // se c'e stato errore elimina il cibo con lo stesso id
            Food::where('product_id', $product->id)->delete();

            $beverage = Beverage::firstOrNew(['product_id' => $product->id]);

            $beverage->is_alcholic = $validated['is_alcholic'];
            $beverage->alcohol_volume = $validated['alcohol_volume'];
            $beverage->primary_size = $validated['primary_size'];
            $beverage->secondary_size = $validated['secondary_size'];

            $beverage->save();
        }

        // dobbiamo controllare se la nostra richiesta ha la chiave allergens
        if ($request->has('allergens')) {
            // sincronizziamo gli allergens alla tabella pivot
            $product->allergens()->sync($data['allergens']);
        } else {
            // se non riceviamo i tags eliminiamoli 
            $product->allergens()->detach();
        }

        return redirect()->route('products.show', $product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Cancella la relazione one-to-one se esiste
        if ($product->beverage) {
            $product->beverage->delete();
        }

        // Se vuoi cancellare anche il record food associato, decommenta questo:
        if ($product->food) {
            $product->food->delete();
        }

        // Stacca gli allergeni (relazione many-to-many)
        $product->allergens()->detach();

        // Infine, elimina il prodotto
        $product->delete();

        return redirect()->route('products.index')->with('success', "Prodotto: $product->name_it eliminato con successo.");
    }
}
