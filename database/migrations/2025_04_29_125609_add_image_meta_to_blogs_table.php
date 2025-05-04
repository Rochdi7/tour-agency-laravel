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
    Schema::table('blogs', function (Blueprint $table) {
        $table->string('featured_image_alt')->nullable()->after('featured_image');
        $table->string('featured_image_caption')->nullable()->after('featured_image_alt');
        $table->text('featured_image_description')->nullable()->after('featured_image_caption');
    });
}

public function down()
{
    Schema::table('blogs', function (Blueprint $table) {
        $table->dropColumn(['featured_image_alt', 'featured_image_caption', 'featured_image_description']);
    });
}

};
