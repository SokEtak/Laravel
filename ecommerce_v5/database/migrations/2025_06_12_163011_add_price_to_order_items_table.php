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
        Schema::table('order_items', function (Blueprint $table) {
            // Add the 'price' column.
            // 'decimal(8, 2)' means it can store numbers with up to 8 total digits,
            // with 2 digits after the decimal point (e.g., 123456.78).
            // 'nullable()' means existing rows won't require a value for this column.
            // 'after('quantity')' is optional, but places the new column
            // immediately after the 'quantity' column in the table structure.
            $table->decimal('price', 8, 2)->nullable()->after('quantity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            // Drop the 'price' column if the migration is rolled back.
            $table->dropColumn('price');
        });
    }
};
