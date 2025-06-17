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
            // Change the inventory_id column to be nullable
            // Ensure 'constrained('inventories')->onDelete('set null')' is included
            // if you want to maintain the foreign key relationship behavior.
            // If it was already a foreignId, simply adding change() is often enough.
            $table->foreignId('inventory_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Revert the column back to not nullable if needed for rollback.
            // Be cautious: if you have null values after migration, this rollback might fail.
            $table->foreignId('inventory_id')->nullable(false)->change();
        });
    }
};
