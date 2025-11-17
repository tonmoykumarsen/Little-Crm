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
        Schema::create('project_staff', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('staff_id')->constrained('users')->onDelete('cascade');
            $table->timestamps(); // created_at and updated_at
            
            // Optional: Add unique constraint to prevent duplicate assignments
            $table->unique(['project_id', 'staff_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_staff');
    }
};