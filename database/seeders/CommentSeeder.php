<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Comment;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        Comment::create([
            'blog_id' => 1,
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'content' => 'Great article!'
        ]);
    }
}
