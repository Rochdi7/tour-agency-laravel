@extends('layouts.app2')

{{-- Page Title: Dynamic based on search query if available --}}
@section('title', isset($searchQuery) && $searchQuery ? 'Search Results for "' . e($searchQuery) . '" | Morocco Quest' : 'Search Results | Morocco Quest')

{{-- ================================================== --}}
{{-- SEO Meta Description & Structured Data             --}}
{{-- ================================================== --}}
@section('seo_tags')
    {{-- 1. Meta Description --}}
    <meta name="description" content="@if(isset($searchQuery) && $searchQuery)Find {{ $tours->count() + $activities->count() }} Morocco tours & activities matching '{{ e($searchQuery) }}'. Explore options, prices, and durations with Morocco Quest.@else{{-- Fallback if no query --}}Search results for Morocco tours & activities. Explore {{ $tours->count() + $activities->count() }} options, prices, and durations with Morocco Quest.@endif">
    {{-- Explanation of Dynamic Variables in Meta Description:
        - {{ $searchQuery }}: Outputs the user's search term entered (e.g., "Marrakech desert"). Escaped using e() for security.
        - {{ $tours->count() + $activities->count() }}: Outputs the total number of tours and activities found on the current page matching the search.
    --}}

    {{-- 2. Schema.org Structured Data (JSON-LD) for Search Results --}}
    @if($tours->count() || $activities->count())
    <script type="application/ld+json">
    @php
        $itemListElement = [];
        $position = 1; // Initialize position counter

        // Process Tours
        foreach ($tours as $tour) {
            $tourImageUrl = asset('storage/' . optional($tour->images->first())->image_path); // Use optional for safety
            $tourOfferData = null;
            if (isset($tour->price_adult)) {
                $tourOfferData = [
                    "@type" => "Offer",
                    "price" => number_format($tour->price_adult, 2, '.', ''), // Numeric format
                    "priceCurrency" => "USD", // Assuming USD
                    "availability" => "https://schema.org/InStock"
                ];
                 // Add discount info if old price exists and is higher
                 if ($tour->old_price_adult && $tour->old_price_adult > $tour->price_adult) {
                    $tourOfferData['priceSpecification'] = [
                        "@type" => "PriceSpecification",
                        "price" => number_format($tour->price_adult, 2, '.', ''),
                        "priceCurrency" => "USD",
                        // You could calculate discount percentage here if needed
                        // "discount": round((($tour->old_price_adult - $tour->price_adult) / $tour->old_price_adult) * 100),
                        "validFrom" => now()->toIso8601String() // Optional validity
                    ];
                 }
            }
            $tourDurationIso = $tour->duration_days ? 'P' . $tour->duration_days . 'D' : null;

            $itemListElement[] = [
                "@type" => "ListItem",
                "position" => $position++,
                "item" => [
                    "@type" => "TouristTrip",
                    "name" => $tour->title,
                    "description" => Str::limit(strip_tags($tour->short_description ?? $tour->title), 150), // Use short desc or title
                    "url" => route('tours.show', $tour->slug),
                    "image" => $tourImageUrl,
                    "duration" => $tourDurationIso,
                    "offers" => $tourOfferData,
                    "itinerary" => [ // Example of adding itinerary structure if place data is relevant
                        "@type" => "ItemList",
                        "itemListElement" => $tour->places->isNotEmpty() ? $tour->places->map(function($place, $index) {
                            return [
                                "@type" => "ListItem",
                                "position" => $index + 1,
                                "item" => [
                                    "@type" => "Place",
                                    "name" => $place->name
                                ]
                            ];
                        })->toArray() : null
                    ]
                ]
            ];
        }

        // Process Activities
        foreach ($activities as $activity) {
            $activityImageUrl = asset('storage/' . optional($activity->images->first())->image); // Use 'image' field as per original code
            $activityOfferData = null;
            if (isset($activity->price_adult)) {
                 $activityOfferData = [
                    "@type" => "Offer",
                    "price" => number_format($activity->price_adult, 2, '.', ''), // Numeric format
                    "priceCurrency" => "USD", // Assuming USD
                    "availability" => "https://schema.org/InStock"
                 ];
                  // Add discount info if old price exists and is higher
                 if ($activity->old_price_adult && $activity->old_price_adult > $activity->price_adult) {
                    $activityOfferData['priceSpecification'] = [
                        "@type" => "PriceSpecification",
                        "price" => number_format($activity->price_adult, 2, '.', ''),
                        "priceCurrency" => "USD",
                        "validFrom" => now()->toIso8601String() // Optional validity
                    ];
                 }
            }
             // Use Place schema for location if available
             $activityLocationData = null;
             if ($activity->places->isNotEmpty()) {
                 $activityLocationData = $activity->places->map(function($place) {
                     return ["@type" => "Place", "name" => $place->name];
                 })->toArray();
             } elseif ($activity->category) {
                 $activityLocationData = [["@type" => "Place", "name" => $activity->category->name]]; // Use category as fallback location name
             }

            $itemListElement[] = [
                "@type" => "ListItem",
                "position" => $position++,
                "item" => [
                    // Using Product as activities might fit this better than Event unless they have specific start/end dates
                    "@type" => "Product",
                    "name" => $activity->title,
                    "description" => Str::limit(strip_tags($activity->description ?? $activity->title), 150), // Use desc or title
                    "url" => route('activities.show', $activity->slug),
                    "image" => $activityImageUrl,
                    "offers" => $activityOfferData,
                    // Add relevant properties for Product like brand, sku if applicable
                    // For location, you might use 'location' property with Place schema
                    "location" => $activityLocationData,
                    // If duration represents time length, ISO 8601 format might be used (e.g., PT2H for 2 hours)
                    // "duration" => $activity->duration ? 'PT' . $activity->duration . 'H' : null // Example if duration is in hours
                ]
            ];
        }

        // Determine total results count if using pagination
        $totalItemCount = 0;
        if ($tours instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            $totalItemCount += $tours->total();
        } else {
            $totalItemCount += $tours->count();
        }
        if ($activities instanceof \Illuminate\Pagination\LengthAwarePaginator) {
            $totalItemCount += $activities->total();
        } else {
            $totalItemCount += $activities->count();
        }

        $schemaData = [
            "@context" => "https://schema.org",
            "@type" => "SearchResultsPage",
            // You might want to refine the name/description based on the actual search query
            "name" => isset($searchQuery) && $searchQuery ? 'Search Results for "' . e($searchQuery) . '"' : 'Search Results',
            "description" => isset($searchQuery) && $searchQuery ? 'Find Morocco tours and activities matching your search for "' . e($searchQuery) . '".' : 'Search results for Morocco tours and activities.',
            "mainEntity" => [
                "@type" => "ItemList",
                "numberOfItems" => $totalItemCount, // Total results across all pages
                "itemListElement" => $itemListElement // Items on the current page
            ]
        ];
    @endphp
    {!! json_encode($schemaData, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
    @endif
    {{-- Recommend adding noindex for search result pages in base layout or here --}}
    {{-- <meta name="robots" content="noindex, follow"> --}}
@endsection

@section('content')

<!--================= Breadcrumb Area start =================-->
<section class="vs-breadcrumb" data-bg-src="{{ asset('assets/img/hot-air-balloon-ride-morocco-desert-adventure.webp') }}">
    <img src="{{ asset('assets/img/icons/fanous.png') }}" alt="Decorative cloud icon"
       style="height: 200px;" class="vs-breadcrumb-icon-1 animate-parachute" loading="lazy" />

    <img src="{{ asset('assets/img/icons/ballon-sclation.png') }}" alt="Decorative hot air balloon icon"
        class="vs-breadcrumb-icon-2 animate-parachute" loading="lazy" />

    <div class="container">
        <div class="row text-center">
            <div class="col-12">
                <div class="breadcrumb-content">
                    <h1 class="breadcrumb-title" >Find Your Perfect Adventure</h1>
                    <p class="breadcrumb-subtitle" style="color: white;">
                    Search for the best tours, activities, and experiences across Morocco.
                    </p>

                    <figcaption class="image-caption visually-hidden">
                    Discover the best tours, activities, and adventures across Morocco, from desert safaris to city explorations.
                    </figcaption>

                    <p class="visually-hidden">
                    Explore the finest tours, activities, and adventure experiences across Morocco. From breathtaking desert safaris to vibrant city tours and luxurious getaways, find your perfect Moroccan adventure.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>


<!--================= Breadcrumb Area end =================-->
<div class="container py-5">
    <h1 class="mb-4">
        Search Results
        @if(isset($searchQuery) && $searchQuery)
            for "{{ e($searchQuery) }}"
        @endif
    </h1>

    @if($tours->count() || $activities->count())

        @if($tours->count())
            <h2 class="text-primary mb-4">Tours Found</h2>
            <div class="row g-4">
                @foreach($tours as $tour)
                    <div class="col-md-4">
                        <div class="tour-package-box bg-white-color h-100 d-flex flex-column"> {{-- Added flex classes for consistent height --}}
                            <div class="tour-package-thumb">
                                {{-- 3. Lazy Loading Added --}}
                                <img
                                    src="{{ asset('storage/' . optional($tour->images->first())->image_path) }}"
                                    alt="{{ $tour->title }}"
                                    class="w-100"
                                    loading="lazy" {{-- Lazy Loading Added --}}
                                    {{-- Consider adding width/height attributes if known for better CLS --}}
                                    {{-- width="350" height="250" --}}
                                />
                            </div>
                            <div class="tour-package-content flex-grow-1 d-flex flex-column"> {{-- Added flex classes --}}
                                <h5 class="title line-clamp-2">
                                    <a href="{{ route('tours.show', $tour->slug) ?? '#' }}" aria-label="View details for tour: {{ $tour->title }}">
                                        {{ Str::limit($tour->title, 50) }}
                                    </a>
                                </h5>
                                <div class="pricing-container mt-auto"> {{-- Pushed to bottom --}}
                                    <div class="package-info">
                                        <span class="package-location">
                                            <i class="fa-sharp fa-thin fa-location-dot"></i>
                                            {{ $tour->places->isNotEmpty() ? $tour->places->pluck('name')->implode(', ') : ($tour->location ?? 'Multiple Locations') }}
                                        </span>
                                        <span class="package-time">
                                            <i class="fa-sharp fa-thin fa-clock"></i>
                                            {{ $tour->duration_days ? $tour->duration_days . ' ' . Str::plural('Day', $tour->duration_days) : 'N/A' }}
                                        </span>
                                    </div>
                                    <div class="price-info">
                                         {{-- Discount logic improved: Use old_price_adult --}}
                                         @if($tour->old_price_adult && $tour->price_adult && $tour->old_price_adult > $tour->price_adult)
                                            <span class="price-off text-white-color ff-poppins">
                                                {{ round((($tour->old_price_adult - $tour->price_adult) / $tour->old_price_adult) * 100) }}% off
                                            </span>
                                        @elseif($tour->discount && $tour->discount > 0) {{-- Fallback to discount field --}}
                                            <span class="price-off text-white-color ff-poppins">
                                                {{ rtrim(rtrim(number_format($tour->discount, 0), '0'), '.') }}% off
                                            </span>
                                        @endif
                                        <div class="price">
                                            <h6 class="fs-30 ff-rubik">${{ number_format($tour->price_adult ?? 0, 2) }}</h6>
                                            @if($tour->old_price_adult && $tour->old_price_adult > ($tour->price_adult ?? 0))
                                                <del class="fs-sm ff-rubik">${{ number_format($tour->old_price_adult, 2) }}</del>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('tours.show', $tour->slug) ?? '#' }}" class="vs-btn style7 w-100 mt-3" aria-label="View details for tour: {{ $tour->title }}">View Details</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
             {{-- Tour Pagination --}}
             @if($tours instanceof \Illuminate\Pagination\LengthAwarePaginator && $tours->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $tours->appends(request()->query())->links() }}
                </div>
            @endif
        @endif

        @if($activities->count())
            <h2 class="text-success mt-5 mb-4">Activities Found</h2>
            <div class="row g-4">
                @foreach($activities as $activity)
                    <div class="col-md-4">
                        <div class="tour-package-box bg-white-color h-100 d-flex flex-column"> {{-- Added flex classes for consistent height --}}
                            <div class="tour-package-thumb">
                                {{-- 3. Lazy Loading Added --}}
                                <img
                                    src="{{ asset('storage/' . optional($activity->images->first())->image) }}" {{-- Assuming 'image' field from original code --}}
                                    alt="{{ $activity->title }}"
                                    class="w-100"
                                    loading="lazy" {{-- Lazy Loading Added --}}
                                    {{-- Consider adding width/height attributes if known for better CLS --}}
                                    {{-- width="350" height="250" --}}
                                />
                            </div>
                            <div class="tour-package-content flex-grow-1 d-flex flex-column"> {{-- Added flex classes --}}
                                <h5 class="title line-clamp-2">
                                    <a href="{{ route('activities.show', $activity->slug) ?? '#' }}" aria-label="View details for activity: {{ $activity->title }}">
                                        {{ Str::limit($activity->title, 50) }}
                                    </a>
                                </h5>
                                <div class="pricing-container mt-auto"> {{-- Pushed to bottom --}}
                                    <div class="package-info">
                                        <span class="package-location">
                                            <i class="fa-sharp fa-thin fa-location-dot"></i>
                                            {{ $activity->places->isNotEmpty() ? $activity->places->pluck('name')->implode(', ') : ($activity->category->name ?? 'Various Locations') }}
                                        </span>
                                        <span class="package-time">
                                            <i class="fa-sharp fa-thin fa-clock"></i>
                                            {{ $activity->duration ? $activity->duration : 'N/A' }}
                                        </span>
                                    </div>
                                    <div class="price-info">
                                        @if($activity->old_price_adult && $activity->price_adult && $activity->old_price_adult > $activity->price_adult)
                                            <span class="price-off text-white-color ff-poppins">
                                                {{ round((($activity->old_price_adult - $activity->price_adult) / $activity->old_price_adult) * 100) }}% off
                                            </span>
                                        @endif
                                        <div class="price">
                                            {{-- Added "From" for clarity as it's price_adult --}}
                                            <h6 class="fs-30 ff-rubik">From ${{ number_format($activity->price_adult ?? 0, 2) }}</h6>
                                            @if($activity->old_price_adult && $activity->old_price_adult > ($activity->price_adult ?? 0))
                                                <del class="fs-sm ff-rubik">${{ number_format($activity->old_price_adult, 2) }}</del>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <a href="{{ route('activities.show', $activity->slug) ?? '#' }}" class="vs-btn style7 w-100 mt-3" aria-label="View details for activity: {{ $activity->title }}">View Details</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            {{-- Activity Pagination --}}
            @if($activities instanceof \Illuminate\Pagination\LengthAwarePaginator && $activities->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $activities->appends(request()->query())->links() }}
                </div>
            @endif
        @endif

    @else
        <div class="alert alert-warning text-center mt-5"> {{-- Centered message --}}
            <p>No tours or activities matched your search criteria for "{{ e($searchQuery ?? '') }}".</p>
            <p>Please try different keywords or browse our popular categories.</p>
            {{-- Optional: Add links to popular categories or all tours/activities --}}
            <a href="{{ route('tours.index') }}" class="vs-btn style4 mt-2">View All Tours</a>
            {{-- <a href="{{ route('activities.index') }}" class="vs-btn style4 mt-2">View All Activities</a> --}}
        </div>
    @endif

</div>
@endsection

{{-- Add push styles if needed, original had none --}}
@push('styles')
<style>
    /* Ensure consistent card heights and content alignment */
    .tour-package-box {
        display: flex;
        flex-direction: column;
        height: 100%; /* Make sure the box takes full height of the column */
    }
    .tour-package-content {
        flex-grow: 1; /* Allows content to fill space */
        display: flex;
        flex-direction: column; /* Stack content vertically */
    }
    .tour-package-content .pricing-container {
        margin-top: auto; /* Pushes pricing to the bottom */
        padding-top: 1rem; /* Add some space above pricing */
    }
    .line-clamp-2 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        min-height: 2.4em; /* Reserve space */
    }
    /* Other styles from your original input can be added here if needed */
    .tour-package-thumb img {
        aspect-ratio: 350 / 250; /* Example aspect ratio, adjust as needed */
        object-fit: cover; /* Ensure image covers the area */
    }
     .package-info span { display: block; margin-bottom: 5px; font-size: 0.9em; color: #666;}
     .package-info i { margin-right: 5px; color: var(--theme-color); }
     .price-info { display: flex; justify-content: space-between; align-items: center; margin-top: 10px;}
     .price-off { background-color: var(--theme-color); color: white; padding: 3px 8px; border-radius: 3px; font-size: 0.8em; font-weight: bold; }
     .price h6 { margin-bottom: 0; }
     .price del { color: #999; margin-left: 5px; }
</style>
@endpush