<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('return_photo')->nullable();
            $table->text('return_note')->nullable();
            $table->timestamp('returned_at')->nullable();
            $table->integer('overtime_minutes')->nullable();
            $table->decimal('fine_amount', 10, 2)->nullable();
            $table->string('return_status')->nullable(); // pending, approved, rejected
        });
    }

    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn(['return_photo','return_note','returned_at','overtime_minutes','fine_amount','return_status']);
        });
    }
};


