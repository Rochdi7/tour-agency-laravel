@extends('layouts/app')

{{-- Original Page Title (Kept as is) --}}
@section('title', 'Morocco Tours, Excursions, Activities & Car Rentals | Plan Your Trip with Morocco Quest')

{{-- ✅ 1. Meta Description - Added Section --}}
@section('meta_description')
    <meta name="description"
        content="Explore unforgettable Morocco tours & activities with Morocco Quest. Discover top destinations, find curated adventures from Marrakech to the Sahara, and plan your perfect trip. Book online today!">
    {{-- Explanation: This description summarizes the page's core offering (tours, activities in Morocco), mentions key
    concepts (unforgettable, curated adventures, plan trip, book online), includes keywords (Morocco, tours, activities,
    Marrakech, Sahara), and is under 160 characters. It's based on the H1, tour/activity sections, and overall site purpose.
    No dynamic variables were needed here as it describes the general homepage offering. --}}
@endsection

{{-- ✅ 2. Schema.org Structured Data (JSON-LD) - Added Section --}}
@section('structured_data')
    <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "TravelAgency",
          "name": "Morocco Quest",
          "description": "Morocco Quest offers unforgettable tours, activities, and excursions across Morocco. Explore top destinations like Marrakech and the Sahara, find curated adventures, and plan your perfect trip.",
          "url": "{{ url()->current() }}", // Outputs the current page URL
          "image": "{{ asset('assets/img/ait-benhaddou-morocco-travel-hero-banner.jpg') }}", // Uses the main hero image URL. asset() generates the full URL to the image.
          "logo": "{{ asset('assets/img/morocco-quest-logo.png') }}", // Assumed logo path - replace with your actual logo URL. asset() generates the full URL.
          "address": {
            "@type": "PostalAddress",
            "addressLocality": "Marrakech", // Example: Replace with your city
            "addressRegion": "Marrakech-Safi", // Example: Replace with your region
            "addressCountry": "MA" // ISO 3166-1 alpha-2 country code for Morocco
            // "postalCode": "40000", // Example: Add if applicable
            // "streetAddress": "123 Sahara Street" // Example: Add if applicable
          },
          // "telephone": "+212-XXX-XXXXXX", // Example: Add your phone number
          // "email": "contact@moroccoquest.com", // Example: Add your contact email
          "potentialAction": {
            "@type": "SearchAction",
            "target": {
              "@type": "EntryPoint",
              "urlTemplate": "{{ route('search.bar') }}?place={place}&searchDate={searchDate}&guests={guests}" // route() generates the URL for the search action. Placeholders match form fields.
            },
            "query-input": [
              {"@type": "PropertyValueSpecification", "valueName": "place", "valueRequired": true},
              {"@type": "PropertyValueSpecification", "valueName": "searchDate", "valueRequired": false}, // Assuming date might be optional for some searches
              {"@type": "PropertyValueSpecification", "valueName": "guests", "valueRequired": true}
            ]
          },
          "hasOfferCatalog": {
            "@type": "OfferCatalog",
            "name": "Morocco Travel Services",
            "itemListElement": [
              {
                "@type": "OfferCatalog",
                "name": "Morocco Tours",
                "url": "{{ Route::has('tours.index') ? route('tours.index') : url('/tours') }}", // Links to the main tours page. route() generates the URL if the route exists.
                "itemListElement": [
                  @isset($topTours)
                    @foreach($topTours as $tour)
                          {
                            "@type": "Offer",
                            "itemOffered": {
                              "@type": "TouristTrip",
                              "name": "{{ $tour->title }}", // Outputs the specific tour title
                              "url": "{{ route('tours.show', ['slug' => $tour->slug]) }}", // route() generates the URL for this specific tour. $tour->slug is the unique identifier.
                              "description": "{{ Str::limit(strip_tags($tour->description ?? $tour->title), 150) }}", // Basic description, limited. Ensure $tour->description exists or fallback.
                              "tourDuration": "P{{ $tour->duration_days ?? 1 }}D", // ISO 8601 duration format (e.g., P3D for 3 days). $tour->duration_days outputs the number of days.
                              @if ($tour->images->isNotEmpty() && optional($tour->images->first())->image_path)
                                    @php
                                        // Logic to get image URL reused from page for consistency
                                        $tourImageUrlJson = asset('assets/img/tour-packages/tour-placeholder.png');
                                        $imagePathJson = $tour->images->first()->image_path;
                                        if (!filter_var($imagePathJson, FILTER_VALIDATE_URL) && strpos($imagePathJson, 'storage/') === 0) {
                                            $tourImageUrlJson = asset($imagePathJson);
                                        } elseif (!filter_var($imagePathJson, FILTER_VALIDATE_URL) && file_exists(storage_path('app/public/' . ltrim($imagePathJson, '/')))) {
                                            $tourImageUrlJson = asset('storage/' . ltrim($imagePathJson, '/'));
                                        } else {
                                            $tourImageUrlJson = asset($imagePathJson);
                                        }
                                    @endphp
                                  "image": "{{ $tourImageUrlJson }}", // Outputs the tour image URL.
                              @endif
                              "offers": {
                                "@type": "Offer",
                                "price": "{{ $tour->price_adult ?? 0 }}", // Outputs the adult price.
                                "priceCurrency": "USD" // Change if using a different currency
                              }
                            }
                          } {{ !$loop->last ? ',' : '' }}
                    @endforeach
                  @endisset
                ]
              },
              {
                "@type": "OfferCatalog",
                "name": "Morocco Activities",
                "url": "{{ Route::has('activity-categories.index') ? route('activity-categories.index') : url('/activities') }}", // Links to the main activities page. route() generates the URL if the route exists.
                "itemListElement": [
                    @isset($featuredActivities)
                        @foreach($featuredActivities->take(4) as $activity)
                            {
                                "@type": "Offer",
                                "itemOffered": {
                                    "@type": "TouristAttraction", // Or Event, depending on the nature of activities
                                    "name": "{{ $activity->title }}", // Outputs the activity title
                                    @if ($activity->slug && Route::has('activities.show'))
                                        "url": "{{ route('activities.show', $activity->slug) }}", // route() generates the URL. $activity->slug is the identifier.
                                    @endif
                                    "description": "{{ Str::limit(strip_tags($activity->short_description ?? $activity->title), 150) }}", // Uses short description or title.
                                    @php
                                        // Logic to get activity image URL reused from page
                                        $activityImageUrlJson = asset('assets/img/destination/destination-1-1.png');
                                        if ($activity->images && $activity->images->isNotEmpty()) {
                                            $firstImage = $activity->images->first();
                                            if ($firstImage && $firstImage->image) {
                                                $imagePathActJson = $firstImage->image;
                                                if (!filter_var($imagePathActJson, FILTER_VALIDATE_URL) && strpos($imagePathActJson, 'storage/') === 0) {
                                                    $activityImageUrlJson = asset($imagePathActJson);
                                                } elseif (!filter_var($imagePathActJson, FILTER_VALIDATE_URL) && file_exists(storage_path('app/public/' . ltrim($imagePathActJson, '/')))) {
                                                    $activityImageUrlJson = asset('storage/' . ltrim($imagePathActJson, '/'));
                                                } else {
                                                    $activityImageUrlJson = asset($imagePathActJson);
                                                }
                                            }
                                        }
                                    @endphp
                                    "image": "{{ $activityImageUrlJson }}" // Outputs the activity image URL.
                                    // Add price if available: "offers": { "@type": "Offer", "price": "...", "priceCurrency": "USD" }
                                }
                            }{{ !$loop->last ? ',' : '' }}
                        @endforeach
                    @endisset
                ]
              }
            ]
          }
        }
        </script>
@endsection


