<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('courts', function (Blueprint $table) {
            $table->string('location')->nullable()->after('maps_url');
            $table->json('labels')->nullable()->after('location');
            $table->decimal('rating', 3, 2)->default(4.80)->after('price_per_session');
        });
    }

    public function down(): void
    {
        Schema::table('courts', function (Blueprint $table) {
            $table->dropColumn(['location', 'labels', 'rating']);
        });
    }
};



