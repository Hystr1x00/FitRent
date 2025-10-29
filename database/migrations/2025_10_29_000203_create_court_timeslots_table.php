<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('court_timeslots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('court_id')->constrained('courts')->cascadeOnDelete();
            $table->time('start_time');
            $table->time('end_time');
            $table->decimal('price', 12, 2);
            $table->string('status')->default('available'); // available|booked|inactive
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('court_timeslots');
    }
};



