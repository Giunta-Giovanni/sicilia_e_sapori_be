<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Beverage extends Model
{
    protected $table = 'beverages';

    // Protezione contro mass assignment involontario o malevolo
    protected $fillable = [
        'product_id',
        'is_alcholic',
        'alcohol_volume',
        'primary_size',
        'secondary_size',
    ];

    //connessione one to one con product
    public function products()
    {
        return $this->belongsTo(Product::class);
    }
}
