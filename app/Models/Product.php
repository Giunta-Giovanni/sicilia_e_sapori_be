<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    // Protezione contro mass assignment involontario o malevolo
    protected $fillable = [
        'type',
        'category_id',
        'name_it',
        'name_eng',
        'description_it',
        'description_eng',
        'primary_price',
        'secondary_price',
    ];

    // connessione one to many con category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // connessione one to one con food
    public function food()
    {
        return $this->hasOne(Food::class);
    }

    // connessione one to one con beverage
    public function beverage()
    {
        return $this->hasOne(Beverage::class);
    }


    // connessione many to many con allergen
    public function allergens()
    {
        return $this->belongsToMany(Allergen::class);
    }
}
