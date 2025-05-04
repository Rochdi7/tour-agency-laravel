<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tour;

class TourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tours = [
            [
                'title' => 'Marrakech Desert Tour',
                'slug' => 'marrakech-desert-tour',
                'overview' => 'Explore the vibrant city of Marrakech and venture into the Sahara Desert.',
                'itinerary' => 'Day 1: Explore Marrakech Medina\nDay 2: Travel to Merzouga Desert\n...',
                'includes' => 'Guide, transportation, camel ride',
                'excludes' => 'Flights to Marrakech, personal expenses',
                'faq' => 'What is the best time to visit the desert?\n...',
                'transportation' => 'Private vehicle',
                'accommodation' => 'Riads in Marrakech, desert camp',
                'departure' => 'Marrakech',
                'altitude' => '1,400 meters',
                'best_season' => 'Spring and Autumn',
                'tour_type' => 'Adventure',
                'group_size' => '5-15',
                'min_age' => 10,
                'max_age' => null,
                'price_adult' => 500.00,
                'price_child' => 300.00,
                'duration_days' => 4,
            ],
            [
                'title' => 'Fez Cultural Tour',
                'slug' => 'fez-cultural-tour',
                'overview' => 'Discover the ancient city of Fez, known for its rich history and architecture.',
                'itinerary' => 'Day 1: Explore Fez Medina\nDay 2: Visit Al-Attarine Madrasa\n...',
                'includes' => 'Guide, entrance fees',
                'excludes' => 'Travel to Fez, personal expenses',
                'faq' => 'What are the must-see attractions in Fez?\n...',
                'transportation' => 'Local transport',
                'accommodation' => 'Riads in Fez',
                'departure' => 'Fez',
                'altitude' => '400 meters',
                'best_season' => 'Year-round',
                'tour_type' => 'Cultural',
                'group_size' => '5-20',
                'min_age' => 5,
                'max_age' => null,
                'price_adult' => 200.00,
                'price_child' => 150.00,
                'duration_days' => 3,
            ],
        ];

        foreach ($tours as $tour) {
            Tour::create($tour);
        }
    }
}
