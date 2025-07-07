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
        // crea la tabella cibi
        Schema::create('foods', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')->constrained();     // id prodotto associato

            $table->boolean('is_spicy')->default(false);        // è piccante?
            $table->boolean('is_vegetarian')->default(false);   // è vegetariano?

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // elimina la tabella "foods" se esiste
        Schema::dropIfExists('foods');
    }
};
