<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Carbon\Carbon;

class SitemapController extends Controller
{
    public function index()
    {
        $urls = [
            [
                'loc' => route('home'),
                'lastmod' => Carbon::now()->toAtomString(),
                'changefreq' => 'daily',
                'priority' => '1.0',
            ],
            [
                'loc' => route('about'),
                'lastmod' => Carbon::now()->toAtomString(),
                'changefreq' => 'monthly',
                'priority' => '0.8',
            ],
            [
                'loc' => route('faq'),
                'lastmod' => Carbon::now()->toAtomString(),
                'changefreq' => 'monthly',
                'priority' => '0.8',
            ],
            [
                'loc' => route('tours.index'),
                'lastmod' => Carbon::now()->toAtomString(),
                'changefreq' => 'daily',
                'priority' => '0.9',
            ],
            [
                'loc' => route('activities.index'),
                'lastmod' => Carbon::now()->toAtomString(),
                'changefreq' => 'daily',
                'priority' => '0.9',
            ],
            [
                'loc' => route('trips.index'),
                'lastmod' => Carbon::now()->toAtomString(),
                'changefreq' => 'daily',
                'priority' => '0.9',
            ],
            [
                'loc' => route('blog.index'),
                'lastmod' => Carbon::now()->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.7',
            ],
            [
                'loc' => route('contact.show'),
                'lastmod' => Carbon::now()->toAtomString(),
                'changefreq' => 'yearly',
                'priority' => '0.5',
            ],
        ];

        // Add dynamic routes for blogs, tours, and activities
        $tours = \App\Models\Tour::all();
        foreach ($tours as $tour) {
            $urls[] = [
                'loc' => route('tours.show', $tour->slug),
                'lastmod' => $tour->updated_at->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.7',
            ];
        }

        $activities = \App\Models\Activity::all();
        foreach ($activities as $activity) {
            $urls[] = [
                'loc' => route('activities.show', $activity->slug),
                'lastmod' => $activity->updated_at->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.7',
            ];
        }

        $posts = \App\Models\Post::all();
        foreach ($posts as $post) {
            $urls[] = [
                'loc' => route('blog.show', $post->slug),
                'lastmod' => $post->updated_at->toAtomString(),
                'changefreq' => 'weekly',
                'priority' => '0.7',
            ];
        }

        try {
            return response()->view('sitemap.index', compact('urls'))->header('Content-Type', 'application/xml');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
