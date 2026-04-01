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
        Schema::table('images', function (Blueprint $table) {
            // Salva le icone di sicurezza rilevate da Google Vision
            $table->json('safe_search')->nullable()->after('path');
            // Salva le etichette rilevate da Google Vision
            $table->json('labels')->nullable()->after('safe_search');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('images', function (Blueprint $table) {
            Schema::table('images', function (Blueprint $table) {
                $table->dropColumn(['safe_search', 'labels']);
            });
        });
    }
};
