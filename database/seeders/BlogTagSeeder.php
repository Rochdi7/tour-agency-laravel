<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Blog;

class BlogTagSeeder extends Seeder
{
    public function run(): void
    {
        $blog = Blog::first();
        if ($blog) {
            $blog->tags()->sync([1, 2]);
        }
    }
}
