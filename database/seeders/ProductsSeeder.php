<?php

namespace Database\Seeders;

use App\Models\Beverage;
use App\Models\Food;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        // file data di tutti i prodotti iniziali
        $products = config('data.products');

        // entriamo nella cartella prodotti e ci prendiamo i singoli file prodotti
        foreach ($products as $productSections) {
            // per ogni file entramio nella lista e ci ricaviamo il prodotto
            foreach ($productSections as $product) {

                // cerca se il prodotto esiste e se esiste non lo aggiunge ma lo aggiorna
                $newProduct = Product::firstOrNew([
                    'name_it' => $product['name_it'],
                    'category_id' => $product['category_id'],
                ]);

                // aggiorniamo o impostiamo gli altri campi
                $newProduct->type = $product['type'];
                $newProduct->name_eng = $product['name_eng'];
                $newProduct->description_it = $product['description_it'];
                $newProduct->description_eng = $product['description_eng'];
                $newProduct->primary_price = $product['primary_price'] === null ? 0 : $product['primary_price'];;
                $newProduct->secondary_price = $product['secondary_price'];

                $newProduct->save();

                // se il prodotto e di tipo cibo
                if ($product['type'] === "food") {
                    // ricaviamoci il nuovo id 
                    $newfood = new Food();

                    $newfood->product_id = $newProduct->id;
                    $newfood->is_spicy = $product['is_spicy'];
                    $newfood->is_vegetarian = $product['is_vegetarian'];

                    $newfood->save();

                    //altrimenti se è una bevanda
                } elseif ($product['type'] === "drink") {

                    $newBeverage = new Beverage();

                    $newBeverage->product_id = $newProduct->id;
                    $newBeverage->is_alcholic = $product['is_alcholic'];
                    $newBeverage->alcohol_volume = $product['alcohol_volume'];
                    $newBeverage->primary_size = $product['primary_size'];
                    $newBeverage->secondary_size = $product['secondary_size'];

                    $newBeverage->save();
                }
            }
        }
    }
}
