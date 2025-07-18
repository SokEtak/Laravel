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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->decimal('total_amount', 10, 2)->unsigned();
            $table->enum('status',["Pending","Processing","Shipped","Delivered","Canceled"])->default('Pending');
            $table->text('shipping_address')->nullable();
            $table->decimal('shipping_cost', 10, 2)->unsigned()->default(0.00);
            $table->decimal('discount_amount', 10, 2)->unsigned()->default(0.00);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
