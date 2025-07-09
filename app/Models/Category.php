<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Protezione contro mass assignment involontario o malevolo
    protected $fillable = [
        'name',
        'type',
    ];

    //connessione on to many con product
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
