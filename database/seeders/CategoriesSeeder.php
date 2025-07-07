<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // file data di tutte le categorie iniziali
        $categories = config('data.categories');
        foreach ($categories as $category) {

            // creiamo l'istanza categoria
            $newCategory = new Category();

            // aggiungiamo il tipo
            $newCategory->type = $category['type'];
            // aggiungiamo il nome
            $newCategory->name = $category['name'];

            // salviamo l'istanza  
            $newCategory->save();
        }
    }
}
