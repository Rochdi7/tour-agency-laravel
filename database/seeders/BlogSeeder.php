<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Blog;
use Illuminate\Support\Str;

class BlogSeeder extends Seeder
{
    public function run(): void
    {
        Blog::create([
            'title' => 'First Adventure',
            'slug' => Str::slug('First Adventure'),
            'summary' => 'A thrilling start to our blog series.',
            'content' => '<p>This is the full content of the first blog post.</p>',
            'quote' => 'Adventure awaits!',
            'quote_author' => 'Explorer',
            'category_id' => 1,
            'written_by' => 'Admin',
            'featured_image' => 'storage/images/blogs/default.webp',
        ]);
    }
}
