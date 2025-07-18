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
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('name',100);
            $table->string('description',255)->nullable();
            $table->string('short_description',100)->nullable();
            $table->decimal('price', 10, 2)->unsigned();
            $table->integer('stock_quantity')->default(0);
            $table->decimal('discount_amount',10,2)->unsigned()->default(0);
            $table->string('sku',50)->unique();
            $table->enum('status',["drafted","published"])->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