@section('content')

    <main class="main">

        <section class="z-index-common hero-layout1 overflow-clip"
            data-bg-src="{{ asset('assets/img/ait-benhaddou-morocco-travel-hero-banner.jpg') }}">
            {{-- Alt text added via figcaption/visually-hidden for background context, though CSS backgrounds aren't
            directly indexed as content images --}}
            <figcaption class="visually-hidden">
                A panoramic view of Aït Benhaddou, a UNESCO World Heritage site in Morocco, with its iconic kasbahs under
                desert sunlight, representing Morocco Quest tours.
            </figcaption>
            <p class="visually-hidden" style="display: none;">
                Explore Aït Benhaddou and other iconic Morocco destinations with Morocco Quest. We offer tours focusing on
                culture, history, and adventure in the High Atlas and Sahara Desert.
            </p>

            <div class="container-fluid p-xl-0">
                <div class="row justify-content-center">
                    <div class="col-xl-10 col-xxl-7">
                        <div class="hero-content text-center">
                            {{-- ✅ 3. Lazy Loading Added --}}
                            <img class="fade-anim" data-delay="0.70" src="{{ asset('assets/img/icons/hero-sun.png') }}"
                                alt="Sun icon symbolizing Morocco desert tours" loading="lazy" />

                            <div class="title-area text-center">
                                <span class="sec-subtitle mb-0 fade-anim" data-delay="0.75" data-direction="bottom"
                                    style="color: white !important;">
                                    Crafted for your requests!
                                </span>

                                <h1 class="sec-title text-white-color fade-anim" style="font-size: 75px;" data-delay="0.76"
                                    data-direction="top">
                                    Explore Unforgettable<br class="d-none d-xxl-block" />
                                    Morocco Tours & Activities
                                </h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="search-box fade-anim" data-delay="0.77" data-direction="top">
                <form action="{{ route('search.bar') }}" method="GET" class="align-items-center">
                    <div class="form-group ps-0">
                        <label for="select-location" class="form-label d-flex align-items-center">
                            <i class="fa-sharp fa-light fa-location-dot me-2"></i>
                            Destinations
                        </label>
                        <select id="select-location" name="place" class="form-select" required>
                            <option value="" disabled {{ !request('place') ? 'selected' : '' }} hidden>
                                Select Division
                            </option>
                            @isset($locations)
                                @foreach($locations as $locationName)
                                    <option value="{{ $locationName }}" {{ request('place') == $locationName ? 'selected' : '' }}>
                                        {{ $locationName }}
                                    </option>
                                @endforeach
                            @endisset
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="search-date" class="form-label d-flex align-items-center">
                            <i class="fa-regular fa-calendar-days me-2"></i>
                            Date
                        </label>
                        <input type="text" id="search-date" name="searchDate" class="form-select" placeholder="Date from"
                            value="{{ request('searchDate') }}" readonly />
                    </div>
                    <div class="form-group">
                        <label for="guest-dropdown" class="form-label d-flex align-items-center">
                            <i class="fa-regular fa-user-hoodie me-2"></i> Guest
                        </label>
                        <select id="guest-dropdown" name="guests" class="form-select" required>
                            <option value="" disabled {{ !request('guests') ? 'selected' : '' }} hidden>Select Guests
                            </option>
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ request('guests') == $i ? 'selected' : '' }}>
                                    {{ $i }} Guest{{ $i > 1 ? 's' : '' }}
                                </option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group pe-0">
                        <button type="submit" class="vs-btn style4 w-100">Search Tours</button>
                    </div>
                </form>
            </div>

            {{-- Flatpickr setup remains the same --}}
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
            <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    flatpickr("#search-date", {
                        altInput: true,
                        altFormat: "F j, Y",
                        dateFormat: "Y-m-d",
                        // minDate: "today", // Optional
                    });
                });
            </script>
        </section>

        @if (isset($topTours) && $topTours->count() > 0)
            <section class="vs-tour-package space">
                <div class="container">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-md-6 col-lg-6 col-xxl-5">
                            <div class="title-area text-center text-md-start">
                                <span class="sec-subtitle fade-anim" data-direction="bottom">Top Rated Tours</span>
                                <h2 class="sec-title fade-anim" data-direction="top">
                                    Explore Our Popular Morocco Tours
                                </h2>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6 col-xxl-5">
                            <div class="swiper-arrow2 tour-packages-navigation justify-content-center justify-content-md-end">
                                <button class="tour-packages-next"> <svg width="9" height="18" viewBox="0 0 9 18" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M8.08984 16.92L1.56984 10.4C0.799843 9.62996 0.799843 8.36996 1.56984 7.59996L8.08984 1.07996"
                                            stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg> </button>
                                <button class="tour-packages-prev btn-right"> <svg width="9" height="18" viewBox="0 0 9 18"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M0.910156 16.92L7.43016 10.4C8.20016 9.62996 8.20016 8.36996 7.43016 7.59996L0.910156 1.07996"
                                            stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg> </button>
                            </div>
                        </div>
                        <div class="col-12 mt-30 mt-md-0 fade-anim" data-direction="right">
                            <div class="swiper tour-package-slider">
                                <div class="swiper-wrapper">
                                    @foreach ($topTours as $tour)
                                        <div class="swiper-slide">
                                            <div class="tour-package-box bg-white-color">
                                                <div class="tour-package-thumb">
                                                    @php
                                                        $tourImageUrl = asset('assets/img/tour-packages/tour-placeholder.png');
                                                        if ($tour->images->isNotEmpty() && optional($tour->images->first())->image_path) {
                                                            $imagePath = $tour->images->first()->image_path;
                                                            // Simplified image path logic (ensure storage linking is correct)
                                                            if (!filter_var($imagePath, FILTER_VALIDATE_URL) && strpos($imagePath, 'storage/') === 0) {
                                                                $tourImageUrl = asset($imagePath); // Assumes storage linked
                                                            } elseif (!filter_var($imagePath, FILTER_VALIDATE_URL) && file_exists(storage_path('app/public/' . ltrim($imagePath, '/')))) {
                                                                $tourImageUrl = asset('storage/' . ltrim($imagePath, '/'));
                                                            } else {
                                                                $tourImageUrl = asset($imagePath); // Fallback or external URL
                                                            }
                                                        }
                                                    @endphp
                                                    {{-- ✅ 3. Lazy Loading Added --}}
                                                    <img src="{{ $tourImageUrl }}"
                                                        alt="{{ $tour->title ?: 'Morocco Tour Package' }}" loading="lazy" />
                                                </div>
                                                <div class="tour-package-content">
                                                    <h5 class="title line-clamp-2">
                                                        <a
                                                            href="{{ route('tours.show', ['slug' => $tour->slug]) }}">{{ $tour->title }}</a>
                                                    </h5>
                                                    <div class="pricing-container">
                                                        <div class="package-info">
                                                            <span class="package-location">
                                                                <i class="fa-sharp fa-thin fa-location-dot"></i>
                                                                {{ $tour->location ?? ($tour->departure ?? 'Various Locations') }}
                                                            </span>
                                                            <span class="package-time">
                                                                <i class="fa-sharp fa-thin fa-clock"></i>
                                                                {{ $tour->duration_days ?? 'N/A' }}
                                                                {{ Str::plural('Day', $tour->duration_days ?? 0) }}
                                                            </span>
                                                        </div>
                                                        <div class="price-info">
                                                            @if (isset($tour->discount) && $tour->discount > 0)
                                                                <span class="price-off text-white-color ff-poppins">
                                                                    {{ $tour->discount }}% OFF
                                                                </span>
                                                            @endif
                                                            <div class="price">
                                                                <h6 class="fs-30 ff-rubik">from
                                                                    ${{ number_format($tour->price_adult ?? 0) }}</h6>
                                                                @if (isset($tour->discount) && $tour->discount > 0 && isset($tour->old_price_adult))
                                                                    <del
                                                                        class="fs-sm ff-rubik">${{ number_format($tour->old_price_adult) }}</del>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a href="{{ route('tours.show', ['slug' => $tour->slug]) }}"
                                                        class="vs-btn style7 w-100">Explore Tour Details</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @if (Route::has('tours.index'))
                                <div class="text-center mt-50">
                                    <a href="{{ route('destinations.index') }}" class="vs-btn style4">
                                        <span>View All Morocco Tours</span>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <section class="vs-destination-style1 bg-third-theme-12 overflow-hidden space"
            data-bg-src="{{ asset('assets/img/bg/destination.png') }}">
            {{-- ✅ 3. Lazy Loading Added --}}
            <img class="des-icon-1 animate-parachute" src="{{ asset('assets/img/icons/destination-icon-1.png') }}"
                alt="Hot air balloon icon" loading="lazy" />
            {{-- ✅ 3. Lazy Loading Added --}}
            <img class="des-icon-2 animate-tree" src="{{ asset('assets/img/icons/destination-icon-2.png') }}"
                alt="Palm tree icon" loading="lazy" />
            <div class="container">
                <div class="row">
                    <div class="col-lg-auto mx-auto">
                        <div class="title-area text-center">
                            <span class="sec-subtitle fade-anim" data-direction="top">Top Selections</span>
                            <h2 class="sec-title move-anim">Featured Morocco Activities</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        @isset($featuredActivities)
                            @if ($featuredActivities->count() > 0)
                                <div class="destination-box-wrapper">
                                    @foreach ($featuredActivities->take(4) as $activity)
                                        <div class="destination-box @if ($loop->first) active @endif">
                                            <div class="destination-thumb">
                                                @php
                                                    $activityImageUrl = asset('assets/img/destination/destination-1-1.png'); // Default placeholder
                                                    if ($activity->images && $activity->images->isNotEmpty()) {
                                                        $firstImage = $activity->images->first();
                                                        if ($firstImage && $firstImage->image) {
                                                            $imagePath = $firstImage->image;
                                                            // Simplified logic (ensure storage linking)
                                                            if (!filter_var($imagePath, FILTER_VALIDATE_URL) && strpos($imagePath, 'storage/') === 0) {
                                                                $activityImageUrl = asset($imagePath);
                                                            } elseif (!filter_var($imagePath, FILTER_VALIDATE_URL) && file_exists(storage_path('app/public/' . ltrim($imagePath, '/')))) {
                                                                $activityImageUrl = asset('storage/' . ltrim($imagePath, '/'));
                                                            } else {
                                                                $activityImageUrl = asset($imagePath); // Fallback or external URL
                                                            }
                                                        }
                                                    }
                                                @endphp
                                                {{-- ✅ 3. Lazy Loading Added --}}
                                                <img src="{{ $activityImageUrl }}"
                                                    alt="{{ $activity->title ?: 'Featured Morocco Activity' }}" class="w-100"
                                                    loading="lazy" />
                                            </div>
                                            <div class="destination-content">
                                                <div class="info">
                                                    <h4 class="text-white text-capitalize">
                                                        @if ($activity->slug && Route::has('activities.show'))
                                                            <a href="{{ route('activities.show', $activity->slug) }}">
                                                                {{ $activity->title ?? 'View Activity Details' }}
                                                            </a>
                                                        @else
                                                            {{ $activity->title ?? 'Featured Activity' }}
                                                        @endif
                                                    </h4>
                                                    @if ($activity->category)
                                                        <span
                                                            class="text-theme-color d-block">{{ $activity->category->name ?? 'Exciting Experience' }}</span>
                                                    @elseif($activity->short_description)
                                                        <span
                                                            class="text-theme-color d-block">{{ Str::limit($activity->short_description, 30) }}</span>
                                                    @else
                                                        <span class="text-theme-color d-block">Unique Experience</span>
                                                    @endif
                                                </div>
                                                @if ($activity->slug && Route::has('activities.show'))
                                                    <a href="{{ route('activities.show', $activity->slug) }}"
                                                        class="icon bg-theme-color text-white-color"
                                                        aria-label="View {{ $activity->title ?? 'Activity' }}">
                                                        <i class="fa-solid fa-person-running"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                @if (Route::has('activities.index'))
                                    <div class="text-center mt-50 btn-trigger btn-bounce">
                                        <a href="{{ route('activity-categories.index') }}" class="vs-btn style4">
                                            <span>View More Activities</span>
                                        </a>
                                    </div>
                                @endif
                            @else
                                <p class="text-center lead mt-4 text-white">No featured activities available at the moment.</p>
                            @endif
                        @else
                            <p class="text-center lead mt-4 text-white">Could not load featured activities.</p>
                        @endisset
                    </div>
                </div>
            </div>
        </section>

        <div class="vs-destination-gallery-style1 overflow-hidden">
            <div class="row destination-gallery g-0">
                <div class="col-lg-6 p-0">
                    <figure class="destination-gallery-box h-100">
                        <img src="{{ asset('assets/img/jemaa_el_fna_marrakech_sunset_market.jpg') }}"
                            alt="Jemaa el-Fna square in Marrakech at sunset with market stalls and Koutoubia Mosque"
                            class="w-100 h-100 object-fit-cover" loading="lazy" />

                        <div class="icon-box">
                            <a href="{{ asset('assets/img/jemaa_el_fna_marrakech_sunset_market.jpg') }}"
                                title="Jemaa el-Fna Sunset – Marrakech" class="gallery-thumb">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                        </div>

                        <figcaption class="content">
                            <strong>Marrakech</strong><br>
                            Jemaa el-Fna | Market & Culture
                        </figcaption>

                        <div class="visually-hidden">
                            <strong>Caption:</strong> Sunset over Jemaa el-Fna Square in Marrakech<br>
                            <strong>Description:</strong> A breathtaking sunset view over the famous Jemaa el-Fna square in
                            Marrakech, Morocco.
                            The scene captures the vibrant market atmosphere, with traditional food stalls, street
                            performers, and the
                            Koutoubia Mosque in the background.
                        </div>
                    </figure>
                </div>

                <div class="col-lg-6">
                    <div class="row g-0">
                        <div class="col-sm-6 p-0">
                            <div class="destination-gallery-box h-100">
                                <img src="{{ asset('assets/img/moroccan_traditional_mechoui_evening_firepit.jpg') }}"
                                    alt="Traditional Moroccan Mechoui cooking" class="w-100 h-100 object-fit-cover"
                                    loading="lazy" />

                                <div class="icon-box">
                                    <a href="{{ asset('assets/img/moroccan_traditional_mechoui_evening_firepit.jpg') }}"
                                        title="Mechoui – Moroccan Food" class="gallery-thumb">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                </div>

                                <span class="content">Mechoui | Moroccan Food</span>

                                <div class="visually-hidden">
                                    <strong>Caption:</strong> Traditional Mechoui Preparation<br>
                                    <strong>Description:</strong> A Moroccan chef in traditional attire prepares Mechoui —
                                    slow-roasted lamb — over glowing coals at night. This authentic culinary experience is
                                    part of Moroccan food culture, often offered in desert evenings.
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-6 p-0">
                            <div class="destination-gallery-box h-100">
                                <img src="{{ asset('assets/img/moroccan_pastries_hospitality_serving.jpg') }}"
                                    alt="Moroccan pastries on a silver tray being served during a hospitality event"
                                    class="w-100 h-100 object-fit-cover" loading="lazy" />

                                <div class="icon-box">
                                    <a href="{{ asset('assets/img/moroccan_pastries_hospitality_serving.jpg') }}"
                                        title="Moroccan Pastries – Hospitality" class="gallery-thumb">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                </div>

                                <span class="content">Moroccan Hospitality</span>

                                <div class="visually-hidden">
                                    <strong>Caption:</strong> Moroccan Pastries Being Served<br>
                                    <strong>Description:</strong> A beautifully arranged silver tray with a variety of
                                    traditional Moroccan pastries such as almond cookies, ghriba, and gazelle horns. These
                                    sweets represent Moroccan hospitality and are commonly offered at weddings and guest
                                    receptions.
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-6 p-0">
                            <div class="destination-gallery-box h-100">
                                <img src="{{ asset('assets/img/gnawa_musician_morocco_local_encounter.jpg') }}"
                                    alt="Gnawa musician in traditional red attire playing the guembri inside a Moroccan home"
                                    class="w-100 h-100 object-fit-cover" loading="lazy" />

                                <div class="icon-box">
                                    <a href="{{ asset('assets/img/gnawa_musician_morocco_local_encounter.jpg') }}"
                                        title="Gnawa Musician – Local Encounters" class="gallery-thumb">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                </div>

                                <span class="content">Local Encounters</span>

                                <div class="visually-hidden">
                                    <strong>Caption:</strong> Gnawa Musician in Morocco<br>
                                    <strong>Description:</strong> A traditional Gnawa musician in Morocco dressed in vibrant
                                    red clothing, playing the guembri — a three-stringed bass instrument — in a rustic room.
                                    Gnawa music is a spiritual and cultural heritage passed down through generations,
                                    reflecting the Afro-Moroccan roots and rich storytelling tradition.
                                </div>
                            </div>

                        </div>
                        <div class="col-sm-6 p-0">
                            <div class="destination-gallery-box h-100">
                                <img src="{{ asset('assets/img/souk_experience_morocco_cultural_discoveries.jpg') }}"
                                    alt="Travelers exploring a colorful Moroccan souk filled with traditional leather goods and crafts"
                                    class="w-100 h-100 object-fit-cover" loading="lazy" />

                                <div class="icon-box">
                                    <a href="{{ asset('assets/img/souk_experience_morocco_cultural_discoveries.jpg') }}"
                                        title="Souk Experience – Cultural Discoveries" class="gallery-thumb">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                </div>

                                <span class="content">Cultural Discoveries</span>

                                <div class="visually-hidden">
                                    <strong>Caption:</strong> Souk Experience in Morocco<br>
                                    <strong>Description:</strong> Tourists walking through a vibrant Moroccan souk,
                                    surrounded by handmade leather goods, colorful poufs, and traditional crafts. These
                                    bustling markets are at the heart of Moroccan cultural life, offering a rich sensory and
                                    shopping experience.
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="vs-feature-style1 position-relative bg-theme-color">
            <div class="container">
                <div class="row g-4 align-items-center">
                    <div class="col-md-7 mt-md-0">
                        <h3
                            class="feature-expert text-white-color ff-rubik fw-bold text-center text-md-start char-animation">
                            Need a Morocco Tour Expert?
                        </h3>
                    </div>
                    <div
                        class="col-md-5 mt-md-0 d-flex justify-content-center justify-content-md-end btn-trigger btn-bounce">
                        <a class="vs-btn style-4 bg-second-theme-color" href="{{ route('contact.show') }}#plan">
                            Let's Plan Your Trip
                        </a>
                    </div>
                </div>
                <h2 class="position-absolute text-white-color">Adventures</h2>
            </div>
        </div>

              <!--================= Services Area end =================-->
      <div
        class="vs-services-style1 space bg-second-theme-color"
        data-bg-src="./assets/img/services/vs-services-style1-bg.png"
      >
        <img
          src="./assets/img/icons/cloud.png"
          alt="icon"
          class="vs-services-style1-icon-1 animate-parachute"
        />
        <img
          src="./assets/img/icons/ballon.png"
          alt="icon"
          class="vs-services-style1-icon-2 animate-parachute"
        />
        <div class="container">
          <div class="row g-4 align-items-end">
            <div class="col-md-6 text-center text-md-start">
              <div class="row">
                <div class="col-12 col-xl-11">
                  <div class="title-area text-center text-md-start">
                    <span class="sec-subtitle fade-anim" data-direction="bottom"
                      >our services</span
                    >
                    <h2
                      class="sec-title text-white-color fade-anim"
                      data-direction="top"
                    >
                      It’s Time to <span>Travel</span> with our Company
                    </h2>
                  </div>
                  <a
                    class="vs-btn style-4 fade-anim"
                    data-direction="top"
                    href="destinations.html"
                    >view service</a
                  >
                </div>
              </div>
              <div class="row g-4 pt-120">
                <div class="col-lg-6 fade-anim">
                  <div class="vs-services-box-style1">
                    <figure class="services-thumb">
                      <img
                        src="./assets/img/services/services-thumb-1-3.png"
                        alt="vs-services-thumb"
                        class="w-100"
                      />
                    </figure>
                    <div class="services-content">
                      <div class="services-icon">
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          width="104"
                          height="81"
                          viewBox="0 0 104 81"
                          fill="none"
                        >
                          <path
                            d="M89.0195 24.7886L89.9354 26.6204C92.908 32.5655 97.7287 37.3862 103.674 40.3587H89.0195V24.7886Z"
                            fill="white"
                          />
                          <path
                            d="M14.8281 24.7886L13.9122 26.6204C10.9397 32.5655 6.11901 37.3862 0.173851 40.3587H14.8281V24.7886Z"
                            fill="white"
                          />
                          <circle
                            cx="40.1642"
                            cy="40.1642"
                            r="36.1642"
                            transform="matrix(1 0 0 -1 11.7588 80.3286)"
                            fill="white"
                            stroke="white"
                            stroke-width="8"
                          />
                          <circle
                            cx="53.1844"
                            cy="40.452"
                            r="30.9969"
                            fill="currentColor"
                            stroke="currentColor"
                            stroke-width="1.5"
                            stroke-dasharray="3 3"
                          />
                          <path
                            d="M63.4074 41.097C64.0732 41.097 64.7131 40.9046 65.2774 40.5259C66.2128 39.8936 66.8621 38.7466 66.8873 37.5539C66.9164 36.9476 66.8873 36.3054 66.7988 35.5899C66.7489 35.1805 66.3883 34.8634 65.9237 34.9095C65.1296 35.0117 64.3158 35.3886 63.6374 35.9788C63.6055 35.7147 63.5632 35.4526 63.5107 35.1926C64.2634 34.8198 64.8452 34.2211 65.1461 33.4738C65.5821 32.4277 65.4454 31.1357 64.788 30.1017C64.4222 29.5252 64.0282 28.996 63.6181 28.5272C63.3333 28.2026 62.8416 28.169 62.5155 28.4539C61.8084 29.0717 61.3319 29.9681 61.1372 31.054C60.9612 32.0962 61.0981 32.975 61.4919 33.9272C63.1284 37.8152 61.6255 42.2608 58.221 44.4323C57.98 44.5827 57.7896 44.7906 57.6592 45.0326H54.3349V41.8382L57.087 43.2671C57.356 43.4061 57.6732 43.3761 57.9071 43.2052C58.1468 43.0311 58.2675 42.7372 58.2187 42.4447L57.5658 38.5166L60.4026 35.7226C60.6134 35.5149 60.6889 35.2056 60.5973 34.9246C60.5057 34.6428 60.2628 34.4367 59.9704 34.3924L56.0516 33.8023L54.2655 29.8536C54.012 29.2932 53.0941 29.2932 52.8406 29.8536L51.0545 33.8023L47.1356 34.3925C46.8432 34.4368 46.6003 34.643 46.5087 34.9248C46.4171 35.2058 46.4927 35.515 46.7034 35.7227L49.5402 38.5168L48.8874 42.4448C48.8385 42.7373 48.9591 43.0313 49.1989 43.2054C49.4387 43.3795 49.7548 43.4032 50.019 43.2673L52.7711 41.8383V45.0327H49.4223C49.1327 44.5473 48.6903 44.3272 48.2759 44.0033C46.0797 42.2272 44.967 39.6693 44.967 37.2133C44.967 34.0911 46.4084 33.5954 45.9819 31.0449C45.7872 29.9674 45.3114 29.0717 44.6051 28.454C44.2821 28.1699 43.7857 28.202 43.5024 28.5273C43.0893 28.9992 42.6953 29.5291 42.3326 30.1011C41.6752 31.135 41.5369 32.427 41.9699 33.4655C42.2739 34.2197 42.8571 34.82 43.6105 35.1932C43.5579 35.4533 43.5158 35.7156 43.4838 35.9799C42.8032 35.3887 41.9754 35.0117 41.1821 34.9095C40.976 34.8874 40.7667 34.9401 40.6026 35.0684C40.4384 35.1959 40.3315 35.3845 40.307 35.5907C40.2192 36.307 40.191 36.9499 40.2177 37.541C40.2505 38.7772 40.9229 39.9272 41.85 40.532C42.3929 40.9062 43.0351 41.0978 43.7063 41.0978C43.8628 41.0978 44.0218 41.0789 44.1807 41.0579C44.2797 41.2995 44.3788 41.5405 44.4957 41.7739C43.7922 41.683 42.9123 41.7052 42.0508 42.1325C41.6534 42.3296 41.5024 42.8133 41.7056 43.1978C41.9798 43.7193 42.3066 44.3218 42.6952 44.8479C43.3576 45.8148 44.447 46.4798 45.7336 46.4798C46.512 46.4798 47.2603 46.1815 47.8777 45.6461C47.9735 45.7145 48.0635 45.7817 48.0794 45.8147V51.2882H47.2975C46.8653 51.2882 46.5156 51.638 46.5156 52.0702C46.5156 52.5024 46.8653 52.8521 47.2975 52.8521H59.8084C60.2406 52.8521 60.5904 52.5024 60.5904 52.0702C60.5904 51.638 60.2406 51.2882 59.8084 51.2882H59.0265V45.8987C59.0359 45.8502 59.0563 45.8047 59.0563 45.7543C59.1173 45.7153 59.17 45.6675 59.2299 45.6275C60.8568 47.0626 63.1599 46.6219 64.4435 44.8525C64.8103 44.2942 65.1681 43.7628 65.4446 43.1626C65.6218 42.7786 65.4607 42.3227 65.0811 42.1348C64.3675 41.7814 63.5574 41.6776 62.622 41.7924C62.7432 41.5518 62.8627 41.3101 62.9644 41.0599C63.1128 41.0785 63.2611 41.097 63.4074 41.097ZM55.1169 49.7243H51.9891C51.5569 49.7243 51.2072 49.3745 51.2072 48.9423C51.2072 48.5101 51.5569 48.1604 51.9891 48.1604H55.1169C55.5491 48.1604 55.8988 48.5101 55.8988 48.9423C55.8988 49.3745 55.5491 49.7243 55.1169 49.7243Z"
                            fill="white"
                          />
                        </svg>
                      </div>
                      <div class="services-content-inner">
                        <h5 class="services-title">
                          <a href="destination-details.html">Support 24/7</a>
                        </h5>
                        <p class="fs-16 fw-medium">
                          Lorem ipsum dolor sits ameter consecte adipiscing
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 fade-anim">
                  <div class="vs-services-box-style1">
                    <figure class="services-thumb">
                      <img
                        src="./assets/img/services/services-thumb-1-4.png"
                        alt="vs-services-thumb"
                        class="w-100"
                      />
                    </figure>
                    <div class="services-content">
                      <div class="services-icon">
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          width="104"
                          height="81"
                          viewBox="0 0 104 81"
                          fill="none"
                        >
                          <path
                            d="M89.0195 24.7886L89.9354 26.6204C92.908 32.5655 97.7287 37.3862 103.674 40.3587H89.0195V24.7886Z"
                            fill="white"
                          />
                          <path
                            d="M14.8281 24.7886L13.9122 26.6204C10.9397 32.5655 6.11901 37.3862 0.173851 40.3587H14.8281V24.7886Z"
                            fill="white"
                          />
                          <circle
                            cx="40.1642"
                            cy="40.1642"
                            r="36.1642"
                            transform="matrix(1 0 0 -1 11.7588 80.3286)"
                            fill="white"
                            stroke="white"
                            stroke-width="8"
                          />
                          <circle
                            cx="53.1844"
                            cy="40.452"
                            r="30.9969"
                            fill="currentColor"
                            stroke="currentColor"
                            stroke-width="1.5"
                            stroke-dasharray="3 3"
                          />
                          <path
                            d="M63.4074 41.097C64.0732 41.097 64.7131 40.9046 65.2774 40.5259C66.2128 39.8936 66.8621 38.7466 66.8873 37.5539C66.9164 36.9476 66.8873 36.3054 66.7988 35.5899C66.7489 35.1805 66.3883 34.8634 65.9237 34.9095C65.1296 35.0117 64.3158 35.3886 63.6374 35.9788C63.6055 35.7147 63.5632 35.4526 63.5107 35.1926C64.2634 34.8198 64.8452 34.2211 65.1461 33.4738C65.5821 32.4277 65.4454 31.1357 64.788 30.1017C64.4222 29.5252 64.0282 28.996 63.6181 28.5272C63.3333 28.2026 62.8416 28.169 62.5155 28.4539C61.8084 29.0717 61.3319 29.9681 61.1372 31.054C60.9612 32.0962 61.0981 32.975 61.4919 33.9272C63.1284 37.8152 61.6255 42.2608 58.221 44.4323C57.98 44.5827 57.7896 44.7906 57.6592 45.0326H54.3349V41.8382L57.087 43.2671C57.356 43.4061 57.6732 43.3761 57.9071 43.2052C58.1468 43.0311 58.2675 42.7372 58.2187 42.4447L57.5658 38.5166L60.4026 35.7226C60.6134 35.5149 60.6889 35.2056 60.5973 34.9246C60.5057 34.6428 60.2628 34.4367 59.9704 34.3924L56.0516 33.8023L54.2655 29.8536C54.012 29.2932 53.0941 29.2932 52.8406 29.8536L51.0545 33.8023L47.1356 34.3925C46.8432 34.4368 46.6003 34.643 46.5087 34.9248C46.4171 35.2058 46.4927 35.515 46.7034 35.7227L49.5402 38.5168L48.8874 42.4448C48.8385 42.7373 48.9591 43.0313 49.1989 43.2054C49.4387 43.3795 49.7548 43.4032 50.019 43.2673L52.7711 41.8383V45.0327H49.4223C49.1327 44.5473 48.6903 44.3272 48.2759 44.0033C46.0797 42.2272 44.967 39.6693 44.967 37.2133C44.967 34.0911 46.4084 33.5954 45.9819 31.0449C45.7872 29.9674 45.3114 29.0717 44.6051 28.454C44.2821 28.1699 43.7857 28.202 43.5024 28.5273C43.0893 28.9992 42.6953 29.5291 42.3326 30.1011C41.6752 31.135 41.5369 32.427 41.9699 33.4655C42.2739 34.2197 42.8571 34.82 43.6105 35.1932C43.5579 35.4533 43.5158 35.7156 43.4838 35.9799C42.8032 35.3887 41.9754 35.0117 41.1821 34.9095C40.976 34.8874 40.7667 34.9401 40.6026 35.0684C40.4384 35.1959 40.3315 35.3845 40.307 35.5907C40.2192 36.307 40.191 36.9499 40.2177 37.541C40.2505 38.7772 40.9229 39.9272 41.85 40.532C42.3929 40.9062 43.0351 41.0978 43.7063 41.0978C43.8628 41.0978 44.0218 41.0789 44.1807 41.0579C44.2797 41.2995 44.3788 41.5405 44.4957 41.7739C43.7922 41.683 42.9123 41.7052 42.0508 42.1325C41.6534 42.3296 41.5024 42.8133 41.7056 43.1978C41.9798 43.7193 42.3066 44.3218 42.6952 44.8479C43.3576 45.8148 44.447 46.4798 45.7336 46.4798C46.512 46.4798 47.2603 46.1815 47.8777 45.6461C47.9735 45.7145 48.0635 45.7817 48.0794 45.8147V51.2882H47.2975C46.8653 51.2882 46.5156 51.638 46.5156 52.0702C46.5156 52.5024 46.8653 52.8521 47.2975 52.8521H59.8084C60.2406 52.8521 60.5904 52.5024 60.5904 52.0702C60.5904 51.638 60.2406 51.2882 59.8084 51.2882H59.0265V45.8987C59.0359 45.8502 59.0563 45.8047 59.0563 45.7543C59.1173 45.7153 59.17 45.6675 59.2299 45.6275C60.8568 47.0626 63.1599 46.6219 64.4435 44.8525C64.8103 44.2942 65.1681 43.7628 65.4446 43.1626C65.6218 42.7786 65.4607 42.3227 65.0811 42.1348C64.3675 41.7814 63.5574 41.6776 62.622 41.7924C62.7432 41.5518 62.8627 41.3101 62.9644 41.0599C63.1128 41.0785 63.2611 41.097 63.4074 41.097ZM55.1169 49.7243H51.9891C51.5569 49.7243 51.2072 49.3745 51.2072 48.9423C51.2072 48.5101 51.5569 48.1604 51.9891 48.1604H55.1169C55.5491 48.1604 55.8988 48.5101 55.8988 48.9423C55.8988 49.3745 55.5491 49.7243 55.1169 49.7243Z"
                            fill="white"
                          />
                        </svg>
                      </div>
                      <div class="services-content-inner">
                        <h5 class="services-title">
                          <a href="destination-details.html">Fast Booking</a>
                        </h5>
                        <p class="fs-16 fw-medium">
                          Lorem ipsum dolor sits ameter consecte adipiscing
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="row g-4">
                <div class="col-lg-6 fade-anim">
                  <div class="vs-services-box-style1">
                    <figure class="services-thumb">
                      <img
                        src="./assets/img/services/services-thumb-1-1.png"
                        alt="vs-services-thumb"
                        class="w-100"
                      />
                    </figure>
                    <div class="services-content">
                      <div class="services-icon">
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          width="104"
                          height="81"
                          viewBox="0 0 104 81"
                          fill="none"
                        >
                          <path
                            d="M89.0195 24.7886L89.9354 26.6204C92.908 32.5655 97.7287 37.3862 103.674 40.3587H89.0195V24.7886Z"
                            fill="white"
                          />
                          <path
                            d="M14.8281 24.7886L13.9122 26.6204C10.9397 32.5655 6.11901 37.3862 0.173851 40.3587H14.8281V24.7886Z"
                            fill="white"
                          />
                          <circle
                            cx="40.1642"
                            cy="40.1642"
                            r="36.1642"
                            transform="matrix(1 0 0 -1 11.7588 80.3286)"
                            fill="white"
                            stroke="white"
                            stroke-width="8"
                          />
                          <circle
                            cx="53.1844"
                            cy="40.452"
                            r="30.9969"
                            fill="currentColor"
                            stroke="currentColor"
                            stroke-width="1.5"
                            stroke-dasharray="3 3"
                          />
                          <path
                            d="M63.4074 41.097C64.0732 41.097 64.7131 40.9046 65.2774 40.5259C66.2128 39.8936 66.8621 38.7466 66.8873 37.5539C66.9164 36.9476 66.8873 36.3054 66.7988 35.5899C66.7489 35.1805 66.3883 34.8634 65.9237 34.9095C65.1296 35.0117 64.3158 35.3886 63.6374 35.9788C63.6055 35.7147 63.5632 35.4526 63.5107 35.1926C64.2634 34.8198 64.8452 34.2211 65.1461 33.4738C65.5821 32.4277 65.4454 31.1357 64.788 30.1017C64.4222 29.5252 64.0282 28.996 63.6181 28.5272C63.3333 28.2026 62.8416 28.169 62.5155 28.4539C61.8084 29.0717 61.3319 29.9681 61.1372 31.054C60.9612 32.0962 61.0981 32.975 61.4919 33.9272C63.1284 37.8152 61.6255 42.2608 58.221 44.4323C57.98 44.5827 57.7896 44.7906 57.6592 45.0326H54.3349V41.8382L57.087 43.2671C57.356 43.4061 57.6732 43.3761 57.9071 43.2052C58.1468 43.0311 58.2675 42.7372 58.2187 42.4447L57.5658 38.5166L60.4026 35.7226C60.6134 35.5149 60.6889 35.2056 60.5973 34.9246C60.5057 34.6428 60.2628 34.4367 59.9704 34.3924L56.0516 33.8023L54.2655 29.8536C54.012 29.2932 53.0941 29.2932 52.8406 29.8536L51.0545 33.8023L47.1356 34.3925C46.8432 34.4368 46.6003 34.643 46.5087 34.9248C46.4171 35.2058 46.4927 35.515 46.7034 35.7227L49.5402 38.5168L48.8874 42.4448C48.8385 42.7373 48.9591 43.0313 49.1989 43.2054C49.4387 43.3795 49.7548 43.4032 50.019 43.2673L52.7711 41.8383V45.0327H49.4223C49.1327 44.5473 48.6903 44.3272 48.2759 44.0033C46.0797 42.2272 44.967 39.6693 44.967 37.2133C44.967 34.0911 46.4084 33.5954 45.9819 31.0449C45.7872 29.9674 45.3114 29.0717 44.6051 28.454C44.2821 28.1699 43.7857 28.202 43.5024 28.5273C43.0893 28.9992 42.6953 29.5291 42.3326 30.1011C41.6752 31.135 41.5369 32.427 41.9699 33.4655C42.2739 34.2197 42.8571 34.82 43.6105 35.1932C43.5579 35.4533 43.5158 35.7156 43.4838 35.9799C42.8032 35.3887 41.9754 35.0117 41.1821 34.9095C40.976 34.8874 40.7667 34.9401 40.6026 35.0684C40.4384 35.1959 40.3315 35.3845 40.307 35.5907C40.2192 36.307 40.191 36.9499 40.2177 37.541C40.2505 38.7772 40.9229 39.9272 41.85 40.532C42.3929 40.9062 43.0351 41.0978 43.7063 41.0978C43.8628 41.0978 44.0218 41.0789 44.1807 41.0579C44.2797 41.2995 44.3788 41.5405 44.4957 41.7739C43.7922 41.683 42.9123 41.7052 42.0508 42.1325C41.6534 42.3296 41.5024 42.8133 41.7056 43.1978C41.9798 43.7193 42.3066 44.3218 42.6952 44.8479C43.3576 45.8148 44.447 46.4798 45.7336 46.4798C46.512 46.4798 47.2603 46.1815 47.8777 45.6461C47.9735 45.7145 48.0635 45.7817 48.0794 45.8147V51.2882H47.2975C46.8653 51.2882 46.5156 51.638 46.5156 52.0702C46.5156 52.5024 46.8653 52.8521 47.2975 52.8521H59.8084C60.2406 52.8521 60.5904 52.5024 60.5904 52.0702C60.5904 51.638 60.2406 51.2882 59.8084 51.2882H59.0265V45.8987C59.0359 45.8502 59.0563 45.8047 59.0563 45.7543C59.1173 45.7153 59.17 45.6675 59.2299 45.6275C60.8568 47.0626 63.1599 46.6219 64.4435 44.8525C64.8103 44.2942 65.1681 43.7628 65.4446 43.1626C65.6218 42.7786 65.4607 42.3227 65.0811 42.1348C64.3675 41.7814 63.5574 41.6776 62.622 41.7924C62.7432 41.5518 62.8627 41.3101 62.9644 41.0599C63.1128 41.0785 63.2611 41.097 63.4074 41.097ZM55.1169 49.7243H51.9891C51.5569 49.7243 51.2072 49.3745 51.2072 48.9423C51.2072 48.5101 51.5569 48.1604 51.9891 48.1604H55.1169C55.5491 48.1604 55.8988 48.5101 55.8988 48.9423C55.8988 49.3745 55.5491 49.7243 55.1169 49.7243Z"
                            fill="white"
                          />
                        </svg>
                      </div>
                      <div class="services-content-inner">
                        <h5 class="services-title">
                          <a href="destination-details.html">Adventures</a>
                        </h5>
                        <p class="fs-16 fw-medium">
                          Lorem ipsum dolor sits ameter consecte adipiscing
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 fade-anim">
                  <div class="vs-services-box-style1">
                    <figure class="services-thumb">
                      <img
                        src="./assets/img/services/services-thumb-1-2.png"
                        alt="vs-services-thumb"
                        class="w-100"
                      />
                    </figure>
                    <div class="services-content">
                      <div class="services-icon">
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          width="104"
                          height="81"
                          viewBox="0 0 104 81"
                          fill="none"
                        >
                          <path
                            d="M89.0195 24.7886L89.9354 26.6204C92.908 32.5655 97.7287 37.3862 103.674 40.3587H89.0195V24.7886Z"
                            fill="white"
                          />
                          <path
                            d="M14.8281 24.7886L13.9122 26.6204C10.9397 32.5655 6.11901 37.3862 0.173851 40.3587H14.8281V24.7886Z"
                            fill="white"
                          />
                          <circle
                            cx="40.1642"
                            cy="40.1642"
                            r="36.1642"
                            transform="matrix(1 0 0 -1 11.7588 80.3286)"
                            fill="white"
                            stroke="white"
                            stroke-width="8"
                          />
                          <circle
                            cx="53.1844"
                            cy="40.452"
                            r="30.9969"
                            fill="currentColor"
                            stroke="currentColor"
                            stroke-width="1.5"
                            stroke-dasharray="3 3"
                          />
                          <path
                            d="M63.4074 41.097C64.0732 41.097 64.7131 40.9046 65.2774 40.5259C66.2128 39.8936 66.8621 38.7466 66.8873 37.5539C66.9164 36.9476 66.8873 36.3054 66.7988 35.5899C66.7489 35.1805 66.3883 34.8634 65.9237 34.9095C65.1296 35.0117 64.3158 35.3886 63.6374 35.9788C63.6055 35.7147 63.5632 35.4526 63.5107 35.1926C64.2634 34.8198 64.8452 34.2211 65.1461 33.4738C65.5821 32.4277 65.4454 31.1357 64.788 30.1017C64.4222 29.5252 64.0282 28.996 63.6181 28.5272C63.3333 28.2026 62.8416 28.169 62.5155 28.4539C61.8084 29.0717 61.3319 29.9681 61.1372 31.054C60.9612 32.0962 61.0981 32.975 61.4919 33.9272C63.1284 37.8152 61.6255 42.2608 58.221 44.4323C57.98 44.5827 57.7896 44.7906 57.6592 45.0326H54.3349V41.8382L57.087 43.2671C57.356 43.4061 57.6732 43.3761 57.9071 43.2052C58.1468 43.0311 58.2675 42.7372 58.2187 42.4447L57.5658 38.5166L60.4026 35.7226C60.6134 35.5149 60.6889 35.2056 60.5973 34.9246C60.5057 34.6428 60.2628 34.4367 59.9704 34.3924L56.0516 33.8023L54.2655 29.8536C54.012 29.2932 53.0941 29.2932 52.8406 29.8536L51.0545 33.8023L47.1356 34.3925C46.8432 34.4368 46.6003 34.643 46.5087 34.9248C46.4171 35.2058 46.4927 35.515 46.7034 35.7227L49.5402 38.5168L48.8874 42.4448C48.8385 42.7373 48.9591 43.0313 49.1989 43.2054C49.4387 43.3795 49.7548 43.4032 50.019 43.2673L52.7711 41.8383V45.0327H49.4223C49.1327 44.5473 48.6903 44.3272 48.2759 44.0033C46.0797 42.2272 44.967 39.6693 44.967 37.2133C44.967 34.0911 46.4084 33.5954 45.9819 31.0449C45.7872 29.9674 45.3114 29.0717 44.6051 28.454C44.2821 28.1699 43.7857 28.202 43.5024 28.5273C43.0893 28.9992 42.6953 29.5291 42.3326 30.1011C41.6752 31.135 41.5369 32.427 41.9699 33.4655C42.2739 34.2197 42.8571 34.82 43.6105 35.1932C43.5579 35.4533 43.5158 35.7156 43.4838 35.9799C42.8032 35.3887 41.9754 35.0117 41.1821 34.9095C40.976 34.8874 40.7667 34.9401 40.6026 35.0684C40.4384 35.1959 40.3315 35.3845 40.307 35.5907C40.2192 36.307 40.191 36.9499 40.2177 37.541C40.2505 38.7772 40.9229 39.9272 41.85 40.532C42.3929 40.9062 43.0351 41.0978 43.7063 41.0978C43.8628 41.0978 44.0218 41.0789 44.1807 41.0579C44.2797 41.2995 44.3788 41.5405 44.4957 41.7739C43.7922 41.683 42.9123 41.7052 42.0508 42.1325C41.6534 42.3296 41.5024 42.8133 41.7056 43.1978C41.9798 43.7193 42.3066 44.3218 42.6952 44.8479C43.3576 45.8148 44.447 46.4798 45.7336 46.4798C46.512 46.4798 47.2603 46.1815 47.8777 45.6461C47.9735 45.7145 48.0635 45.7817 48.0794 45.8147V51.2882H47.2975C46.8653 51.2882 46.5156 51.638 46.5156 52.0702C46.5156 52.5024 46.8653 52.8521 47.2975 52.8521H59.8084C60.2406 52.8521 60.5904 52.5024 60.5904 52.0702C60.5904 51.638 60.2406 51.2882 59.8084 51.2882H59.0265V45.8987C59.0359 45.8502 59.0563 45.8047 59.0563 45.7543C59.1173 45.7153 59.17 45.6675 59.2299 45.6275C60.8568 47.0626 63.1599 46.6219 64.4435 44.8525C64.8103 44.2942 65.1681 43.7628 65.4446 43.1626C65.6218 42.7786 65.4607 42.3227 65.0811 42.1348C64.3675 41.7814 63.5574 41.6776 62.622 41.7924C62.7432 41.5518 62.8627 41.3101 62.9644 41.0599C63.1128 41.0785 63.2611 41.097 63.4074 41.097ZM55.1169 49.7243H51.9891C51.5569 49.7243 51.2072 49.3745 51.2072 48.9423C51.2072 48.5101 51.5569 48.1604 51.9891 48.1604H55.1169C55.5491 48.1604 55.8988 48.5101 55.8988 48.9423C55.8988 49.3745 55.5491 49.7243 55.1169 49.7243Z"
                            fill="white"
                          />
                        </svg>
                      </div>
                      <div class="services-content-inner">
                        <h5 class="services-title">
                          <a href="destination-details.html">Travel Guide</a>
                        </h5>
                        <p class="fs-16 fw-medium">
                          Lorem ipsum dolor sits ameter consecte adipiscing
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-12 fade-anim">
                  <div class="vs-services-box-style1 v2">
                    <div class="title-area text-center text-md-start">
                      <span class="sec-subtitle text-white-color"
                        >client feedback</span
                      >
                      <h4 class="sec-title text-white-color">
                        It’s Time to Travel with our Company
                      </h4>
                    </div>
                    <div
                      class="services-content d-flex align-items-center gap-3"
                    >
                      <img
                        src="./assets/img/services/vs-services-box-style1-v2-avatars.png"
                        alt="avatars"
                      />
                      <div class="services-info">
                        <span class="fs-16 text-white-color text-uppercase"
                          >Satisfied Client Rating</span
                        >
                        <div class="ratings">
                          <ul class="custom-ul d-flex">
                            <li><i class="fa-solid fa-star"></i></li>
                            <li><i class="fa-solid fa-star"></i></li>
                            <li><i class="fa-solid fa-star"></i></li>
                            <li><i class="fa-solid fa-star"></i></li>
                            <li><i class="fa-solid fa-star"></i></li>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <img
                      src="./assets/img/icons/eiffel-tower.png"
                      alt="eiffel-tower"
                      class="eiffel-tower"
                    />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--================= Services Area end =================-->
