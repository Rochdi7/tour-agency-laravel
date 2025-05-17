@php
    // Helper function to generate a safe storage URL or a default (from blog details)
    function getFeaturedImageUrl($imagePath, $default) {
        if (!$imagePath) {
            return asset($default);
        }
        $normalizedPath = str_replace('\\', '/', $imagePath);
        $relativePath = '';
         if (Illuminate\Support\Str::startsWith($normalizedPath, 'storage/')) {
            $relativePath = Illuminate\Support\Str::after($normalizedPath, 'storage/');
         } elseif (Illuminate\Support\Str::contains($normalizedPath, '/storage/app/public/')) {
            $relativePath = Illuminate\Support\Str::after($normalizedPath, '/storage/app/public/');
        } elseif (Illuminate\Support\Str::contains($normalizedPath, '/public/')) {
            $relativePath = Illuminate\Support\Str::after($normalizedPath, '/public/');
        } else {
             $relativePath = $normalizedPath;
        }
        $cleanedPath = trim($relativePath, '/');
        if (!empty($cleanedPath) && Illuminate\Support\Facades\Storage::disk('public')->exists($cleanedPath)) {
             return asset('storage/' . $cleanedPath);
        }
        // If path doesn't seem to be storage-related but exists as a public asset
        if (file_exists(public_path($cleanedPath))) {
             return asset($cleanedPath);
        }
        // Fallback to default if nothing works
        return asset($default);
    }

    // Prepare Schema Data
    $activityTitle = $activity->title ?? 'Activity Details';
    // Use short_description preferentially, fall back to overview, ensure plain text and limit length for description.
    $activityDescription = $activity->short_description
                           ? strip_tags($activity->short_description)
                           : Illuminate\Support\Str::limit(strip_tags($activity->overview ?? 'Explore this exciting activity in Morocco.'), 250); // Slightly longer for schema is ok
    $metaDescriptionContent = $activity->short_description
                              ? e(Illuminate\Support\Str::limit(strip_tags($activity->short_description), 158)) // Use 'e()' for security
                              : e(Illuminate\Support\Str::limit(strip_tags($activity->overview ?? 'Discover details about this exciting Morocco activity offered by Morocco Quest.'), 158)); // Use 'e()' for security


    $mainImage = ($activity->images && $activity->images->isNotEmpty()) ? getFeaturedImageUrl($activity->images->first()->image, asset('assets/img/activity/activity-placeholder.png')) : asset('assets/img/activity/activity-placeholder.png');
    $currentUrl = url()->current();

    $schemaData = [
        '@context' => 'https://schema.org',
        '@type' => 'Product', // Use Product schema for bookable activities/tours
        'name' => $activityTitle,
        'description' => $activityDescription, // Use prepared description
        'image' => $mainImage,
        'url' => $currentUrl,
        'sku' => $activity->slug ?? $activity->id, // Use slug or ID as a unique identifier
        'brand' => [
            '@type' => 'Brand',
            'name' => 'Morocco Quest', // Your brand name
        ],
        // Add offers if pricing is available
        'offers' => (isset($activity->price_adult) && $activity->price_adult > 0) ? [
            '@type' => 'Offer',
            'url' => $currentUrl . '#review', // Link to booking/inquiry form section
            'priceCurrency' => 'USD', // Assuming USD, change if necessary based on your setup
            'price' => number_format($activity->price_adult, 2, '.', ''), // Format price without comma
            'availability' => 'https://schema.org/InStock', // Or Inquire if price isn't shown? Consider 'https://schema.org/OnlineOnly' or 'https://schema.org/PreOrder' if applicable
            'validFrom' => now()->toDateString(), // Use date string, ISO8601 is also valid 'now()->toIso8601String()'
            'priceSpecification' => [
                '@type' => 'PriceSpecification',
                 'price' => number_format($activity->price_adult, 2, '.', ''),
                 'priceCurrency' => 'USD',
                 'valueAddedTaxIncluded' => false, // Adjust if VAT is included
                 'description' => 'Price per adult'
            ],
             // Optionally add priceSpecification for child price if it exists and you want it in Schema
             // Note: Schema.org Offer typically expects *one* price, but multiple PriceSpecification entries under *one* Offer are possible, though complex.
             // It might be better to represent different price points (adult/child) as separate Offers if validation requires it.
             // For simplicity, we focus on the main adult price here.
        ] : null, // Set offers to null if no adult price
        // Add aggregate rating if you collect reviews and have the data available
        // 'aggregateRating' => [
        //   '@type' => 'AggregateRating',
        //   'ratingValue' => '4.8', // Replace with dynamic $activity->average_rating ?? null
        //   'reviewCount' => '15'  // Replace with dynamic $activity->review_count ?? null
        // ],
        // Add category if available
         'category' => isset($activity->category) ? $activity->category->name : 'Moroccan Activities',
         // Additional potentially useful properties for Tours/Activities:
         // 'location' => [ '@type' => 'Place', 'name' => $activity->location_name ?? 'Morocco' ], // If location name exists
         // 'isFamilyFriendly' => $activity->is_family_friendly ?? true, // Boolean if available
         // 'tourDuration' => $activity->duration_iso8601, // If you have duration in ISO 8601 format (e.g., 'P3D' for 3 days)
    ];

     // Clean up null values from the final array structure
     $schemaData = array_filter($schemaData, function($value) { return !is_null($value); });
     if (isset($schemaData['offers'])) {
        $schemaData['offers'] = array_filter($schemaData['offers']);
        if (isset($schemaData['offers']['priceSpecification'])) {
            $schemaData['offers']['priceSpecification'] = array_filter($schemaData['offers']['priceSpecification']);
        }
        // If offers became empty after filtering, remove it entirely
        if(empty($schemaData['offers'])) {
            unset($schemaData['offers']);
        }
     }
     if (isset($schemaData['brand'])) {
        $schemaData['brand'] = array_filter($schemaData['brand']);
         if(empty($schemaData['brand'])) {
            unset($schemaData['brand']);
        }
     }

@endphp

{{-- Use the main layout --}}
@extends('layouts.app2')

{{-- Page Title: Already optimized using dynamic data --}}
@section('title', $activityTitle . ' | Morocco Quest Activities')

{{-- Head Section Push: Add Meta Description here, Keep OG/Twitter --}}
@push('head')
    {{-- ✅ 1. Meta Description --}}
    {{-- Dynamically generated based on $activity->short_description or fallback to $activity->overview. --}}
    {{-- $activity->short_description: Outputs the specific short summary for this activity. --}}
    {{-- $activity->overview: Outputs the main description text if short description is missing. --}}
    {{-- e() escapes output; Str::limit ensures length <= 158 chars; strip_tags removes HTML. --}}
    <meta name="description" content="{{ $metaDescriptionContent }}">

    {{-- Keep existing Open Graph & Twitter Card meta tags as they are page-specific --}}
    <meta property="og:type" content="product" />
    <meta property="og:title" content="{{ e($activityTitle) }}" />
    <meta property="og:description" content="{{ $metaDescriptionContent }}" /> {{-- Use same content as meta description --}}
    <meta property="og:url" content="{{ $currentUrl }}" />
    <meta property="og:image" content="{{ $mainImage }}" /> {{-- Use variable defined above --}}
     {{-- Add width/height if known for the featured image --}}
    {{-- <meta property="og:image:width" content="1200" /> --}}
    {{-- <meta property="og:image:height" content="630" /> --}}
    <meta property="og:site_name" content="Morocco Quest" />
    @if(isset($activity->price_adult) && $activity->price_adult > 0)
        <meta property="product:price:amount" content="{{ number_format($activity->price_adult, 2, '.', '') }}">
        <meta property="product:price:currency" content="USD"> {{-- Assuming USD --}}
        <meta property="product:availability" content="instock"> {{-- Or appropriate status --}}
    @endif

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ e($activityTitle) }}">
    <meta name="twitter:description" content="{{ $metaDescriptionContent }}"> {{-- Use same content as meta description --}}
    <meta name="twitter:image" content="{{ $mainImage }}">
    {{-- Add Twitter site handle if configured: <meta name="twitter:site" content="@YourTwitterHandle"> --}}
