<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Allergen extends Model
{
    // Protezione contro mass assignment involontario o malevolo
    protected $fillable = [
        'name',
    ];

    // connessione many to many con products
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
