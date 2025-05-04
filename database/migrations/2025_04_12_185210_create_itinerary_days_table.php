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
        Schema::create('itinerary_days', function (Blueprint $table) {
            $table->id();

            // Polymorphic relationship: connects to tours, trips, or activities
            $table->unsignedBigInteger('itineraryable_id');
            $table->string('itineraryable_type');

            // Day-specific fields
            $table->unsignedSmallInteger('day_number');
            $table->string('title');
            $table->text('description')->nullable();

            $table->timestamps();

            // Indexes
            $table->index(['itineraryable_id', 'itineraryable_type']);
            $table->index('day_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itinerary_days');
    }
};
