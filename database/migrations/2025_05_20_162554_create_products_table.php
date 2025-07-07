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
        // crea la tabella prodotti
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->enum('type', ['food', 'drink']);                // Tipo
            $table->foreignId('category_id')->constrained();        // Id categoria associato al prodotto

            $table->string('name_it', 50);                          // Nome it
            $table->string('name_eng', 50)->nullable();             // Nome eng
            $table->text('description_it')->nullable();             // Descrizione it
            $table->text('description_eng')->nullable();            // Descrizione eng
            $table->decimal('primary_price', 4, 2);                 // Prezzo primario
            $table->decimal('secondary_price', 4, 2)->nullable();   // Prezzo secondario


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // elimina la tabella "products" se esiste
        Schema::dropIfExists('products');
    }
};
