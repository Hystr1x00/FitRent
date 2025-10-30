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
        Schema::table('slots', function (Blueprint $table) {
            $table->unsignedBigInteger('court_id')->nullable()->after('creator_id');
            $table->string('court_name')->nullable()->after('court_id');
            
            // Add foreign key constraint (optional)
            $table->foreign('court_id')->references('id')->on('courts')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('slots', function (Blueprint $table) {
            $table->dropForeign(['court_id']);
            $table->dropColumn(['court_id', 'court_name']);
        });
    }
};
