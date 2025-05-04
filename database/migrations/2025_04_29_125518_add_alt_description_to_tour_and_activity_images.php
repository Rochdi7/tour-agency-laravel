<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('tour_images', function (Blueprint $table) {
            $table->string('alt')->nullable()->after('caption');
            $table->text('description')->nullable()->after('alt');
        });

        Schema::table('activity_images', function (Blueprint $table) {
            $table->string('alt')->nullable()->after('caption');
            $table->text('description')->nullable()->after('alt');
        });
    }

    public function down()
    {
        Schema::table('tour_images', function (Blueprint $table) {
            $table->dropColumn(['alt', 'description']);
        });

        Schema::table('activity_images', function (Blueprint $table) {
            $table->dropColumn(['alt', 'description']);
        });
    }

};
