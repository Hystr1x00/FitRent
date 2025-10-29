<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('courts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venue_id')->constrained()->cascadeOnDelete();
            $table->string('sport');
            $table->string('court_code')->unique();
            $table->string('name');
            $table->string('image')->nullable();
            $table->text('about')->nullable();
            $table->text('rules')->nullable();
            $table->json('facilities')->nullable();
            $table->text('refund_policy')->nullable();
            $table->string('maps_url')->nullable();
            $table->unsignedInteger('booking_duration_minutes')->default(60);
            $table->time('open_time')->nullable();
            $table->time('close_time')->nullable();
            $table->decimal('price_per_session', 12, 2)->default(0);
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courts');
    }
};



