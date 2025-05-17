@extends('layouts.app2') {{-- Or your main layout file --}}

{{-- 1. Page Title: Optimized for keywords and clarity (Existing logic is good) --}}
@section('title', 'Explore Morocco Destinations: Tours in Marrakech, Fes, Sahara & More | Morocco Quest')

{{-- 2. Meta Description: Specific description wrapped in
<meta> tag --}}
@section('meta_description')
    {{-- Describes the page content (listing destinations) and includes relevant keywords. --}}
    <meta name="description"
        content="Discover the best destinations in Morocco with Morocco Quest. Find guided tours, excursions, and activities in Marrakech, Fes, Chefchaouen, the Sahara Desert, and other top Moroccan locations.">
@endsection

{{-- NEW SECTION: Added for page-specific JSON-LD Structured Data --}}
@section('structured_data')
    {{-- Prepare data for ItemList --}}
    @php
        $itemListElements = [];
        // Check if $placesData exists and has items (check for Paginator or Collection)
        $items = ($placesData instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator) ? $placesData->items() : ($placesData ?? collect());

        if (count($items) > 0) {
            // Calculate the starting index based on pagination if applicable
            $startIndex = ($placesData instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator) ? (($placesData->currentPage() - 1) * $placesData->perPage()) : 0;

            foreach ($items as $index => $place) {
                // --- Refined Image Logic ---
                $imageUrl = asset('assets/img/destination/destination-1-1.png'); // Default placeholder
                if (!empty($place->image_path)) {
                    $cleanedPath = trim(str_replace('\\', '/', $place->image_path), '/');
                    // Check existence within the 'public' disk (linked storage)
                    if (Illuminate\Support\Facades\Storage::disk('public')->exists($cleanedPath)) {
                        $imageUrl = asset('storage/' . $cleanedPath);
                    }
                    // You might add a log here if image is expected but not found
                    // else { \Log::warning("Destination image not found: " . $cleanedPath); }
                }
                // --- End Refined Image Logic ---

                $itemListElements[] = [
                    '@type' => 'ListItem',
                    'position' => $startIndex + $index + 1, // Position in the overall list
                    'item' => [
                        // Each item is a Tourist Destination
                        '@type' => 'TouristDestination',
                        'name' => $place->name, // Name of the destination (e.g., "Marrakech")
                        // URL links to the page showing tours for this specific destination
                        'url' => route('tours.byPlace', ['slug' => $place->slug]) ?? '#',
                        'image' => $imageUrl, // Image representing the destination
                        // Optional: Add a description if available on the $place model
                        // 'description' => $place->description ?? 'Explore tours and activities in ' . $place->name,
                        // Optional: Geographic coordinates if available
                        // 'geo' => [
                        //     '@type' => 'GeoCoordinates',
                        //     'latitude' => $place->latitude,
                        //     'longitude' => $place->longitude,
                        // ]
                    ]
                ];
            }
        }

        // Helper to safely get the meta description content
        $metaDescriptionContent = '';
        try {
            $metaDescriptionContent = strip_tags($__env->yieldContent('meta_description'));
        } catch (\Throwable $e) {
            $metaDescriptionContent = 'Discover the best destinations in Morocco with Morocco Quest.'; // Fallback
        }
        if (empty($metaDescriptionContent)) {
            $metaDescriptionContent = 'Discover the best destinations in Morocco with Morocco Quest. Find guided tours, excursions, and activities in Marrakech, Fes, Chefchaouen, the Sahara Desert, and other top Moroccan locations.';
        }

    @endphp

    <script type="application/ld+json">
            {
              "@context": "https://schema.org",
              // This page lists a collection of tourist destinations
              "@type": "CollectionPage",
              // Name derived from the H1/Title
              "name": "Explore Top Morocco Destinations",
              // Description derived from the meta description content
              "description": "{{ $metaDescriptionContent }}",
              // URL of this specific destination listing page
              "url": "{{ url()->current() }}",
               // Representative image for the page (using the hero image)
              "image": "{{ asset('assets/img/rabat-royal-palace-tourists-guided-walking-tour.webp') }}",
              "mainEntity": { // The primary content is the list of destinations
                "@type": "ItemList",
                // Contains details about each destination listed on this specific page
                "itemListElement": @json($itemListElements, JSON_UNESCAPED_SLASHES) // Safely outputs the PHP array as JSON
              },
               "publisher": { // Information about the site publishing the content
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

            {{-- Breadcrumb Section --}}
            <section class="vs-breadcrumb"
                data-bg-src="{{ asset('assets/img/rabat-royal-palace-tourists-guided-walking-tour.webp') }}">
                <img src="{{ asset('assets/img/icons/cloud.png') }}" alt="Decorative cloud icon"
                    class="vs-breadcrumb-icon-1 animate-parachute" loading="lazy" />

                <img src="{{ asset('assets/img/icons/ballon-sclation.png') }}" alt="Decorative hot air balloon icon"
                    class="vs-breadcrumb-icon-2 animate-parachute" loading="lazy" />

                <div class="container">
                    <div class="row text-center">
                        <div class="col-12">
                            <div class="breadcrumb-content">
                                <h1 class="breadcrumb-title">Explore Top Morocco Destinations</h1>
                                <p class="breadcrumb-subtitle" style="color: white;">
                                    Discover the magic of Morocco's most iconic cities and hidden gems.
                                </p>

                                <figcaption class="image-caption visually-hidden">
                                    A group of tourists approaching the Royal Palace in Rabat during a guided walking tour
                                    on a clear day.
                                </figcaption>

                                <p class="visually-hidden">
                                    A guided group tour exploring the surroundings of the Royal Palace in Rabat, Morocco.
                                    This iconic landmark is a must-see attraction, known for its elegant architecture,
                                    historical significance, and serene atmosphere.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>


            {{-- Main Destinations Listing Section --}}
            <section class="vs-destination space">
                <div class="container">
                    {{-- Check if $placesData exists and has items --}}
                    @if(isset($placesData) && $placesData->count() > 0)
                        {{-- Row containing destination cards --}}
                        {{-- Schema.org CollectionPage added via JSON-LD in the 'structured_data' section --}}
                        <div class="row gx-3 gy-3">
                            {{-- Loop through the paginated destination data --}}
                            @foreach ($placesData as $place)
                                {{-- $place->slug: URL-friendly identifier for the destination (e.g., "marrakech") --}}
                                {{-- $place->name: Display name of the destination (e.g., "Marrakech") --}}
                                {{-- $place->image_path: Path to the destination image relative to storage/app/public --}}
                                {{-- $place->tours_count: Number of tours available in this destination --}}
                                <div class="col-md-6 col-lg-3">
                                    {{-- Link to the page showing tours filtered by this destination --}}
                                    <a href="{{ route('tours.byPlace', ['slug' => $place->slug]) }}"
                                        class="destination-box-2 d-block text-decoration-none"
                                        aria-label="View tours in {{ e($place->name) }}"> {{-- Added e() for safety --}}
                                        <figure class="destination-thumb">
                                            @php
                                                // --- Refined Image Logic (Repeated for clarity, could be a view helper/component) ---
                                                $imageUrl = asset('assets/img/destination/destination-1-1.png'); // Default placeholder
                                                if (!empty($place->image_path)) {
                                                    $cleanedPath = trim(str_replace('\\', '/', $place->image_path), '/');
                                                    if (Illuminate\Support\Facades\Storage::disk('public')->exists($cleanedPath)) {
                                                        $imageUrl = asset('storage/' . $cleanedPath);
                                                    }
                                                }
                                                // --- End Refined Image Logic ---
                                            @endphp
                                            {{-- Destination Image: Added loading="lazy", dynamic alt, onerror fallback --}}
                                            <img src="{{ $imageUrl }}" alt="Explore tours in {{ e($place->name) }}, Morocco" {{--
                                                Added e() for safety --}} class="w-100" {{-- Ensure responsiveness --}}
                                                loading="lazy" {{-- Added Lazy Loading --}}
                                                onerror="this.onerror=null;this.src='{{ asset('assets/img/destination/destination-1-1.png') }}';"
                                                {{-- Fallback on error --}} {{-- width="300" height="400" --}} {{-- CRITICAL: Add
                                                actual width/height to prevent layout shift --}} />
                                        </figure>
                                        <div class="destination-content">
                                            {{-- Destination Name (H5 appropriate within card) --}}
                                            <h5 class="title">
                                                {{ e($place->name) }}
                                            </h5>
                                            {{-- Tour Count Info --}}
                                            <span class="info">
                                                {{ $place->tours_count ?? 0 }} {{ Str::plural('Tour', $place->tours_count ?? 0) }}
                                                Available
                                            </span>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>

                        {{-- Pagination Links --}}
                        {{-- Check if $placesData is a paginator instance before trying to render links --}}
                        @if ($placesData instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)
                            <div class="mt-4 d-flex justify-content-center">
                                {{-- $placesData->links(): Renders Laravel's pagination view --}}
                                {{ $placesData->links() }}
                            </div>
                        @endif
                    @else
                        {{-- Fallback message if no destinations are found --}}
                        <div class="row">
                            <div class="col-12 text-center">
                                <p>No destinations available at the moment. Please check back soon!</p>
                                <a href="{{ route('home') ?? url('/') }}" class="vs-btn mt-3">Back to Home</a>
                            </div>
                        </div>
                    @endif
                </div>
            </section>
        </main>
@endsection