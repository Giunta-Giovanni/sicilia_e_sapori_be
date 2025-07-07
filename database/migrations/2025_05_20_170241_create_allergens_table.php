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
        //crea la tabella allergeni
        Schema::create('allergens', function (Blueprint $table) {
            $table->id();

            $table->string('name', 50); // Nome allergene

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Elimina la tabella allergeni se esiste
        Schema::dropIfExists('allergens');
    }
};
