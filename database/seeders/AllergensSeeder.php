<?php

namespace Database\Seeders;

use App\Models\Allergen;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use PhpParser\Node\Stmt\Foreach_;

class AllergensSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $allergens = [
            "gluten",
            "crustaceans",
            "egg",
            "fish",
            "peanuts",
            "soy",
            "milk",
            "nut",
            "celery",
            "mustard",
            "sesame",
            "sulphites",
            "lupins",
            "molluscs"
        ];

        foreach ($allergens as $allergen) {
            $newAllergen = new Allergen();

            $newAllergen->name = $allergen;

            $newAllergen->save();
        }
    }
}
