@extends('layouts.app2')

{{-- 1. Page Title: Optimized for keywords and clarity (Existing logic is good) --}}
@section('title', 'Morocco Activities & Excursions by Category | Morocco Quest')

{{-- 2. Meta Description: Uses specific content from the page (Existing implementation is correct) --}}
@section('meta_description')
    {{-- This meta description correctly uses the H1 and describes the page's purpose: browsing activity categories. It's concise and includes keywords. --}}
    <meta name="description" content="Explore exciting Morocco activities and excursions organized by category. Find cooking classes, desert adventures, city tours, cultural experiences, and more with Morocco Quest.">
@endsection

{{-- 3. Schema.org Structured Data (JSON-LD): Correctly implemented for CollectionPage (Existing logic is good) --}}
@section('structured_data')
    {{-- Prepare data for ItemList - This avoids complex logic directly in the script tag --}}
    @php
        $itemListElements = [];
        // Check if the variable exists and has items
        if(isset($activityCategories) && $activityCategories->count() > 0) {
            // Calculate the starting index based on pagination for accurate positioning across pages
            $startIndex = ($activityCategories->currentPage() - 1) * $activityCategories->perPage();
            foreach ($activityCategories as $index => $category) {
                // $category->slug: Outputs the URL-friendly identifier (e.g., "desert-adventures")
                // $category->name: Outputs the display name (e.g., "Desert Adventures")
                // $category->image_path: Outputs the relative image path from storage
                // asset('storage/'...): Creates the full public URL for the image
                $itemListElements[] = [
                    '@type' => 'ListItem',
                    'position' => $startIndex + $index + 1, // Accurate position accounting for pagination
                    'item' => [
                        // Each item represents the linked category page
                        '@type' => 'WebPage', // Could also be CollectionPage if the category page itself lists items
                        'url' => route('activities.byCategory', ['category_slug' => $category->slug]) ?? '#', // URL to the specific category page
                        'name' => $category->name, // Name of the category
                        // Image for the category, with fallback
                        'image' => asset('storage/' . ($category->image_path ?? 'assets/img/activities/activity-placeholder.png')),
                        // Optional: Add description if available on $category model
                        // 'description' => $category->description ?? ''
                    ]
                ];
            }
        }

        // Helper to safely get the meta description content, avoiding potential errors if the section wasn't pushed correctly
        $metaDescriptionContent = '';
        try {
            // Suppress errors during yield check if section doesn't exist
             $metaDescriptionContent = strip_tags($__env->yieldContent('meta_description'));
        } catch (\Throwable $e) {
             // Fallback or log error if needed
             $metaDescriptionContent = 'Explore exciting Morocco activities and excursions organized by category with Morocco Quest.';
        }
        // Ensure description isn't empty
        if (empty($metaDescriptionContent)) {
             $metaDescriptionContent = 'Explore exciting Morocco activities and excursions organized by category. Find cooking classes, desert adventures, city tours, cultural experiences, and more with Morocco Quest.';
        }


    @endphp

    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      // Type: CollectionPage is appropriate for a page listing links to other pages (categories)
      "@type": "CollectionPage",
      // Name: Derived from the H1/Title
      "name": "Morocco Activities & Excursions by Category",
      // Description: Derived from the meta description content
      "description": "{{ $metaDescriptionContent }}",
      // URL: Canonical URL of this specific category listing page
      "url": "{{ url()->current() }}",
       // Image: Representative image for this listing page (using the hero image)
      "image": "{{ asset('assets/img/moroccan-belly-dance-night-cultural-activity.jpg') }}",
      // Main Entity: The ItemList containing the categories shown on this page
      "mainEntity": {
        "@type": "ItemList",
        "itemListElement": @json($itemListElements, JSON_UNESCAPED_SLASHES) // Output the prepared PHP array as JSON
      },
      // Optional: Link to the publisher (Organization) if defined globally or needed here
      "publisher": {
          "@type": "Organization",
          "name": "Morocco Quest"
          // "url": "{{ url('/') }}", // Optional homepage URL
          // "logo": { "@type": "ImageObject", "url": asset('path/to/your/logo.png') } // Optional logo
      }
    }
    </script>
@endsection

@section('content')
<main> {{-- Semantic <main> tag --}}

{{-- Breadcrumb section --}}
<section
    class="vs-breadcrumb"
    data-bg-src="{{ asset('assets/img/moroccan-belly-dance-night-cultural-activity.jpg') }}" {{-- Ensure background is optimized --}}
