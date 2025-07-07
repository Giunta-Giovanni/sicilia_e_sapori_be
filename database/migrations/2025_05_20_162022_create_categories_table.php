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
        // crea la tabella categories
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['food', 'drink']);    // Tipo
            $table->string('name', 50);                 // Nome
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // elimina la tabella "categories" se esiste
        Schema::dropIfExists('categories');
    }
};
