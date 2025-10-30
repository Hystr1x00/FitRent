<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Alter ENUM to add 'open' value
        DB::statement("ALTER TABLE slots MODIFY COLUMN status ENUM('pending', 'confirmed', 'completed', 'cancelled', 'open') DEFAULT 'pending'");
    }

    public function down(): void
    {
        // Revert back to original ENUM values
        DB::statement("ALTER TABLE slots MODIFY COLUMN status ENUM('pending', 'confirmed', 'completed', 'cancelled') DEFAULT 'pending'");
    }
};