>
    {{-- Decorative Images: Have loading="lazy" --}}
    <img
        src="{{ asset('assets/img/icons/cloud.png') }}"
        alt="Decorative cloud icon"
        class="vs-breadcrumb-icon-1 animate-parachute"
        loading="lazy" {{-- Lazy Loading is correctly applied --}}
        {{-- width="X" height="Y" --}} {{-- Recommended: Add dimensions to prevent layout shift --}}
    />
    <img
        src="{{ asset('assets/img/icons/ballon-sclation.png') }}"
        alt="Decorative hot air balloon icon"
        class="vs-breadcrumb-icon-2 animate-parachute"
        loading="lazy" {{-- Lazy Loading is correctly applied --}}
        {{-- width="X" height="Y" --}} {{-- Recommended: Add dimensions to prevent layout shift --}}
    />
    <div class="container">
        <div class="row text-center">
            <div class="col-12">
                <div class="breadcrumb-content">
                    {{-- H1: Main heading for the page --}}
                    <h1 class="breadcrumb-title">Morocco Activities & Excursions</h1>

                    {{-- Caption for context --}}
                    <figcaption class="image-caption" style="color: white; font-size: medium;">
                        A joyful moment as a guest joins a belly dancer during a traditional Moroccan evening show.
                    </figcaption>

                    {{-- Hidden description for accessibility/context --}}
                    <p class="visually-hidden">
                        Discover Moroccan nightlife through cultural performances. Guests are invited to participate in lively belly dance shows,
                        a vibrant celebration of music, rhythm, and local tradition.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

    {{-- Check if categories exist --}}
    @if(isset($activityCategories) && $activityCategories->count() > 0)
        {{-- Main content section listing categories --}}
        <section class="vs-activities space">
             {{-- Decorative Image: Has loading="lazy" --}}
            <img src="{{ asset('assets/img/icons/tree.png') }}"
                 alt="Decorative palm tree icon"
                 class="animate-tree activities-icon-1"
                 loading="lazy" {{-- Lazy Loading is correctly applied --}}
                 {{-- width="X" height="Y" --}} {{-- Recommended: Add dimensions to prevent layout shift --}}
            />
            <div class="container">
                <div class="row gx-3 gy-3">
                    {{-- Loop through available categories --}}
                    @foreach ($activityCategories as $category)
                        {{-- $category->slug, ->name, ->image_path, ->activities_count are used correctly --}}
                        <div class="col-md-6 col-lg-4">
                            <div class="activities-box">
                                <figure class="activities-thumb">
                                    {{-- Link to the specific category page --}}
                                    <a href="{{ route('activities.byCategory', ['category_slug' => $category->slug]) ?? '#' }}"
                                       aria-label="View activities in the {{ e($category->name) }} category"> {{-- Added e() for safety --}}
                                         {{-- Category Image: Has loading="lazy", dynamic alt, onerror fallback --}}
                                        <img src="{{ asset('storage/' . ($category->image_path ?? 'assets/img/activities/activity-placeholder.png')) }}"
                                             alt="Activities in category: {{ e($category->name) }}" {{-- Added e() for safety --}}
                                             class="w-100" {{-- Ensure this class provides responsiveness --}}
                                             loading="lazy" {{-- Lazy Loading is correctly applied --}}
                                             onerror="this.onerror=null;this.src='{{ asset('assets/img/activities/activity-placeholder.png') }}';" {{-- Fallback on error --}}
                                             {{-- width="400" height="300" --}} {{-- CRITICAL: Add actual width/height to prevent layout shift --}}
                                        />
                                    </a>
                                </figure>
                                <div class="activities-content">
                                     {{-- Category Title (H5 is acceptable here) --}}
                                    <h5 class="title">
                                        <a href="{{ route('activities.byCategory', ['category_slug' => $category->slug]) ?? '#' }}"
                                           aria-label="View activities in the {{ e($category->name) }} category"> {{-- Added e() for safety --}}
                                            {{ $category->name }}
                                        </a>
                                    </h5>
                                    {{-- Display activity count with correct pluralization --}}
                                    {{-- $category->activities_count: Outputs the count. Str::plural handles "Activity" vs "Activities". --}}
                                    <span class="info">
                                        {{ $category->activities_count }} {{ Str::plural('Activity', $category->activities_count) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination Links --}}
                <div class="row">
                    <div class="col-12 d-flex justify-content-center mt-40">
                        {{-- Check if pagination is needed before rendering links --}}
                        @if ($activityCategories->hasPages())
                            {{ $activityCategories->links() }} {{-- Renders Laravel's default pagination view --}}
                        @endif
                    </div>
                </div>
            </div>
        </section>
    @else
        {{-- Fallback content if no categories are found --}}
        <section class="vs-activities space">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <p>No activity categories found at the moment. Please check back soon!</p>
                        {{-- Optional: Link back to home or main activities page --}}
                         <a href="{{ route('home') ?? url('/') }}" class="vs-btn mt-3">Back to Home</a>
                    </div>
                </div>
            </div>
        </section>
    @endif
</main>
@endsection