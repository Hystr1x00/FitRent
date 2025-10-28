<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('slot_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('slot_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('booking_id')->constrained()->onDelete('cascade');
            $table->decimal('amount_paid', 10, 2);
            $table->enum('payment_status', ['pending', 'paid'])->default('pending');
            $table->timestamps();
            
            $table->unique(['slot_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('slot_participants');
    }
};