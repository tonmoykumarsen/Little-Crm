<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('serial_number')->unique();
            $table->enum('category', ['laptop', 'mobile', 'tablet', 'monitor', 'accessory', 'furniture', 'other']);
            $table->text('description')->nullable();
            $table->decimal('purchase_price', 10, 2)->nullable();
            $table->date('purchase_date')->nullable();
            $table->enum('status', ['available', 'assigned', 'maintenance', 'retired'])->default('available');
            $table->foreignId('assigned_to')->nullable()->constrained('users');
            $table->date('assigned_date')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};