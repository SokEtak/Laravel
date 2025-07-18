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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('restrict'); // Foreign key to products table (restrict deletion of product if it's in an order)
            $table->integer('quantity')->unsigned();
            $table->decimal('unit_price', 10, 2)->unsigned(); // Price at time of order
            $table->decimal('line_total', 10, 2)->unsigned(); // quantity * unit_price
            $table->string('sku', 50)->nullable(); // Denormalized for historical accuracy
            $table->decimal('discount_amount', 10, 2)->unsigned()->default(0.00);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
