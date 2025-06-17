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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name',50);
            $table->string('product_description',255)->nullable()->default("No Description Provided");
            $table->string('SKU',20)->nullable()->unique();
            $table->foreignId('inventory_id')->constrained('inventories');
            $table->foreignId('discount_id',)->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->nullable()->constrained("categories")->onDelete('set null');
            $table->decimal('price',8,2)->nullable()->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
