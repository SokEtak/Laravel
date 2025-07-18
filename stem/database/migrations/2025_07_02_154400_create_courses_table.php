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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id')->constrained('schedules')->cascadeOnDelete();
            $table->foreignId('tenant_id')->constrained("tenants")->onDelete('cascade');
            $table->foreignId('teacher_id')->constrained("teachers")->onDelete('cascade');
            $table->foreignId('subject_id')->constrained("subjects")->onDelete('cascade');
            $table->string('name');
            $table->string('description');
            $table->enum('level',['123','go','iq','exp'])->nullable();
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
