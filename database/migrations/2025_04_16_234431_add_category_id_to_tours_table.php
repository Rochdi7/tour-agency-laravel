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
    Schema::table('tours', function (Blueprint $table) {
        $table->unsignedBigInteger('category_id')->nullable()->after('slug');

        // Optional: If you have a categories table
        // $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
    });
}

public function down()
{
    Schema::table('tours', function (Blueprint $table) {
        $table->dropColumn('category_id');
    });
}

};
