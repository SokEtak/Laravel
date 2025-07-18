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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('payment_method_id')->constrained('payment_methods')->onDelete('restrict'); // Foreign key to payment_methods table (restrict deletion of method if used)
            $table->decimal('amount', 10, 2)->unsigned();
            $table->timestamp('payment_date')->useCurrent();
            $table->enum('status', ['Pending', 'Paid', 'Partially Paid', 'Refunded']);
            $table->string('currency', 10)->default('USD');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