@endpush


@section('content')

{{-- Breadcrumb Section --}}
<section class="vs-breadcrumb" data-bg-src="{{ asset('assets/img/berber-terrace-atlas-mountains-imlil-morocco.webp') }}"> {{-- Class untouched --}}
    {{-- ✅ 3. Lazy Loading for Images --}}
    <img
        src="{{ asset('assets/img/icons/cloud.png') }}"
        alt="Decorative cloud icon"
        class="vs-breadcrumb-icon-1 animate-parachute" {{-- Class untouched --}}
        loading="lazy"
        {{-- Consider adding width/height if known --}}
        {{-- width="X" height="Y" --}}
    />
    {{-- ✅ 3. Lazy Loading for Images --}}
    <img
        src="{{ asset('assets/img/icons/ballon-sclation.png') }}"
        alt="Decorative hot air balloon icon"
        class="vs-breadcrumb-icon-2 animate-parachute" {{-- Class untouched --}}
        loading="lazy"
        {{-- Consider adding width/height if known --}}
         {{-- width="X" height="Y" --}}
    />
    <div class="container">
        <div class="row text-center">
            <div class="col-12">
                <div class="breadcrumb-content">
                    {{-- H1 for the main page title - Good --}}
                    <h1 class="breadcrumb-title">{{ $activityTitle }}</h1> {{-- Class untouched --}}

                    @if($activity->subtitle)
                    <p class="breadcrumb-subtitle" style="color: white; font-size: medium">
                        {{ $activity->subtitle }}
                    </p>
                    @endif

                    <figcaption class="image-caption" style="color: white; font-size: medium;" >
                        A vibrant Berber terrace overlooking the majestic Atlas Mountains in Imlil, Morocco.
                    </figcaption>

                    {{-- Hidden paragraph - kept as is --}}
                    <p class="visually-hidden"> {{-- Class untouched --}}
                        Discover the beauty of traditional Moroccan hospitality in Imlil. This stunning terrace offers panoramic views of the
                        High Atlas Mountains, perfect for cultural activities like tea ceremonies, cooking classes, and local crafts.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

    {{-- Main Content Section - REMOVED Microdata (itemscope, itemtype) --}}
    <section class="vs-destination-details space bg-theme-07"> {{-- Class untouched --}}
        {{-- Microdata meta/span tags removed here - rely on JSON-LD script below --}}

        <div class="container">
            <div class="row gx-3 gx-xl-5 gy-5">
                {{-- Main Content Column --}}
                <div class="col-lg-8">
                    <div class="vs-destination-single"> {{-- Class untouched --}}
                        <div class="row align-items-center gy-3 mb-4">
                            <div class="col-8 col-sm-10">
                                {{-- H2 for title - Acceptable structure below H1 --}}
                                <h2 class="destination-single-title"> {{-- Class untouched --}}
                                    {{ $activityTitle }}
                                </h2>
                            </div>
                             {{-- Display Duration --}}
                            <div class="col-4 col-sm-2 d-flex justify-content-end">
                                @if($activity->duration_days)
                                    <div class="destination-single-meta"> {{-- Class untouched --}}
                                        <h3>{{ $activity->duration_days }}</h3>
                                        <span>{{ Illuminate\Support\Str::plural('Hours', $activity->duration_days) }}</span>
                                    </div>
                                @elseif($activity->duration)
                                    <div class="destination-single-meta"> {{-- Class untouched --}}
                                        @php
                                            // Basic parsing for duration like "3 Hours", "Half Day"
                                            $durationNum = preg_replace('/[^0-9]/', '', $activity->duration);
                                            $durationText = trim(preg_replace('/[0-9]+/', '', $activity->duration)) ?: 'Units'; // Provide fallback unit
                                        @endphp
                                        <h3>{{ $durationNum ?: '?' }}</h3>
                                        <span>{{ $durationText }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="destination-single-info"> {{-- Class untouched --}}
                            {{-- Main Image --}}
                            <figure class="destination-single-img d-block mb-4">
    @php 
        $image = $activity->images->first(); // Fetch the first image
    @endphp

    @if ($image)
        <img src="{{ asset('storage/' . $image->image) }}" {{-- Image path from storage --}}
             alt="{{ $image->alt ?? $activity->title }}" {{-- Alt text from database or activity title --}}
             title="{{ $image->caption ?? $activity->title }}" {{-- Caption as title attribute --}}
             class="w-100" {{-- Ensure responsiveness --}}
             loading="lazy"
             width="810" height="540" {{-- Optional: Add dimensions for CLS stabilization --}}
             style="object-fit: cover;" {{-- Ensure consistent display --}}
        />

        @if($image->description)
            {{-- Hidden description for SEO --}}
            <div style="display: none;" aria-hidden="true">
                {{ $image->description }}
            </div>
        @endif
    @else
        {{-- Placeholder image if none found --}}
        <img src="{{ asset('assets/img/activity/activity-placeholder.png') }}"
             alt="{{ $activity->title ?? 'Activity Image' }}"
             class="w-100"
             loading="lazy"
             width="810" height="540"
             style="object-fit: cover;"
        />
    @endif
</figure>


                            <div class="destination-single-px"> {{-- Class untouched --}}
                                {{-- Internal page navigation tabs --}}
                                <div class="destination-info-tabs"> {{-- Class untouched --}}
                                    <ul class="custom-ul"> {{-- Class untouched --}}
                                        {{-- Added aria-current for accessibility on active tab --}}
                                        <li class="current" aria-current="page"><a href="#overview" aria-label="Jump to Overview section">Overview</a></li>
                                        <li><a href="#itinerary" aria-label="Jump to Itinerary section">Itinerary</a></li>
                                        <li><a href="#cost" aria-label="Jump to Cost section">Cost</a></li>
                                        <li><a href="#faq" aria-label="Jump to FAQs section">FAQs</a></li>
                                        <li><a href="#map" aria-label="Jump to Map section">Map</a></li>
                                        <li><a href="#review" aria-label="Jump to Inquiry form section">Send Request</a></li>
                                    </ul>
                                    <hr>
                                </div>

                                {{-- Overview Section --}}
                                {{-- REMOVED itemprop="description" --}}
                                <div id="overview" class="destination-overview content-section mb-5"> {{-- Class untouched --}}
                                    {{-- H4 for sub-section title - Appropriate --}}
                                    <h4 class="title mb-3">Overview</h4> {{-- Class untouched --}}
                                    @if($activity->overview)
                                        {!! $activity->overview !!} {{-- Outputting HTML content --}}
                                    @else
                                        <p>Details about the activity overview will be provided here. Contact us for more information!</p>
                                    @endif
                                     {{-- Example list kept, replace/remove as needed --}}
                                    {{-- <ul class="custom-ul mt-3">
                                        <li><i class="fa-solid fa-circle-arrow-right"></i> Key highlight or feature of the activity.</li>
                                        <li><i class="fa-solid fa-circle-arrow-right"></i> Another important detail or benefit.</li>
                                    </ul> --}}
                                </div>
                                <hr class="my-5">

                                {{-- Itinerary Section --}}
                                <div id="itinerary" class="destination-ltinerary content-section mb-5"> {{-- Class untouched --}}
                                    <div class="d-flex justify-content-between align-items-center gap-2 mb-3">
                                         {{-- H4 for sub-section title - Appropriate --}}
                                        <h4 class="title">Itinerary</h4> {{-- Class untouched --}}
                                        {{-- Expand/collapse button - Kept --}}
                                        <a href="#" class="expand-btn" aria-label="Expand or collapse all itinerary items">Expand all</a> {{-- Added aria-label --}}
                                    </div>
                                    @if(isset($activity->itineraryDays) && $activity->itineraryDays->count() > 0)
                                        <div class="d-flex gap-2 gap-xl-4 mt-3">
                                            {{-- Decorative SVGs - Kept as is --}}
                                            <div class="progress-area"> {{-- Classes untouched --}}
                                                <svg xmlns="http://www.w3.org/2000/svg" width="37" height="37" viewBox="0 0 37 37" fill="none" aria-hidden="true"><circle cx="18.5" cy="18.5" r="18.5" fill="#F7921E" /><path d="M23.4463 11.5947C22.6394 10.934 21.6959 10.4606 20.6839 10.2087C19.6719 9.95679 18.6167 9.93261 17.5942 10.1379C16.2795 10.4074 15.07 11.0492 14.1098 11.9867C13.1496 12.9243 12.4791 14.1181 12.1782 15.4259C11.8773 16.7338 11.9587 18.1006 12.4127 19.3635C12.8667 20.6264 13.6742 21.7322 14.7389 22.5491C15.9546 23.4388 16.9896 24.552 17.7886 25.829L18.3331 26.7344C18.4022 26.8494 18.5 26.9445 18.6168 27.0106C18.7336 27.0766 18.8655 27.1114 18.9997 27.1114C19.1338 27.1114 19.2658 27.0766 19.3826 27.0106C19.4994 26.9445 19.5971 26.8494 19.6662 26.7344L20.1881 25.8648C20.8839 24.6416 21.8327 23.581 22.9711 22.7536C23.8637 22.1395 24.6013 21.3264 25.1259 20.3784C25.6504 19.4304 25.9475 18.3734 25.9937 17.291C26.0398 16.2085 25.8338 15.1301 25.3918 14.1409C24.9499 13.1517 24.2841 12.2787 23.4471 11.5908L23.4463 11.5947ZM18.9989 20.1123C18.3836 20.1123 17.782 19.9298 17.2704 19.5879C16.7588 19.2461 16.36 18.7602 16.1245 18.1917C15.8891 17.6232 15.8275 16.9977 15.9475 16.3942C16.0675 15.7907 16.3639 15.2363 16.799 14.8012C17.2341 14.3661 17.7884 14.0698 18.3919 13.9497C18.9954 13.8297 19.621 13.8913 20.1895 14.1268C20.758 14.3623 21.2439 14.761 21.5857 15.2726C21.9276 15.7843 22.11 16.3858 22.11 17.0011C22.11 17.8262 21.7823 18.6176 21.1988 19.201C20.6153 19.7845 19.824 20.1123 18.9989 20.1123Z" fill="white" /></svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="37" height="37" viewBox="0 0 37 37" fill="none" aria-hidden="true"><circle cx="18.5" cy="18.5" r="18.5" fill="#F7921E" /><path d="M28.7986 16.489C28.611 16.3202 28.3423 16.2765 28.1173 16.3827C26.936 16.9202 26.2734 16.314 25.1984 15.1952C24.3796 14.3389 23.392 13.3138 21.967 13.4388C21.917 13.2576 21.7794 13.1076 21.5857 13.0388C21.2607 12.92 20.9044 13.0826 20.7856 13.4076L20.5356 14.0951L19.0012 18.3107L17.4667 14.0951L17.2167 13.4076C17.0979 13.0826 16.7354 12.92 16.4167 13.0388C16.2229 13.1076 16.0916 13.2576 16.0354 13.4388C14.6103 13.3076 13.6228 14.3389 12.7977 15.1952C11.7289 16.314 11.0664 16.9202 9.88507 16.3827C9.65381 16.2765 9.38505 16.3202 9.19751 16.489C9.01627 16.664 8.95378 16.9265 9.03504 17.164L10.7664 21.9205C10.8226 22.0768 10.9414 22.2018 11.0976 22.2706C11.5851 22.4956 12.0289 22.5893 12.4352 22.5893C13.729 22.5893 14.6541 21.6268 15.4354 20.8142C16.4354 19.7766 17.073 19.1766 18.1167 19.5391L18.3364 20.1435L16.7479 24.5081C16.6292 24.8332 16.7917 25.1894 17.1167 25.3082C17.4799 25.4292 17.8146 25.2311 17.9167 24.9394L18.9998 21.9688L20.0794 24.9394C20.2014 25.2649 20.562 25.4236 20.8794 25.3082C21.2044 25.1894 21.3732 24.8332 21.2544 24.5081L19.6662 20.1407L19.8856 19.5391C20.9294 19.1829 21.5732 19.7766 22.567 20.8142C23.3420 21.6268 24.2671 22.5893 25.5671 22.5893C25.9734 22.5893 26.4172 22.4956 26.9047 22.2706C27.0547 22.2018 27.1735 22.0768 27.2297 21.9205L28.9611 17.164C29.0486 16.9265 28.9861 16.664 28.7986 16.489Z" fill="white" /></svg>
                                            </div>
                                            <div class="accordion-style2 accordion flex-grow-1" id="activityItineraryAccordion"> {{-- Classes untouched --}}
                                                @foreach($activity->itineraryDays as $day)
                                                    <div class="accordion-item"> {{-- Class untouched --}}
                                                        {{-- H6 for accordion item header - Acceptable --}}
                                                        <h6 class="accordion-header"> {{-- Class untouched --}}
                                                            <button
                                                                class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" {{-- Classes untouched --}}
                                                                type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#collapseActItinDay{{ $day->id }}"
                                                                aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                                                                aria-controls="collapseActItinDay{{ $day->id }}">
                                                                Day {{ sprintf('%02d', $day->day_number) }}: {{ $day->title ?? 'Itinerary Details' }}
                                                            </button>
                                                        </h6>
                                                        <div id="collapseActItinDay{{ $day->id }}"
                                                            class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" {{-- Classes untouched --}}
                                                            data-bs-parent="#activityItineraryAccordion">
                                                            <div class="accordion-body"> {{-- Class untouched --}}
                                                                {!! $day->description !!} {{-- Outputting HTML content --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        <p class="mt-3">The detailed day-by-day itinerary is not available for this activity yet. Please inquire for details.</p>
                                    @endif
                                </div>
                                <hr class="my-5">

                                {{-- Cost Section --}}
                                <div id="cost" class="destination-cost content-section mb-5"> {{-- Class untouched --}}
                                     {{-- H4 for sub-section title - Appropriate --}}
                                    <h4 class="title mb-3">Cost Information</h4> {{-- Class untouched --}}
                                    <div class="includes"> {{-- Class untouched --}}
                                        <h5 class="sub-title">The Cost Includes</h5> {{-- Class untouched --}}
                                        {{-- Display Includes List --}}
                                        @if(is_string($activity->includes) && !empty(trim($activity->includes)))
                                            @php $includeItems = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $activity->includes))); @endphp
                                            @if(!empty($includeItems))
                                            <ul class="custom-ul"> {{-- Class untouched --}}
                                                @foreach($includeItems as $item)
                                                    <li><i class="fa-solid fa-circle-check text-success me-2" aria-hidden="true"></i> {{ $item }}</li>
                                                @endforeach
                                            </ul>
                                            @else
                                                 <p>Please check the tour description or inquire for included items.</p>
                                            @endif
                                        @else
                                            <p>Details about what the cost includes are not available yet. Please contact us for specifics.</p>
                                        @endif
                                    </div>
                                    <div class="excludes mt-4"> {{-- Class untouched --}}
                                        <h5 class="sub-title">The Cost Excludes</h5> {{-- Class untouched --}}
                                         {{-- Display Excludes List --}}
                                        @if(is_string($activity->excludes) && !empty(trim($activity->excludes)))
                                            @php $excludeItems = array_filter(array_map('trim', preg_split('/\r\n|\r|\n/', $activity->excludes))); @endphp
                                             @if(!empty($excludeItems))
                                                <ul class="custom-ul"> {{-- Class untouched --}}
                                                    @foreach($excludeItems as $item)
                                                        <li><i class="fa-solid fa-circle-xmark text-danger me-2" aria-hidden="true"></i> {{ $item }}</li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                 <p>Generally includes international flights, travel insurance, personal expenses, tips, and drinks unless otherwise stated. Inquire for full details.</p>
                                            @endif
                                        @else
                                            <p>Information about exclusions is not currently listed. Generally, personal expenses, flights, and insurance are not included. Please inquire for confirmation.</p>
                                        @endif
                                    </div>
                                </div>
                                <hr class="my-5">

                                {{-- FAQs Section --}}
                                <div id="faq" class="destination-faq content-section mb-5"> {{-- Class untouched --}}
                                    <div class="d-flex justify-content-between align-items-center gap-2 mb-3">
                                         {{-- H4 for sub-section title - Appropriate --}}
                                        <h4 class="title">Frequently Asked Questions</h4> {{-- Class untouched --}}
                                        <a href="#" class="expand-btn" aria-label="Expand or collapse all frequently asked questions">Expand all</a> {{-- Added aria-label --}}
                                    </div>
                                     {{-- H6 for accordion item header - Acceptable --}}
                                    {{-- Potential Schema: Consider adding FAQPage schema here if FAQs are significant --}}
                                    <div class="accordion-style2 accordion" id="activityFaqAccordion"> {{-- Class untouched --}}
                                        {{-- Example Static FAQs - Replace or augment with dynamic FAQs --}}
                                        <div class="accordion-item">
                                            <h6 class="accordion-header">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFaqOne" aria-expanded="true" aria-controls="collapseFaqOne">
                                                    What level of fitness is required?
                                                </button>
                                            </h6>
                                            <div id="collapseFaqOne" class="accordion-collapse collapse show" data-bs-parent="#activityFaqAccordion">
                                                <div class="accordion-body">
                                                This activity involves [mention level, e.g., moderate walking, some stairs, etc.]. Please contact us if you have specific fitness concerns. {{-- Placeholder text --}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h6 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFaqTwo" aria-expanded="false" aria-controls="collapseFaqTwo">
                                                Is this activity suitable for children?
                                                </button>
                                            </h6>
                                            <div id="collapseFaqTwo" class="accordion-collapse collapse" data-bs-parent="#activityFaqAccordion">
                                                <div class="accordion-body">
                                                    This activity is generally suitable for children aged [mention minimum age if applicable]. However, consider [mention factors like duration, walking distance]. We recommend inquiring about suitability for very young children. {{-- Placeholder text --}}
                                                </div>
                                            </div>
                                        </div>
                                         {{-- Display dynamic FAQs if they exist --}}
                                         @if(isset($activity->faq) && !empty(trim(strip_tags($activity->faq))))
                                             {{-- Keep existing logic for dynamic FAQ display. Consider improving parsing or using a dedicated FAQ structure/field if possible for better SEO/Schema. --}}
                                             {{-- The current fallback display: --}}
                                             <div class="mt-4"> <h5 class="sub-title">Additional Information</h5> {!! $activity->faq !!}</div>
                                        @endif
                                    </div> {{-- End Accordion --}}
                                </div>
                                <hr class="my-5">

                                {{-- Map Section --}}
                                <div id="map" class="destination-map content-section mb-5">
    <h4 class="title mb-3">Activity Location Map</h4>
    @if($activity->map_embed_code)
        <div class="map-embed-wrapper">
            {!! str_replace('<iframe', '<iframe title="Map showing location for ' . e($activity->title) . '" loading="lazy"', $activity->map_embed_code) !!}
        </div>
    @else
        <p>A map for this activity is currently unavailable.</p>
    @endif
</div>

                                <hr class="my-5">

                                {{-- Inquiry Form Section --}}
                                <div id="review" class="destination-request content-section mb-5"> {{-- Class untouched --}}
                                    {{-- H4 for sub-section title - Appropriate --}}
                                    <h4 class="title mb-3">Inquire About This Activity</h4> {{-- Class untouched --}}
                                    <h5 class="sub-title"> Send your enquiry using the form below. </h5> {{-- Class untouched --}}
                                    <p class="short-info">Regarding Activity: <strong>{{ $activityTitle }}</strong></p> {{-- Class untouched --}}
                                    <div class="row">
                                        <div class="col-12">
                                            {{-- Form Session Messages & Errors - Kept as is --}}
                                            @if (session('success'))
                                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    {{ session('success') }}
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>
                                            @endif
                                            @if (session('error'))
                                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                    {{ session('error') }}
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>
                                            @endif
                                            @if ($errors->any())
                                                <div class="alert alert-danger" role="alert">
                                                    <h4 class="alert-heading">Please fix the following errors:</h4>
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                            <li>{{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif

                                            {{-- Form structure - Kept as is, includes labels, ARIA, autocomplete --}}
                                            <form action="{{ route('activity.inquiry.submit', $activity) ?? '#' }}" method="post" class="form-style2"> {{-- Class untouched --}}
                                                @csrf
                                                <div class="row">
                                                     {{-- Form Fields with labels, validation, aria-labels, autocomplete --}}
                                                    <div class="col-12 form-group">
                                                        <label for="act_inq_name">Your Name <span class="text-danger">*</span></label>
                                                        <input id="act_inq_name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Enter Your Full Name *" required value="{{ old('name') }}" aria-label="Your Full Name" autocomplete="name"/>
                                                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                    </div>
                                                    <div class="col-12 form-group">
                                                        <label for="act_inq_email">Your Email <span class="text-danger">*</span></label>
                                                        <input id="act_inq_email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter Your Email Address *" required value="{{ old('email') }}" aria-label="Your Email Address" autocomplete="email"/>
                                                        @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label for="act_inq_nationality">Nationality <span class="text-danger">*</span></label>
                                                        <input id="act_inq_nationality" name="nationality" type="text" class="form-control @error('nationality') is-invalid @enderror" placeholder="Your Nationality *" required value="{{ old('nationality') }}" aria-label="Your Nationality" autocomplete="country-name"/>
                                                        @error('nationality')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label for="act_inq_phone">Contact Number <span class="text-danger">*</span></label>
                                                        <input id="act_inq_phone" name="phone" type="tel" class="form-control @error('phone') is-invalid @enderror" placeholder="Enter Your Phone Number *" required value="{{ old('phone') }}" aria-label="Your Phone Number" autocomplete="tel"/>
                                                        @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                    </div>
                                                    <div class="col-md-6 form-group position-relative">
    <label for="act_inq_arrival_date">Preferred Date</label>
    <input id="act_inq_arrival_date" name="arrival_date" type="text"
        class="form-control @error('arrival_date') is-invalid @enderror"
        placeholder="Preferred Activity Date*" 
        value="{{ old('arrival_date') }}" 
        aria-label="Preferred Activity Date" 
        aria-required="true" readonly />
    @error('arrival_date')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

                                                    <div class="col-md-6 form-group">
                                                        <label for="act_inq_duration_days">Duration (if applicable)</label>
                                                        <input id="act_inq_duration_days" name="duration_days" type="text" class="form-control @error('duration_days') is-invalid @enderror" placeholder="e.g., Half Day, Full Day" value="{{ old('duration_days', $activity->duration ?? ($activity->duration_days ? $activity->duration_days.' '.Str::plural('', $activity->duration_days) : null) ) }}" aria-label="Activity Duration"/>
                                                        @error('duration_days')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label for="act_inq_adults">Number of Adults <span class="text-danger">*</span></label>
                                                        <input id="act_inq_adults" name="adults" type="number" min="1" class="form-control @error('adults') is-invalid @enderror" placeholder="Number Of Adults *" value="{{ old('adults', 1) }}" required aria-label="Number of Adults"/>
                                                        @error('adults')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label for="act_inq_children">Number of Children</label>
                                                        <input id="act_inq_children" name="children" type="number" min="0" class="form-control @error('children') is-invalid @enderror" placeholder="Number Of Children (Age?)" value="{{ old('children', 0) }}" aria-label="Number of Children" />
                                                        @error('children')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                    </div>
                                                    <div class="col-12 form-group">
                                                        <label for="act_inq_message">Your Message / Specific Requests <span class="text-danger">*</span></label>
                                                        <textarea id="act_inq_message" name="inquiry_message" rows="4" class="form-control @error('inquiry_message') is-invalid @enderror" placeholder="Any questions or special requests? *" required aria-label="Your Message or Specific Requests">{{ old('inquiry_message') }}</textarea>
                                                        @error('inquiry_message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                                    </div>
                                                    <div class="col-12 form-group mt-3 mb-0">
                                                        {{-- Submit button with aria-label --}}
                                                        <button class="vs-btn" type="submit" aria-label="Send Inquiry for {{ e($activity->title) }}">Send Inquiry</button> {{-- Class untouched --}}
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div> {{-- End Inquiry Form Section --}}

                            </div> {{-- End destination-single-px --}}
                        </div> {{-- End destination-single-info --}}
                    </div> {{-- End vs-destination-single --}}
                </div> {{-- End col-lg-8 --}}

                 {{-- Sidebar Area --}}
                <div class="col-lg-4">
                    <aside class="sidebar-area activities-sidebar"> {{-- Class untouched --}}
                        {{-- Pricing Widget --}}
                        <div class="widget widget_trip-Availability accordion" id="accordionActivityAvailability"> {{-- Class untouched --}}
                            <div class="accordion-item"> {{-- Class untouched --}}
                                {{-- H6 for widget accordion header - Acceptable --}}
                                <h6 class="accordion-header" id="headingPrice"> {{-- Class untouched --}}
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapsePrice" aria-expanded="true"
                                        aria-controls="collapsePrice">
                                         Activity Pricing (USD) {{-- Assuming USD --}}
                                    </button>
                                </h6>
                                <div id="collapsePrice" class="accordion-collapse collapse show" aria-labelledby="headingPrice" {{-- Classes untouched --}}
                                    data-bs-parent="#accordionActivityAvailability">
                                    <div class="accordion-body"> {{-- Class untouched --}}
                                        <div class="header"> {{-- Class untouched --}}
                                            {{-- Discount Badge Logic - Kept as is --}}
                                            @if(isset($activity->discount) && $activity->discount > 0)
                                                <span class="offer">{{ round($activity->discount) }}% off</span> {{-- Class untouched --}}
                                            @elseif(isset($activity->old_price_adult) && $activity->price_adult && $activity->old_price_adult > $activity->price_adult)
                                                 <span class="offer">{{ round((($activity->old_price_adult - $activity->price_adult) / $activity->old_price_adult) * 100) }}% off</span>
                                            @endif
                                            {{-- Pricing Display Logic - Kept as is --}}
                                            <div class="package-wrapper d-flex justify-content-between gap-2"> {{-- Classes untouched --}}
                                                @if(isset($activity->price_adult) && $activity->price_adult > 0)
                                                    <div class="adult-price text-center"> {{-- Class untouched --}}
                                                        <div class="title"> {{-- Class untouched --}}
                                                            From
                                                            @if(isset($activity->old_price_adult) && $activity->old_price_adult > $activity->price_adult)
                                                                <del class="text-danger">${{ number_format($activity->old_price_adult, ($activity->old_price_adult == floor($activity->old_price_adult)) ? 0 : 2) }}</del>
                                                            @endif
                                                        </div>
                                                        <h5 class="price"> {{-- Class untouched --}}
                                                            ${{ number_format($activity->price_adult, ($activity->price_adult == floor($activity->price_adult)) ? 0 : 2) }}
                                                            <span>/Adult</span>
                                                        </h5>
                                                    </div>
                                                @else
                                                     {{-- Handle Price on Request --}}
                                                     <div class="adult-price text-center"><h5 class="price text-info">Inquire for Price</h5></div>
                                                @endif

                                                {{-- Child Price (Optional) Logic - Kept as is --}}
                                                @if(isset($activity->price_child) && $activity->price_child > 0)
                                                    <div class="child-price text-center"> {{-- Class untouched --}}
                                                         <div class="title"> {{-- Class untouched --}}
                                                            From
                                                            @if(isset($activity->old_price_child) && $activity->old_price_child > $activity->price_child)
                                                                <del class="text-danger">${{ number_format($activity->old_price_child, ($activity->old_price_child == floor($activity->old_price_child)) ? 0 : 2) }}</del>
                                                            @endif
                                                        </div>
                                                        <h5 class="price"> {{-- Class untouched --}}
                                                            ${{ number_format($activity->price_child, ($activity->price_child == floor($activity->price_child)) ? 0 : 2) }}
                                                            <span>/Child</span>
                                                        </h5>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        {{-- Benefits List - Kept as is --}}
                                        <div class="body"> {{-- Class untouched --}}
                                            <ul class="custom-ul"> {{-- Class untouched --}}
                                                <li><i class="fa-solid fa-badge-check" aria-hidden="true"></i> Best Price Guaranteed</li>
                                                <li><i class="fa-solid fa-badge-check" aria-hidden="true"></i> No Booking Fees</li>
                                                <li><i class="fa-solid fa-badge-check" aria-hidden="true"></i> Expert Local Guides</li>
                                            </ul>
                                        </div>
                                         {{-- Inquiry/Contact Links - Kept as is --}}
                                        <div class="footer"> {{-- Class untouched --}}
                                            {{-- Link scrolls to form --}}
                                            <a href="#review" class="vs-btn style9 w-100 scroll-to-form" aria-label="Scroll to Inquiry Form for {{ e($activity->title) }}"> Send Inquiry </a> {{-- Class untouched --}}
                                            <p> Need help with booking? <a href="{{ route('contact.show') ?? '#' }}">Send Us A Message</a> </p> {{-- Use route helper --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                         {{-- Sidebar Trip Info Widget - Kept as is --}}
                        <div class="widget widget_trip"> {{-- Class untouched --}}
                            {{-- Displaying various activity details with decorative SVGs --}}
                            @if($activity->transportation) <div class="trip-info-box"> <div class="header"> <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none" aria-hidden="true"> <path d="M1.87499 8.25002V6.00002C2.08199 6.00002 2.25 5.83201 2.25 5.62501C2.25 5.41801 2.08199 5.25 1.87499 5.25C0.840762 5.25 0 6.0915 0 7.12502V7.87501C0 8.49527 0.504738 9.00001 1.125 9.00001H1.87499C2.08199 9.00001 2.25 8.832 2.25 8.625C2.25 8.418 2.08199 8.25002 1.87499 8.25002Z" fill="currentColor" /> <path d="M16.125 5.25C15.918 5.25 15.75 5.41801 15.75 5.62501C15.75 5.83201 15.918 6.00002 16.125 6.00002V8.25002C15.918 8.25002 15.75 8.41804 15.75 8.62504C15.75 8.83204 15.918 9.00001 16.125 9.00001H16.875C17.4953 9.00001 18 8.49527 18 7.87501V7.12502C18 6.0915 17.1592 5.25 16.125 5.25Z" fill="currentColor" /> <path d="M6.37503 15.75C6.16803 15.75 6.00002 15.918 6.00002 16.125H3.75002C3.75002 15.918 3.58201 15.75 3.37501 15.75C3.16801 15.75 3 15.918 3 16.125V16.875C3 17.4953 3.50474 18 4.125 18H5.62505C6.24531 18 6.75005 17.4953 6.75005 16.875V16.125C6.75005 15.918 6.58203 15.75 6.37503 15.75Z" fill="currentColor" /> <path d="M14.625 15.75C14.418 15.75 14.25 15.918 14.25 16.125H12C12 15.918 11.832 15.75 11.625 15.75C11.418 15.75 11.25 15.918 11.25 16.125V16.875C11.25 17.4953 11.7547 18 12.375 18H13.875C14.4953 18 15 17.4953 15 16.875V16.125C15 15.918 14.832 15.75 14.625 15.75Z" fill="currentColor" /> <path d="M14.625 0H3.37499C2.34073 0 1.5 0.8415 1.5 1.87499V14.625C1.5 15.6585 2.34076 16.5 3.37499 16.5H14.625C15.6593 16.5 16.5 15.6585 16.5 14.625V1.87499C16.5 0.8415 15.6593 0 14.625 0ZM4.875 1.50001H13.125C13.7453 1.50001 14.25 2.00475 14.25 2.62501C14.25 3.24527 13.7453 3.75001 13.125 3.75001H4.875C4.25474 3.75001 3.75 3.24527 3.75 2.62501C3.75 2.00475 4.25474 1.50001 4.875 1.50001ZM4.875 14.25C4.25474 14.25 3.75 13.7453 3.75 13.125C3.75 12.5047 4.25474 12 4.875 12C5.49526 12 6 12.5047 6 13.125C6 13.7453 5.49523 14.25 4.875 14.25ZM13.125 14.25C12.5047 14.25 12 13.7453 12 13.125C12 12.5047 12.5047 12 13.125 12C13.7452 12 14.25 12.5047 14.25 13.125C14.25 13.7453 13.7452 14.25 13.125 14.25ZM15 9.37501C15 9.99527 14.4953 10.5 13.875 10.5H4.12498C3.50471 10.5 2.99998 9.99527 2.99998 9.37501V5.625C2.99998 5.00474 3.50471 4.5 4.12498 4.5H13.875C14.4952 4.5 15 5.00474 15 5.625V9.37501H15Z" fill="currentColor" /> </svg> <span>Transportation</span> </div> <h6 class="info-title">{{ $activity->transportation }}</h6> </div> @endif
                            @if($activity->accommodation) <div class="trip-info-box"> <div class="header"> <svg xmlns="http://www.w3.org/2000/svg" width="19" height="13" viewBox="0 0 19 13" fill="none" aria-hidden="true"> <path d="M1.98604 7.5611V1.69518C1.98604 1.28913 1.65687 0.959961 1.25085 0.959961C0.844794 0.959961 0.515625 1.28913 0.515625 1.69518V11.2997C0.515625 11.7057 0.844794 12.0349 1.25085 12.0349C1.65687 12.0349 1.98604 11.7057 1.98604 11.2997V9.92231L17.0453 9.8869V11.2643C17.0453 11.6703 17.3744 11.9995 17.7804 11.9995C18.1865 11.9995 18.5156 11.6703 18.5156 11.2643V9.8869V7.96374V7.52569L1.98604 7.5611Z" fill="currentColor" /> <path d="M18.5164 6.93125H7.33984V4.16252C7.33984 3.35908 7.99116 2.70776 8.7946 2.70776H15.5795C17.2015 2.70776 18.5164 4.02264 18.5164 5.64464V6.93125Z" fill="currentColor" /> <path d="M4.72262 6.61468C5.71391 6.61468 6.51751 5.81108 6.51751 4.81979C6.51751 3.8285 5.71391 3.0249 4.72262 3.0249C3.73133 3.0249 2.92773 3.8285 2.92773 4.81979C2.92773 5.81108 3.73133 6.61468 4.72262 6.61468Z" fill="currentColor" /> </svg> <span>Accomodation</span> </div> <h6 class="info-title">{{ $activity->accommodation }}</h6> </div> @endif
                            @if($activity->altitude) <div class="trip-info-box"> <div class="header"> <svg xmlns="http://www.w3.org/2000/svg" width="19" height="12" viewBox="0 0 19 12" fill="none" aria-hidden="true"> <path fill-rule="evenodd" clip-rule="evenodd" d="M12.9653 5.18974L10.3742 10.3719L7.04492 2.88093L8.58721 0.586893C8.94166 0.0596826 9.52145 0.0672983 9.87077 0.586893L12.9653 5.18974Z" fill="currentColor" /> <path fill-rule="evenodd" clip-rule="evenodd" d="M5.13764 2.96876C5.4814 2.42341 6.03475 2.41709 6.38249 2.96876L11.1659 10.5575C11.5096 11.1028 11.2703 11.5449 10.6323 11.5449H0.887847C0.249391 11.5449 0.00650534 11.1092 0.354243 10.5575L5.13764 2.96876Z" fill="currentColor" /> <path fill-rule="evenodd" clip-rule="evenodd" d="M13.1973 5.33565C13.5566 4.80106 14.1353 4.79517 14.4986 5.33565L18.0219 10.5769C18.3812 11.1115 18.1538 11.5449 17.5278 11.5449H10.1681C9.53585 11.5449 9.31066 11.1174 9.67398 10.5769L13.1973 5.33565Z" fill="currentColor" /> </svg> <span>Maximum Altitude</span> </div> <h6 class="info-title">{{ $activity->altitude }} {{ $activity->altitude ? Illuminate\Support\Str::contains(strtolower($activity->altitude), ['meter', 'metre', 'm', 'ft', 'feet']) ? '' : 'm' : '' }}</h6> </div> @endif
                            @if($activity->group_size) <div class="trip-info-box"> <div class="header"> <svg xmlns="http://www.w3.org/2000/svg" width="18" height="16" viewBox="0 0 18 16" fill="none" aria-hidden="true"> <path d="M10.8622 2.94795C11.6945 3.46977 12.2781 4.35282 12.3844 5.37782C12.7238 5.53642 13.1005 5.62762 13.4999 5.62762C14.958 5.62762 16.1398 4.44581 16.1398 2.98793C16.1398 1.52983 14.958 0.348022 13.4999 0.348022C12.0557 0.348472 10.8842 1.50916 10.8622 2.94795ZM9.13276 8.35312C10.5909 8.35312 11.7727 7.17109 11.7727 5.7132C11.7727 4.25532 10.5906 3.07352 9.13276 3.07352C7.67488 3.07352 6.4924 4.25555 6.4924 5.71343C6.4924 7.17131 7.67488 8.35312 9.13276 8.35312ZM10.2526 8.53305H8.0125C6.14871 8.53305 4.63242 10.0496 4.63242 11.9134V14.6528L4.63939 14.6957L4.82808 14.7548C6.60674 15.3105 8.152 15.4958 9.42389 15.4958C11.9081 15.4958 13.348 14.7876 13.4368 14.7424L13.6131 14.6532H13.632V11.9134C13.6326 10.0496 12.1164 8.53305 10.2526 8.53305ZM14.6201 5.80778H12.3974C12.3733 6.69711 11.9937 7.49793 11.3933 8.07389C13.0499 8.56652 14.2621 10.1028 14.2621 11.9174V12.7616C16.4568 12.6812 17.7215 12.0591 17.8048 12.0174L17.9811 11.928H18V9.18763C18 7.32406 16.4837 5.80778 14.6201 5.80778ZM4.50056 5.62807C5.017 5.62807 5.49749 5.47734 5.90453 5.22058C6.03392 4.37663 6.48634 3.63915 7.13261 3.13687C7.13531 3.08745 7.14002 3.03848 7.14002 2.98861C7.14002 1.5305 5.95799 0.348696 4.50056 0.348696C3.04223 0.348696 1.86065 1.5305 1.86065 2.98861C1.86065 4.44604 3.04223 5.62807 4.50056 5.62807ZM6.87136 8.07389C6.27383 7.50085 5.89555 6.70429 5.86791 5.82035C5.78547 5.81429 5.70393 5.80778 5.61992 5.80778H3.38008C1.51629 5.80778 0 7.32406 0 9.18763V11.9275L0.00696368 11.9697L0.195657 12.0293C1.62254 12.4747 2.89599 12.68 4.0021 12.7447V11.9174C4.00255 10.1028 5.21423 8.56697 6.87136 8.07389Z" fill="currentColor" /> </svg> <span>Group Size</span> </div> <h6 class="info-title">{{ $activity->group_size }} {{ Str::plural('Person', (int) $activity->group_size) }}</h6> </div> @endif {{-- Corrected pluralization --}}
                            @if($activity->min_age) <div class="trip-info-box"> <div class="header"> <svg xmlns="http://www.w3.org/2000/svg" width="18" height="20" viewBox="0 0 18 20" fill="none" aria-hidden="true"> <path d="M6.6875 0H7.80429V1.58782H6.6875V0Z" fill="currentColor" /> <path d="M3.13672 1.24939L4.10386 0.690994L4.89777 2.06604L3.93063 2.62444L3.13672 1.24939Z" fill="currentColor" /> <path d="M0.689453 4.10559L1.24785 3.13845L2.6229 3.93236L2.0645 4.8995L0.689453 4.10559Z" fill="currentColor" /> <path d="M0 6.68616H1.58785V7.80295H0V6.68616Z" fill="currentColor" /> <path d="M0.689453 10.3835L2.0645 9.58964L2.6229 10.5568L1.24785 11.3507L0.689453 10.3835Z" fill="currentColor" /> <path d="M11.8652 3.93359L13.2403 3.13969L13.7987 4.10683L12.4236 4.90074L11.8652 3.93359Z" fill="currentColor" /> <path d="M9.59375 2.06726L10.3877 0.692179L11.3548 1.25057L10.5609 2.62566L9.59375 2.06726Z" fill="currentColor" /> <path d="M7.47957 8.62386C7.55134 8.62386 7.62334 8.62576 7.69526 8.62952C8.0498 7.93696 8.57026 7.34383 9.21819 6.89808C9.961 6.387 10.8251 6.10438 11.7259 6.0756C11.4999 5.20804 11.0246 4.42003 10.3493 3.8096C9.49728 3.03934 8.39497 2.61511 7.24545 2.61511C4.69235 2.61511 2.61523 4.69223 2.61523 7.24537C2.61523 8.49915 3.11377 9.6767 3.99719 10.5442C4.73375 9.37248 6.03277 8.62386 7.47957 8.62386Z" fill="currentColor" /> <path d="M6.23633 18.6225L7.26255 19.0631L8.21189 16.8518H6.99653L6.23633 18.6225Z" fill="currentColor" /> <path d="M9.01367 18.6225L10.0399 19.0631L10.9892 16.8518H9.77387L9.01367 18.6225Z" fill="currentColor" /> <path d="M11.7852 18.6225L12.8114 19.0631L13.7607 16.8518H12.5454L11.7852 18.6225Z" fill="currentColor" /> <path d="M18.0008 13.3663C18.0008 12.1789 17.1139 11.1694 15.9378 11.0181L15.4855 10.9599L15.4522 10.5051C15.386 9.60563 14.985 8.77001 14.323 8.15216C13.6578 7.53134 12.79 7.18945 11.8795 7.18945C10.4093 7.18945 9.10446 8.0706 8.55511 9.43435L8.38915 9.84634L7.9504 9.77732C7.79543 9.75294 7.63725 9.74058 7.48035 9.74058C6.10036 9.74058 4.90432 10.6745 4.57181 12.0117L4.46851 12.4272L4.04044 12.4353C3.14798 12.4521 2.42188 13.192 2.42188 14.0846C2.42188 14.9946 3.1622 15.7349 4.07216 15.7349H15.6322C16.9382 15.735 18.0008 14.6724 18.0008 13.3663Z" fill="currentColor" /> </svg> <span>Minimum Age</span> </div> <h6 class="info-title">{{ $activity->min_age }}{{ $activity->min_age ? '+' : '' }}</h6> </div> @endif
                            @if($activity->max_age) <div class="trip-info-box"> <div class="header"> <svg xmlns="http://www.w3.org/2000/svg" width="18" height="16" viewBox="0 0 18 16" fill="none" aria-hidden="true"> <path d="M10.8622 2.94795C11.6945 3.46977 12.2781 4.35282 12.3844 5.37782C12.7238 5.53642 13.1005 5.62762 13.4999 5.62762C14.958 5.62762 16.1398 4.44581 16.1398 2.98793C16.1398 1.52983 14.958 0.348022 13.4999 0.348022C12.0557 0.348472 10.8842 1.50916 10.8622 2.94795ZM9.13276 8.35312C10.5909 8.35312 11.7727 7.17109 11.7727 5.7132C11.7727 4.25532 10.5906 3.07352 9.13276 3.07352C7.67488 3.07352 6.4924 4.25555 6.4924 5.71343C6.4924 7.17131 7.67488 8.35312 9.13276 8.35312ZM10.2526 8.53305H8.0125C6.14871 8.53305 4.63242 10.0496 4.63242 11.9134V14.6528L4.63939 14.6957L4.82808 14.7548C6.60674 15.3105 8.152 15.4958 9.42389 15.4958C11.9081 15.4958 13.348 14.7876 13.4368 14.7424L13.6131 14.6532H13.632V11.9134C13.6326 10.0496 12.1164 8.53305 10.2526 8.53305ZM14.6201 5.80778H12.3974C12.3733 6.69711 11.9937 7.49793 11.3933 8.07389C13.0499 8.56652 14.2621 10.1028 14.2621 11.9174V12.7616C16.4568 12.6812 17.7215 12.0591 17.8048 12.0174L17.9811 11.928H18V9.18763C18 7.32406 16.4837 5.80778 14.6201 5.80778ZM4.50056 5.62807C5.017 5.62807 5.49749 5.47734 5.90453 5.22058C6.03392 4.37663 6.48634 3.63915 7.13261 3.13687C7.13531 3.08745 7.14002 3.03848 7.14002 2.98861C7.14002 1.5305 5.95799 0.348696 4.50056 0.348696C3.04223 0.348696 1.86065 1.5305 1.86065 2.98861C1.86065 4.44604 3.04223 5.62807 4.50056 5.62807ZM6.87136 8.07389C6.27383 7.50085 5.89555 6.70429 5.86791 5.82035C5.78547 5.81429 5.70393 5.80778 5.61992 5.80778H3.38008C1.51629 5.80778 0 7.32406 0 9.18763V11.9275L0.00696368 11.9697L0.195657 12.0293C1.62254 12.4747 2.89599 12.68 4.0021 12.7447V11.9174C4.00255 10.1028 5.21423 8.56697 6.87136 8.07389Z" fill="currentColor" /> </svg> <span>Maximum Age</span> </div> <h6 class="info-title">{{ $activity->max_age ?: 'N/A' }}</h6> </div> @endif
                            @if($activity->tour_type) <div class="trip-info-box"> <div class="header"> <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none" aria-hidden="true"> <path d="M1.87499 8.25002V6.00002C2.08199 6.00002 2.25 5.83201 2.25 5.62501C2.25 5.41801 2.08199 5.25 1.87499 5.25C0.840762 5.25 0 6.0915 0 7.12502V7.87501C0 8.49527 0.504738 9.00001 1.125 9.00001H1.87499C2.08199 9.00001 2.25 8.832 2.25 8.625C2.25 8.418 2.08199 8.25002 1.87499 8.25002Z" fill="currentColor" /> <path d="M16.125 5.25C15.918 5.25 15.75 5.41801 15.75 5.62501C15.75 5.83201 15.918 6.00002 16.125 6.00002V8.25002C15.918 8.25002 15.75 8.41804 15.75 8.62504C15.75 8.83204 15.918 9.00001 16.125 9.00001H16.875C17.4953 9.00001 18 8.49527 18 7.87501V7.12502C18 6.0915 17.1592 5.25 16.125 5.25Z" fill="currentColor" /> <path d="M6.37503 15.75C6.16803 15.75 6.00002 15.918 6.00002 16.125H3.75002C3.75002 15.918 3.58201 15.75 3.37501 15.75C3.16801 15.75 3 15.918 3 16.125V16.875C3 17.4953 3.50474 18 4.125 18H5.62505C6.24531 18 6.75005 17.4953 6.75005 16.875V16.125C6.75005 15.918 6.58203 15.75 6.37503 15.75Z" fill="currentColor" /> <path d="M14.625 15.75C14.418 15.75 14.25 15.918 14.25 16.125H12C12 15.918 11.832 15.75 11.625 15.75C11.418 15.75 11.25 15.918 11.25 16.125V16.875C11.25 17.4953 11.7547 18 12.375 18H13.875C14.4953 18 15 17.4953 15 16.875V16.125C15 15.918 14.832 15.75 14.625 15.75Z" fill="currentColor" /> <path d="M14.625 0H3.37499C2.34073 0 1.5 0.8415 1.5 1.87499V14.625C1.5 15.6585 2.34076 16.5 3.37499 16.5H14.625C15.6593 16.5 16.5 15.6585 16.5 14.625V1.87499C16.5 0.8415 15.6593 0 14.625 0ZM4.875 1.50001H13.125C13.7453 1.50001 14.25 2.00475 14.25 2.62501C14.25 3.24527 13.7453 3.75001 13.125 3.75001H4.875C4.25474 3.75001 3.75 3.24527 3.75 2.62501C3.75 2.00475 4.25474 1.50001 4.875 1.50001ZM4.875 14.25C4.25474 14.25 3.75 13.7453 3.75 13.125C3.75 12.5047 4.25474 12 4.875 12C5.49526 12 6 12.5047 6 13.125C6 13.7453 5.49523 14.25 4.875 14.25ZM13.125 14.25C12.5047 14.25 12 13.7453 12 13.125C12 12.5047 12.5047 12 13.125 12C13.7452 12 14.25 12.5047 14.25 13.125C14.25 13.7453 13.7452 14.25 13.125 14.25ZM15 9.37501C15 9.99527 14.4953 10.5 13.875 10.5H4.12498C3.50471 10.5 2.99998 9.99527 2.99998 9.37501V5.625C2.99998 5.00474 3.50471 4.5 4.12498 4.5H13.875C14.4952 4.5 15 5.00474 15 5.625V9.37501H15Z" fill="currentColor" /> </svg> <span>Activity Type</span> </div> <h6 class="info-title">{{ $activity->tour_type }}</h6> </div> @endif {{-- Corrected label --}}
                        </div> {{-- End widget_trip --}}
                    </aside>
                </div> {{-- End col-lg-4 Sidebar --}}
            </div> {{-- End row --}}
        </div> {{-- End container --}}
    </section>

    {{-- Related Activities Section --}}
    @if(isset($relatedActivities) && $relatedActivities->count() > 0)
        <section class="vs-tour-package style-3 space-bottom bg-theme-07"> {{-- Classes untouched --}}
            <div class="container">
                <div class="row">
                    <div class="col-lg-auto mx-auto">
                        <div class="title-area text-center"> {{-- Class untouched --}}
                            <span class="sec-subtitle text-capitalize">Related Activities</span> {{-- Class untouched --}}
                             {{-- H2 for related section title - Appropriate --}}
                            <h2 class="sec-title">You Might Also Be Interested In</h2> {{-- Class untouched --}}
                        </div>
                    </div>
                </div>
                {{-- Potential Schema: Consider adding ItemList schema for related activities --}}
                <div class="row g-4 justify-content-center">
                    @foreach($relatedActivities as $relatedActivity)
                        <div class="col-md-6 col-xl-4">
                            <div class="tour-package-box style-3 bg-white-color"> {{-- Classes untouched --}}
                                <div class="tour-package-thumb"> {{-- Class untouched --}}
                                    {{-- Link with aria-label --}}
                                    <a href="{{ route('activities.show', $relatedActivity->slug ?? $relatedActivity->id) ?? '#' }}" aria-label="View details for {{ e($relatedActivity->title) }}">
                                         {{-- ✅ 3. Lazy Loading for Images --}}
                                        <img src="{{ getFeaturedImageUrl(optional($relatedActivity->images->first())->image ?? $relatedActivity->featured_image ?? null, 'assets/img/tour-packages/tour-package-3-1.png') }}"
                                             alt="Related Activity: {{ e($relatedActivity->title ?? 'Morocco Activity')}}" {{-- Escaped alt text --}}
                                             class="w-100"
                                             loading="lazy"
                                             {{-- Recommend adding width/height --}}
                                             {{-- width="X" height="Y" --}}
                                             />
                                    </a>
                                </div>
                                <div class="tour-package-content"> {{-- Class untouched --}}
                                    @isset($relatedActivity->departure)
                                        <div class="location"><i class="fa-sharp fa-light fa-location-dot" aria-hidden="true"></i><span>{{ $relatedActivity->departure }}</span></div> {{-- Class untouched --}}
                                    @endisset
                                     {{-- H5 for card title - Acceptable --}}
                                    <h5 class="title line-clamp-2"><a href="{{ route('activities.show', $relatedActivity->slug ?? $relatedActivity->id) ?? '#' }}" aria-label="View details for {{ e($relatedActivity->title) }}">{{ $relatedActivity->title }}</a></h5> {{-- Class untouched --}}
                                    <div class="tour-package-footer"> {{-- Class untouched --}}
                                        {{-- Display duration - Kept as is --}}
                                        @if($relatedActivity->duration_days)
                                            <div class="tour-duration"><i class="fa-regular fa-clock" aria-hidden="true"></i>
                                                <span>{{ $relatedActivity->duration_days }} {{ Illuminate\Support\Str::plural('Day', $relatedActivity->duration_days) }}</span>
                                            </div>
                                        @elseif($relatedActivity->duration)
                                             <div class="tour-duration"><i class="fa-regular fa-clock" aria-hidden="true"></i>
                                                <span>{{ $relatedActivity->duration }}</span>
                                            </div>
                                        @endif
                                        {{-- Display Price - Kept as is --}}
                                        <div class="pricing-info fw-medium"> {{-- Classes untouched --}}
                                             @if(isset($relatedActivity->price_adult))
                                                From
                                                @if(isset($relatedActivity->old_price_adult) && $relatedActivity->old_price_adult > $relatedActivity->price_adult)
                                                    <del class="text-theme-color fw-semibold">${{ number_format($relatedActivity->old_price_adult, ($relatedActivity->old_price_adult == floor($relatedActivity->old_price_adult)) ? 0 : 2) }}</del>
                                                @endif
                                                <h5 class="new-price">${{ number_format($relatedActivity->price_adult, ($relatedActivity->price_adult == floor($relatedActivity->price_adult)) ? 0 : 2) }}</h5>
                                             @else
                                                <h5 class="new-price">Inquire</h5>
                                             @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

@endsection

{{-- Scripts Section Push --}}
@push('scripts')
{{-- ✅ 2. Schema.org Structured Data (JSON-LD) --}}
{{-- Outputs the prepared $schemaData array as a valid JSON-LD script. --}}
<script type="application/ld+json">
    @json($schemaData, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
</script>

{{-- Keep existing JS for Smooth Scroll & Accordion --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scroll for inquiry buttons
    const inquiryButtons = document.querySelectorAll('a.scroll-to-form');
    const inquiryFormSection = document.getElementById('review'); // Target the form section

    inquiryButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            if (inquiryFormSection) {
                event.preventDefault();
                inquiryFormSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
                 // Optional: Focus first field after scroll
                 const firstInput = inquiryFormSection.querySelector('input:not([type=hidden]), textarea');
                 if (firstInput) {
                    // Delay allows scroll animation to potentially finish
                    setTimeout(() => firstInput.focus({ preventScroll: true }), 300);
                 }
            }
        });
    });

    // Accordion Expand/Collapse All Button Logic
    document.querySelectorAll('.expand-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const parentSection = this.closest('.content-section');
            if (!parentSection) return;
            const targetAccordion = parentSection.querySelector('.accordion');
            if (!targetAccordion) return;

            const collapseElements = targetAccordion.querySelectorAll('.accordion-collapse');
            const isExpanding = this.textContent.toLowerCase().includes('expand');

            collapseElements.forEach(el => {
                // Ensure Bootstrap's Collapse is loaded
                if (typeof bootstrap !== 'undefined' && bootstrap.Collapse) {
                    const collapseInstance = bootstrap.Collapse.getOrCreateInstance(el);
                    if (collapseInstance) {
                        if (isExpanding) {
                            collapseInstance.show();
                        } else {
                            collapseInstance.hide();
                        }
                    }
                }
            });
            // Toggle button text
            this.textContent = isExpanding ? 'Collapse all' : 'Expand all';
            // Toggle aria-label for better accessibility if needed
            this.setAttribute('aria-label', isExpanding ? 'Collapse all items in this section' : 'Expand all items in this section');
        });
    });
});
</script>

<!-- Flatpickr -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<script>
    document.addEventListener('DOMContentLoaded', function () {
        flatpickr("#act_inq_arrival_date", {
            dateFormat: "Y-m-d",       // Display format to the user
            minDate: "today",          // Disable past dates
            locale: "en"               // Force English
        });
    });
</script>

@endpush