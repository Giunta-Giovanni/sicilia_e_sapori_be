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
        Schema::create('allergen_product', function (Blueprint $table) {
            $table->id();

            $table->foreignId('allergen_id')->constrained(); //id ingrediente
            $table->foreignId('product_id')->constrained(); //id prodotto

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('allergen_product');
    }
};
