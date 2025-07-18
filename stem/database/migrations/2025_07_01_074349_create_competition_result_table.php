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
        Schema::create('competition_result', function (Blueprint $table) {
            $table->id();
            $table->foreignId('competition_id')->constrained("competitions")->onDelete('cascade');
            $table->foreignId('team_id')->constrained("teams")->onDelete('cascade');
            $table->integer("score");
            $table->integer("position");
            $table->timestamp('created_at')->nullable(); // 👈 only created_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('competition_result');
    }
};
