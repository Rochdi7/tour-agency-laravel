<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Check if column exists before trying to drop
        if (Schema::hasColumn('tours', 'itinerary')) {
            Schema::table('tours', function (Blueprint $table) {
                $table->dropColumn('itinerary');
            });
        }
        if (Schema::hasColumn('activities', 'itinerary')) {
            Schema::table('activities', function (Blueprint $table) {
                $table->dropColumn('itinerary');
            });
        }
        if (Schema::hasColumn('trips', 'itinerary')) {
            Schema::table('trips', function (Blueprint $table) {
                $table->dropColumn('itinerary');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Add the column back if rolling back (optional but good practice)
         if (!Schema::hasColumn('tours', 'itinerary')) {
            Schema::table('tours', function (Blueprint $table) {
                $table->text('itinerary')->nullable()->after('overview'); // Adjust position if needed
            });
         }
         if (!Schema::hasColumn('activities', 'itinerary')) {
            Schema::table('activities', function (Blueprint $table) {
                $table->text('itinerary')->nullable()->after('overview');
            });
        }
         if (!Schema::hasColumn('trips', 'itinerary')) {
             Schema::table('trips', function (Blueprint $table) {
                $table->text('itinerary')->nullable()->after('overview');
            });
         }
    }
};
