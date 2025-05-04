<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCategoryIdToActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('activities', function (Blueprint $table) {
            // Add the foreign key column after 'slug' or another appropriate column
            $table->foreignId('activity_category_id')
                  ->nullable() // Allow activities without a category initially
                  ->after('slug') // Adjust position as needed
                  ->constrained('activity_categories') // Links to id on activity_categories table
                  ->onDelete('set null'); // Or 'cascade' if deleting category deletes activities
                  // Or 'restrict' to prevent category deletion if activities exist
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
            // Drop foreign key constraint first (name follows convention: table_column_foreign)
            $table->dropForeign(['activity_category_id']);
            // Then drop the column
            $table->dropColumn('activity_category_id');
        });
    }
}