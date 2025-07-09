<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    protected $table = 'foods';

    // Protezione contro mass assignment involontario o malevolo
    protected $fillable = [
        'product_id',
        'is_spicy',
        'is_vegetarian',
    ];

    //connessione one to one con product
    public function products()
    {
        return $this->belongsTo(Product::class);
    }
}
