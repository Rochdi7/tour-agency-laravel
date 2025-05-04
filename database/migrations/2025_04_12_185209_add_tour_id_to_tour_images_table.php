<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // ❌ Cette migration tente de rajouter une colonne déjà existante
        // Schema::table('tour_images', function (Blueprint $table) {
        //     $table->foreignId('tour_id')->nullable()->constrained()->onDelete('cascade');
        // });
    }

    public function down(): void
    {
        // ❌ Cette partie supprime la colonne si elle existe, à désactiver aussi
        // Schema::table('tour_images', function (Blueprint $table) {
        //     $table->dropForeign(['tour_id']);
        //     $table->dropColumn('tour_id');
        // });
    }
};
