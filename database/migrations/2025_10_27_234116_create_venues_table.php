<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('venues', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('sport');
            $table->string('location');
            $table->text('address');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('rating', 3, 2)->default(4.5);
            $table->string('image')->nullable();
            $table->boolean('available')->default(true);
            $table->json('facilities')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('venues');
    }
};