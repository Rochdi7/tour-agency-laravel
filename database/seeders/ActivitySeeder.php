<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Activity;

class ActivitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $activities = [
            [
                'title' => 'Surfing in Taghazout',
                'slug' => 'surfing-in-taghazout',
                'overview' => 'Catch waves in the laid-back surf town of Taghazout.',
                'itinerary' => 'Day 1: Arrival in Taghazout\nDay 2: Surf lessons\n...',
                'includes' => 'Surfboard rental, instructor',
                'excludes' => 'Travel to Taghazout, personal expenses',
                'faq' => 'Do I need prior surfing experience?\n...',
                'transportation' => 'Local transport',
                'accommodation' => 'Surf camps in Taghazout',
                'departure' => 'Agadir',
                'altitude' => 'Sea level',
                'best_season' => 'Winter',
                'tour_type' => 'Adventure',
                'group_size' => '1-10',
                'min_age' => 10,
                'max_age' => null,
                'price_adult' => 80.00,
                'price_child' => 50.00,
                'duration_days' => 1,
            ],
            [
                'title' => 'Hiking in the Atlas Mountains',
                'slug' => 'hiking-in-the-atlas-mountains',
                'overview' => 'Explore the scenic trails of the Atlas Mountains.',
                'itinerary' => 'Day 1: Drive to Imlil\nDay 2: Hike to Toubkal Base Camp\n...',
                'includes' => 'Guide, meals during hike',
                'excludes' => 'Travel to Imlil, personal expenses',
                'faq' => 'What is the difficulty level of the hike?\n...',
                'transportation' => 'Private vehicle to Imlil',
                'accommodation' => 'Mountain lodges',
                'departure' => 'Marrakech',
                'altitude' => '4,167 meters',
                'best_season' => 'Spring and Autumn',
                'tour_type' => 'Adventure',
                'group_size' => '5-15',
                'min_age' => 18,
                'max_age' => 60,
                'price_adult' => 150.00,
                'price_child' => null,
                'duration_days' => 2,
            ],
        ];

        foreach ($activities as $activity) {
            Activity::create($activity);
        }
    }
}
