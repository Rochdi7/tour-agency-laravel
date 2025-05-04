<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDiscountPercentageToActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activities', function (Blueprint $table) {
            // Add column after price_child (or wherever you prefer)
            // unsignedTinyInteger is suitable for 0-100 range
            $table->unsignedTinyInteger('discount_percentage')
                  ->nullable() // Allow activities without a discount
                  ->default(null) // Default is no discount
                  ->after('price_child'); // Adjust position as needed
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn('discount_percentage');
        });
    }
}