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
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('type'); // rimuove 'food/drink'
            $table->enum('availability', ['takeaway', 'dinein', 'both'])->default('both');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->enum('availability', ['takeaway', 'dinein', 'both'])->default('both');
            $table->enum('type', ['food', 'drink'])->default('food'); // se vuoi ripristinarlo nel rollback
        });
    }
};
