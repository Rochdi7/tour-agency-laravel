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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('overview');
            $table->text('itinerary')->nullable();
            $table->text('includes')->nullable();
            $table->text('excludes')->nullable();
            $table->text('faq')->nullable();
        
            $table->string('transportation')->nullable();
            $table->string('accommodation')->nullable();
            $table->string('departure')->nullable();
            $table->string('altitude')->nullable();
            $table->string('best_season')->nullable();
            $table->string('tour_type')->nullable();
            $table->string('group_size')->nullable();
            $table->integer('min_age')->nullable();
            $table->integer('max_age')->nullable();
        
            $table->decimal('price_adult', 8, 2)->nullable();
            $table->decimal('price_child', 8, 2)->nullable();
            $table->integer('duration_days')->default(1);
        
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