<!--================= Awards Area start =================-->
<section
  class="awards-style1 space"
  data-bg-src="assets/img/awards/awards-style1-bg.png"
>
  <img
    class="awards-icon-1"
    src="./assets/img/icons/award-icon-1.png"
    alt="icon"
  />
  <img
    class="awards-icon-2 move-item"
    src="./assets/img/icons/award-icon-2.png"
    alt="icon"
  />
  <div class="container">
    <div class="row justify-content-between align-items-center">
      <div class="col-md-6 col-lg-6 col-xxl-5">
        <div class="title-area text-center text-md-start">
          <span class="sec-subtitle fade-anim" data-direction="bottom"
            >Discover Organized</span
          >
          <h2 class="sec-title fade-anim" data-direction="top">
            Tours and Adventures our awards
          </h2>
        </div>
      </div>
      <div class="col-md-6 col-lg-5 col-xxl-5">
        <div class="google-reviewed mx-auto overflow-hidden">
          <div
            class="left bg-white-color d-flex align-items-center gap-2"
          >
            <img
              src="./assets/img/icons/awards-google.png"
              alt="google"
            />
            <div class="info">
              <strong class="d-block">Google</strong>
              <span class="d-block fs-xxs text-uppercase"
                >Reviewed by</span
              >
            </div>
          </div>
          <div class="right bg-second-theme-color">
            <div class="rating d-flex align-items-baseline gap-2">
              <h4 class="fs-32 fw-semibold ff-rubik text-white-color">
                4.5
              </h4>
              <div class="stars">
                <ul
                  class="custom-ul d-flex align-items-center text-theme-color fs-xxs"
                >
                  <li><i class="fa-solid fa-star"></i></li>
                  <li><i class="fa-solid fa-star"></i></li>
                  <li><i class="fa-solid fa-star"></i></li>
                  <li><i class="fa-solid fa-star"></i></li>
                  <li><i class="fa-solid fa-star"></i></li>
                </ul>
              </div>
            </div>
            <span class="review fs-xxs d-block">8.5k reviews</span>
          </div>
        </div>
      </div>
    </div>
    <div class="row g-2 g-lg-4 award-box-style1__row">
      <div class="line-Shape"></div>
      <!-- Award Box 1: Tripadvisor -->
      <div
        class="col-md-6 col-lg-4 fade-anim"
        data-delay="0.30"
        data-direction="right"
      >
      <div class="award-box-style1">
  <div class="award-box-style1-wrapper">
  <figure class="award-box-icon small-award-icon">
  <svg viewBox="0 -96 512.2 512.2" xmlns="http://www.w3.org/2000/svg" fill="#08808a">
    <style>.st0{fill:#08808a}</style>
    <path class="st0" d="M128.2 127.9C92.7 127.9 64 156.6 64 192c0 35.4 28.7 64.1 64.1 64.1 35.4 0 64.1-28.7 64.1-64.1.1-35.4-28.6-64.1-64-64.1zm0 110c-25.3 0-45.9-20.5-45.9-45.9s20.5-45.9 45.9-45.9S174 166.7 174 192s-20.5 45.9-45.8 45.9z"/>
    <circle class="st0" cx="128.4" cy="191.9" r="31.9"/>
    <path class="st0" d="M384.2 127.9c-35.4 0-64.1 28.7-64.1 64.1 0 35.4 28.7 64.1 64.1 64.1 35.4 0 64.1-28.7 64.1-64.1 0-35.4-28.7-64.1-64.1-64.1zm0 110c-25.3 0-45.9-20.5-45.9-45.9s20.5-45.9 45.9-45.9S430 166.7 430 192s-20.5 45.9-45.8 45.9z"/>
    <circle class="st0" cx="384.4" cy="191.9" r="31.9"/>
    <path class="st0" d="M474.4 101.2l37.7-37.4h-76.4C392.9 29 321.8 0 255.9 0c-66 0-136.5 29-179.3 63.8H0l37.7 37.4C14.4 124.4 0 156.5 0 192c0 70.8 57.4 128.2 128.2 128.2 32.5 0 62.2-12.1 84.8-32.1l43.4 31.9 42.9-31.2-.5-1.2c22.7 20.2 52.5 32.5 85.3 32.5 70.8 0 128.2-57.4 128.2-128.2-.1-35.4-14.6-67.5-37.9-90.7zM368 64.8c-60.7 7.6-108.3 57.6-111.9 119.5-3.7-62-51.4-112.1-112.3-119.5 30.6-22 69.6-32.8 112.1-32.8S337.4 42.8 368 64.8zM128.2 288.2C75 288.2 32 245.1 32 192s43.1-96.2 96.2-96.2 96.2 43.1 96.2 96.2c-.1 53.1-43.1 96.2-96.2 96.2zm256 0c-53.1 0-96.2-43.1-96.2-96.2s43.1-96.2 96.2-96.2 96.2 43.1 96.2 96.2c-.1 53.1-43.1 96.2-96.2 96.2z"/>
  </svg>
</figure>

<style>
    .small-award-icon svg {
  width: 80px;
  height: auto;
  display: block;
  margin: 0 auto;
}

</style>
    <div class="award-box-header d-flex align-items-end justify-content-between gap-xl-4 text-center">
      <img
        src="./assets/img/awards/award-box-left-wings.png"
        alt="award-box-left-wings"
      />
      <h6 class="text-capitalize ff-rubik fw-semibold">
        world travelers Award
      </h6>
      <img
        src="./assets/img/awards/award-box-right-wings.png"
        alt="award-box-right-wings"
      />
    </div>
    <div class="award-box-body text-center">
      <span class="text-third-theme-color bg-white-color">world travel</span>
    </div>
    <div class="award-box-footer text-capitalize text-center">
      <p class="line1">
        recived in happy award in <strong>2022</strong>
      </p>
    </div>
  </div>
</div>

      </div>
      <!-- Award Box 2: Condé Nast -->
      <div
        class="col-md-6 col-lg-4 fade-anim"
        data-delay="0.45"
        data-direction="right"
      >
        <div class="award-box-style1">
          <div class="award-box-style1-wrapper">
            <figure class="award-box-icon text-center">
              <!-- Replaced SVG with IMG -->
              <img
                src="./assets/img/awards/conde-nast-2024.png"  alt="Condé Nast Traveler Readers Choice Award 2024"
                class="award-logo-image"
              />
            </figure>
            <div
              class="award-box-header d-flex align-items-end justify-content-between gap-xl-4 text-center"
            >
              <img
                src="./assets/img/awards/award-box-left-wings.png"
                alt="award-box-left-wings"
              />
              <h6 class="text-capitalize ff-rubik fw-semibold">
                Condé Nast Readers' Choice
              </h6>
              <img
                src="./assets/img/awards/award-box-right-wings.png"
                alt="award-box-right-wings"
              />
            </div>
            <div class="award-box-body text-center">
              <span class="text-third-theme-color bg-white-color"
                >Condé Nast</span
              >
            </div>
            <div class="award-box-footer text-capitalize text-center">
              <p class="line1">
                Received Readers' Choice Award in <strong>2024</strong>
              </p>
            </div>
          </div>
        </div>
      </div>
      <!-- Award Box 3: IAGTO -->
      <div
        class="col-md-6 col-lg-4 fade-anim"
        data-delay="0.60"
        data-direction="right"
      >
        <div class="award-box-style1">
          <div class="award-box-style1-wrapper">
            <figure class="award-box-icon text-center">
              <!-- Replaced SVG with IMG -->
              <img
                src="./assets/img/awards/iagto-2025.png"  alt="IAGTO Award 2025"
                class="award-logo-image"
              />
            </figure>
            <div
              class="award-box-header d-flex align-items-end justify-content-between gap-xl-4 text-center"
            >
              <img
                src="./assets/img/awards/award-box-left-wings.png"
                alt="award-box-left-wings"
              />
              <h6 class="text-capitalize ff-rubik fw-semibold">
                IAGTO Award
              </h6>
              <img
                src="./assets/img/awards/award-box-right-wings.png"
                alt="award-box-right-wings"
              />
            </div>
            <div class="award-box-body text-center">
              <span class="text-third-theme-color bg-white-color"
                >IAGTO</span
              >
            </div>
            <div class="award-box-footer text-capitalize text-center">
              <p class="line1">
                Recognized by IAGTO Awards <strong>2025</strong>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--================= Awards Area end =================-->

        <section class="blog-style1 space-top space-extra-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-lg-auto mx-auto">
                        <div class="title-area text-center">
                            <span class="sec-subtitle fade-anim" data-direction="bottom">Blog & Articles</span>
                            <h2 class="sec-title fade-anim" data-direction="top">Latest Morocco Travel News</h2>
                        </div>
                    </div>
                </div>

                <div class="row g-4">
                    @isset($latestPosts) {{-- Check if $latestPosts is set --}}
                        @forelse ($latestPosts as $post) {{-- Use forelse for empty check --}}
                            <div class="col-md-6 col-lg-4 move-anim">
                                <div class="vs-blog-box style1">
                                    <figure class="blog-thumb">
                                        <a href="{{ route('blog.show', $post->slug) }}">
                                            {{-- ✅ 3. Lazy Loading Added --}}
                                            <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}"
                                                class="w-100" loading="lazy" />
                                        </a>
                                    </figure>

                                    <div class="blog-content">
                                        <div class="blog-meta">
                                            <ul class="custom-ul">
                                                <li><a href="#"><i class="fa-sharp fa-solid fa-circle-user"></i> by
                                                        {{ $post->written_by ?? 'Admin' }}</a></li> {{-- Added fallback for
                                                written_by --}}
                                                <li><a href="{{ route('blog.show', $post->slug) }}#comments"><i
                                                            class="fa-sharp fa-solid fa-comments"></i>
                                                        {{ $post->comments_count ?? ($post->comments ? $post->comments->count() : 0) }}
                                                        comments</a></li> {{-- Check for comments_count or relation --}}
                                                <li class="date">
                                                    @if ($post->published_at)
                                                        <div class="vs-blog-date">
                                                            {{ \Carbon\Carbon::parse($post->published_at)->format('d M') }}
                                                    </div> @endif
                                                </li>
                                            </ul>
                                        </div>
                                        <h5 class="blog-title line-clamp-2">
                                            <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                                        </h5>
                                        <div class="blog-footer">
                                            <a href="{{ route('blog.show', $post->slug) }}" class="vs-btn style4">
                                                <span>Read Full Post</span>
                                                <i class="fa-duotone fa-regular fa-arrow-right"></i>
                                            </a>
                                            <ul class="custom-ul blog-share">
                                                <li>
                                                    <i class="fa-solid fa-share-nodes"></i>
                                                    <ul class="custom-ul share-list">
                                                        {{-- Sharing URLs using urlencode --}}
                                                        <li><a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog.show', $post->slug)) }}"
                                                                class="facebook" target="_blank" aria-label="Share on Facebook"><i
                                                                    class="fa fa-brands fa-facebook"></i></a></li>
                                                        <li><a href="https://twitter.com/intent/tweet?url={{ urlencode(route('blog.show', $post->slug)) }}&text={{ urlencode($post->title) }}"
                                                                class="twitter" target="_blank" aria-label="Share on Twitter"><i
                                                                    class="fa fa-brands fa-twitter"></i></a></li>
                                                        <li><a href="https://pinterest.com/pin/create/button/?url={{ urlencode(route('blog.show', $post->slug)) }}&media={{ urlencode(asset('storage/' . $post->featured_image)) }}&description={{ urlencode($post->title) }}"
                                                                class="pinterest" target="_blank" aria-label="Share on Pinterest"><i
                                                                    class="fa-brands fa-pinterest"></i></a></li>
                                                        <li><a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('blog.show', $post->slug)) }}&title={{ urlencode($post->title) }}"
                                                                class="linkedin" target="_blank" aria-label="Share on LinkedIn"><i
                                                                    class="fa-brands fa-linkedin"></i></a></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <p class="text-center lead">No recent blog posts found.</p>
                            </div>
                        @endforelse
                    @else
                        <div class="col-12">
                            <p class="text-center lead">Could not load blog posts.</p>
                        </div>
                    @endisset
                </div>


                <div class="row">
                    <div class="col-12">
                        <div class="swiper partner-slider space-top">
                            <div class="swiper-wrapper">
                                @foreach (range(1, 5) as $i)
                                    <div class="swiper-slide">
                                        {{-- ✅ 3. Lazy Loading Added --}}
                                        <img src="{{ asset("assets/img/partner/partner-1-$i.svg") }}"
                                            alt="Morocco Quest Travel Partner Logo {{ $i }}" loading="lazy" />
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

@endsection