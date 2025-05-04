<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = ['desert', 'city', 'adventure'];

        foreach ($tags as $tag) {
            \App\Models\Tag::create(['name' => $tag]);
        }
    }
}
