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
    Schema::table('tours', function (Blueprint $table) {
        $table->decimal('discount', 5, 2)->nullable()->after('price_child');
    });

    Schema::table('activities', function (Blueprint $table) {
        $table->decimal('discount', 5, 2)->nullable()->after('price_child');
    });
}

public function down(): void
{
    Schema::table('tours', function (Blueprint $table) {
        $table->dropColumn('discount');
    });

    Schema::table('activities', function (Blueprint $table) {
        $table->dropColumn('discount');
    });
}

};
