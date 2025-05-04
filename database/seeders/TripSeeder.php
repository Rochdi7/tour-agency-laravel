<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Trip;

class TripSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $trips = [
            [
                'title' => 'Moroccan Imperial Cities Tour',
                'slug' => 'moroccan-imperial-cities-tour',
                'overview' => 'Visit the historic cities of Marrakech, Fez, Meknes, and Rabat.',
                'itinerary' => 'Day 1: Arrival in Marrakech\nDay 2: Explore Marrakech Medina\n...',
                'includes' => 'Guide, transportation, entrance fees',
                'excludes' => 'Flights to Morocco, personal expenses',
                'faq' => 'What are the must-see attractions in each city?\n...',
                'transportation' => 'Private vehicle',
                'accommodation' => 'Riads in each city',
                'departure' => 'Marrakech',
                'altitude' => 'Varies',
                'best_season' => 'Year-round',
                'tour_type' => 'Cultural',
                'group_size' => '5-20',
                'min_age' => 5,
                'max_age' => null,
                'price_adult' => 800.00,
                'price_child' => 600.00,
                'duration_days' => 8,
            ],
            [
                'title' => 'Essaouira Coastal Getaway',
                'slug' => 'essaouira-coastal-getaway',
                'overview' => 'Relax in the charming coastal town of Essaouira.',
                'itinerary' => 'Day 1: Arrival in Essaouira\nDay 2: Explore the medina and beaches\n...',
                'includes' => 'Accommodation, local guide',
                'excludes' => 'Travel to Essaouira, personal expenses',
                'faq' => 'What activities are available in Essaouira?\n...',
                'transportation' => 'Local transport',
                'accommodation' => 'Riads in Essaouira',
                'departure' => 'Marrakech',
                'altitude' => 'Sea level',
                'best_season' => 'Year-round',
                'tour_type' => 'Relaxation',
                'group_size' => '1-10',
                'min_age' => 5,
                'max_age' => null,
                'price_adult' => 300.00,
                'price_child' => 200.00,
                'duration_days' => 3,
            ],
        ];

        foreach ($trips as $trip) {
            Trip::create($trip);
        }
    }
}
