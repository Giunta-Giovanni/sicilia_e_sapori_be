<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Crea la tabella pivot allergeni prodotti 
        Schema::create('allergen_product', function (Blueprint $table) {
            $table->id();

            $table->foreignId('allergen_id')->constrained();    // Id ingrediente
            $table->foreignId('product_id')->constrained();     // Id prodotto

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Elimina la tabella pivot allergeni prodotti se esiste
        Schema::dropIfExists('allergen_product');
    }
};
