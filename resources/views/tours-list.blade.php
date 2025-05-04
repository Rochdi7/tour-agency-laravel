@extends('layouts.app2')

@section('title')
    @if($placeName)
        Tours in {{ $placeName }}
    @elseif($query)
        Search Results for "{{ $query }}"
    @else
        Explore Our Tours
    @endif
@endsection

{{-- ================================================== --}}
{{-- SEO Meta Description & Structured Data             --}}
{{-- ================================================== --}}
@section('seo_tags')
    {{-- 1. Meta Description --}}
    <meta name="description" content="@if($placeName)Discover exciting tours in {{ $placeName }}. Browse available trips, view durations, prices from ${{ $tours->first()->price_adult ?? 'various prices' }}, and departure locations. Find your perfect Moroccan adventure.@elseif($query)Search results for '{{ $query }}'. Find Morocco tours matching your criteria, including details on duration, price, and departure points.@else{{-- Default Description --}}Explore our wide range of Morocco tours. Discover multi-day packages, view prices, durations, and find your next adventure starting from ${{ $tours->first()->price_adult ?? 'various prices' }}.@endif">
    {{-- Explanation of Dynamic Variables in Meta Description:
        - {{ $placeName }}: Outputs the specific destination name if the page filters tours by destination (e.g., "Marrakech").
        - {{ $query }}: Outputs the user's search term if the page shows search results (e.g., "desert tour").
        - {{ $tours->first()->price_adult ?? 'various prices' }}: Tries to get the starting price from the first tour listed for context, defaulting to 'various prices' if no tours or price exists.
    --}}

    {{-- 2. Schema.org Structured Data (JSON-LD) --}}
    @if($tours->count() > 0)
    <script type="application/ld+json">
    @php
        $itemListElement = [];
        foreach ($tours as $index => $tour) {
            $firstImage = optional($tour->firstImage)->image_path;
            $imageUrl = $firstImage ? asset('storage/' . $firstImage) : asset('assets/img/tour-packages/tour-package-1-1.png'); // Default image if none found

            $offerData = null;
            if (isset($tour->price_adult)) {
                $offerData = [
                    "@type" => "Offer",
                    "price" => number_format($tour->price_adult, 2, '.', ''), // Ensure numeric format without $, commas
                    "priceCurrency" => "USD", // Assuming USD, change if needed
                    "availability" => "https://schema.org/InStock" // Assuming listed tours are available
                ];
                 // Add discount details if present
                 if (isset($tour->discount_percentage) && $tour->discount_percentage > 0) {
                    $offerData['priceSpecification'] = [
                        "@type" => "PriceSpecification",
                        "price" => number_format($tour->price_adult, 2, '.', ''),
                        "priceCurrency" => "USD",
                        "valueAddedTaxIncluded" => false, // Adjust if VAT is included
                        "discount" => $tour->discount_percentage,
                        "discountCode" => "SALE", // Optional: Use a real code if applicable
                        "validFrom" => now()->toIso8601String() // Optional: Specify discount validity start
                    ];
                 }
            }

            $tripOriginData = null;
            if ($tour->departure) {
                $tripOriginData = [
                    "@type" => "Place",
                    "name" => $tour->departure
                ];
            }

             // Construct duration in ISO 8601 format (e.g., P3D for 3 days)
             $durationIso = $tour->duration_days ? 'P' . $tour->duration_days . 'D' : null;


            $itemListElement[] = [
                "@type" => "ListItem",
                "position" => $index + 1 + (($tours->currentPage() - 1) * $tours->perPage()), // Adjust position for pagination
                "item" => [
                    "@type" => "TouristTrip",
                    "name" => $tour->title,
                    "description" => Str::limit(strip_tags($tour->short_description ?? $tour->title), 150), // Use short description or title
                    "url" => route('tours.show', $tour->slug),
                    "image" => $imageUrl,
                    "duration" => $durationIso, // Add duration if available
                    "offers" => $offerData,
                    "tripOrigin" => $tripOriginData
                ]
            ];
        }

        $schemaData = [
            "@context" => "https://schema.org",
            "@type" => $query ? "SearchResultsPage" : "ItemList", // Use SearchResultsPage if it's search results
            "name" => $title ?? ($placeName ? "Tours in " . $placeName : ($query ? "Search Results for " . $query : "Explore Our Tours")),
            "description" => $metaDescription ?? ($placeName ? "Discover exciting tours in " . $placeName : ($query ? "Search results for '" . $query . "'" : "Explore our wide range of Morocco tours.")),
            "itemListElement" => $itemListElement,
            "numberOfItems" => $tours->total() // Total number of tours matching criteria
        ];
    @endphp
    {!! json_encode($schemaData, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>
    @endif
@endsection

@section('content')
    <main>
    {{-- Banner Section --}}
    <section class="vs-breadcrumb" data-bg-src="{{ asset('assets/img/moroccan-architecture-courtyard-orange-tree-tour-banner.jpg') }}">
      {{-- 3. Lazy Loading Added --}}
      <img
        src="{{ asset('assets/img/icons/cloud.png') }}"
        alt="Decorative cloud icon for tour list banner"
        class="vs-breadcrumb-icon-1 animate-parachute"
        loading="lazy" {{-- Lazy Loading Added --}}
      />
      {{-- 3. Lazy Loading Added --}}
      <img
        src="{{ asset('assets/img/icons/ballon-sclation.png') }}"
        alt="Hot air balloon icon symbolizing Moroccan travel"
        class="vs-breadcrumb-icon-2 animate-parachute"
        loading="lazy" {{-- Lazy Loading Added --}}
      />

      <div class="container">
        <div class="row text-center">
          <div class="col-12">
            <div class="breadcrumb-content">
              <h1 class="breadcrumb-title">
                @if($placeName)
                  Tours in {{ $placeName }}
                @elseif($query)
                  Search Results
                @else
                  Explore Our Tours
                @endif
              </h1>

              @if(isset($query) && $query)
              <p class="text-white">Showing results for: "{{ $query }}"</p>
              @endif

              <figcaption class="image-caption" style="color: white; font-size: medium;">
                A serene Moroccan courtyard with traditional arches and an orange tree in bloom, reflecting the charm of cultural tour experiences.
              </figcaption>

              <p class="visually-hidden">
                Step into Morocco’s rich heritage with a visit to traditional courtyards and palaces.
                This image captures the timeless beauty of Moroccan design, where intricate tilework, archways, and lush orange trees offer a peaceful glimpse into local architecture and culture.
              </p>
            </div>

          </div>
        </div>
      </div>
    </section>

    {{-- Tour Listing Section --}}
    <section class="vs-tour-package space">
        <div class="container">
            @if($tours->count() > 0)
                <div class="row gy-4">
                    @foreach ($tours as $tour)
                        <div class="col-md-6 col-lg-4">
                            <div class="tour-package-box bg-white-color h-100">
                                <div class="tour-package-thumb">
                                    @php
                                        // Calculate image URL (same logic as in JSON-LD)
                                        $firstImage = optional($tour->firstImage)->image_path;
                                        $imageUrl = $firstImage ? asset('storage/' . $firstImage) : asset('assets/img/tour-packages/tour-package-1-1.png');
                                    @endphp

                                    <a href="{{ route('tours.show', $tour->slug) }}">
                                        {{-- 3. Lazy Loading Added --}}
                                        <img src="{{ $imageUrl }}" alt="{{ $tour->title }}" class="w-100" loading="lazy" /> {{-- Lazy Loading Added --}}
                                    </a>

                                    @if(isset($tour->discount_percentage) && $tour->discount_percentage > 0)
                                        <span class="tour-package-offer">{{ $tour->discount_percentage }}% OFF</span>
                                    @endif
                                </div>
                                <div class="tour-package-content">
                                    @if($tour->departure)
                                        <div class="tour-package-location">
                                            <i class="fas fa-map-marker-alt"></i> {{ $tour->departure }}
                                        </div>
                                    @endif
                                    <h5 class="tour-package-title line-clamp-2">
                                        <a href="{{ route('tours.show', $tour->slug) }}">{{ $tour->title }}</a>
                                    </h5>
                                    <div class="row g-2 justify-content-between align-items-center mt-auto pt-3">
                                        <div class="col-auto">
                                            <div class="tour-package-info">
                                                @if($tour->duration_days)
                                                    <span class="info-item">
                                                        <i class="fas fa-clock"></i> {{ $tour->duration_days }} {{ Str::plural('Day', $tour->duration_days) }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                                @if(isset($tour->price_adult))
                                                <div class="tour-package-price">
                                                    From <span class="price">${{ number_format($tour->price_adult) }}</span>
                                                </div>
                                                @endif
                                        </div>
                                    </div>
                                    <a href="{{ route('tours.show', $tour->slug) }}" class="vs-btn style7 w-100 mt-3">View Details</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{-- Pagination --}}
                <div class="row">
                    <div class="col-12 d-flex justify-content-center mt-5">
                        {{ $tours->appends(request()->query())->links() }}
                    </div>
                </div>
            @else
                {{-- No Tours Found Message --}}
                <div class="row">
                    <div class="col-12 text-center">
                        @if($placeName)
                            <p>There are currently no tours listed for the destination "{{ $placeName }}".</p>
                            <a href="{{ route('destinations.index') }}" class="vs-btn mt-3">View Other Destinations</a>
                        @elseif($query)
                            <p>No tours found matching your search criteria "{{ $query }}".</p>
                            <a href="{{ route('tours.index') }}" class="vs-btn mt-3">View All Tours</a>
                        @else
                            <p>No tours available at the moment.</p>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </section>
    </main>
@endsection

@push('styles')
{{-- Styles remain unchanged --}}
<style>
    .tour-package-box {
        display: flex;
        flex-direction: column;
    }
    .tour-package-content {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    .tour-package-content > .row {
        margin-top: auto;
    }
    .line-clamp-2 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        min-height: 2.4em; /* Ensure space even for short titles */
    }
     .line-clamp-3 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
     }
    .tour-package-thumb {
        position: relative;
    }
    .tour-package-offer {
        position: absolute;
        top: 15px;
        left: 15px;
        background-color: var(--theme-color);
        color: white;
        padding: 5px 10px;
        font-size: 0.8em;
        font-weight: bold;
        border-radius: 3px;
        z-index: 2;
    }
    .tour-package-location {
        font-size: 0.9em;
        color: #666;
        margin-bottom: 8px;
    }
    .tour-package-location i {
         margin-right: 4px;
         color: var(--theme-color);
    }
    .tour-package-info .info-item {
        margin-right: 10px;
        font-size: 0.9em;
        color: #666;
    }
    .tour-package-info .info-item i {
        margin-right: 4px;
        color: var(--theme-color);
    }
    .tour-package-price {
        font-size: 0.9em;
        color: #666;
    }
     .tour-package-price .price {
        font-size: 1.3em;
        font-weight: bold;
        color: var(--title-color);
    }
</style>
@endpush