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
        // Crea la tabella beverages
        Schema::create('beverages', function (Blueprint $table) {
            $table->id();

            $table->foreignId('product_id')->constrained();         // id prodotto associato
            $table->boolean('is_alcholic')->default(false);         // E' alcolico?
            $table->decimal('alcohol_volume', 4, 1)->nullable();    // Percentuale alcolica
            $table->decimal('primary_size', 4, 0);                  // Dimensioni primarie
            $table->decimal('secondary_size', 4, 0)->nullable();    // Dimensioni primarie

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        // Elimina la tabella beverages se esiste
        Schema::dropIfExists('beverages');
    }
};
