@extends('layouts.app2')

@section('meta')
    <meta name="description"
        content="Explore exclusive multi-day tours and one-day excursions in Morocco. Discover luxury desert camps, ancient medinas, and the Atlas Mountains with our curated travel experiences.">
    <meta name="keywords"
        content="Morocco tours, desert camps, multi-day tours, one-day excursions, Atlas Mountains, luxury travel">
    <link rel="canonical" href="{{ url()->current() }}">
    <meta property="og:title" content="Discover Our Exclusive Tours - Morocco" />
    <meta property="og:description"
        content="Explore Morocco's breathtaking landscapes with our multi-day tours and one-day excursions." />
    <meta property="og:image" content="{{ asset('assets/img/sunset-luxury-desert-camp-morocco.webp') }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />
@endsection

@section('content')

    <section class="vs-breadcrumb" data-bg-src="{{ asset('assets/img/sunset-luxury-desert-camp-morocco.webp') }}">
        {{-- Decorative images - Lazy loading not critical here --}}
        <img src="{{ asset('assets/img/icons/cloud.png') }}" alt="Decorative cloud icon"
            class="vs-breadcrumb-icon-1 animate-parachute" loading="lazy" />
        <img src="{{ asset('assets/img/icons/ballon-sclation.png') }}" alt="Decorative hot air balloon icon"
            class="vs-breadcrumb-icon-2 animate-parachute" loading="lazy" />

        <div class="container">
            <div class="row text-center">
                <div class="col-12">
                    <div class="breadcrumb-content">
                        <h1 class="breadcrumb-title">Discover Our Exclusive Tours</h1>
                        <p class="mt-3 text-white">
                            Explore Morocco's Breathtaking Landscapes With Our Multi-Day Tours And One-Day Excursions.
                            Whether You Dream Of Wandering The Sahara Desert, Exploring Ancient Medinas, Or Enjoying A
                            Sunset Over The Atlas Mountains, We Bring Your Travel Experience To Life. </p>
                    </div>

                    <p class="visually-hidden">
                        Discover Morocco's exclusive multi-day tours and one-day excursions. Explore luxury desert camps,
                        ancient medinas, the Atlas Mountains, and much more with our carefully crafted travel experiences.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Breadcrumb Schema -->
    <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "BreadcrumbList",
          "itemListElement": [{
            "@type": "ListItem",
            "position": 1,
            "name": "Home",
            "item": "{{ url('/') }}"
          },{
            "@type": "ListItem",
            "position": 2,
            "name": "Tours & Activities",
            "item": "{{ url()->current() }}"
          }]
        }
        </script>

    <div class="container py-5">

        <!-- Page Title -->
        <h2 class="mb-4">{{ $type }}</h2>

        <!-- Tours Section -->
        @if($tours->count())
            <h3 class="mt-4 mb-3 h4">Tours</h3>
            <div class="row g-4">
                @foreach($tours as $tour)
                    <div class="col-md-6 col-xl-4">
                        <div class="tour-package-box style-3 bg-white-color h-100 position-relative">
                            <div class="tour-package-thumb">
                                <img src="{{ $tour->firstImage->image ?? asset('assets/img/tour-packages/tour-package-placeholder.png') }}"
                                    alt="Discover {{ $tour->title }} in {{ $tour->places->first()->name ?? $tour->location ?? 'Morocco' }}"
                                    class="w-100" loading="lazy" style="aspect-ratio: 4/3; object-fit: cover;" />
                            </div>
                            <div class="tour-package-content">
                                <div class="location mb-2">
                                    <i class="fa-solid fa-location-dot me-1"></i>
                                    <span>{{ $tour->places->first()->name ?? $tour->location ?? 'No Location' }}</span>
                                </div>

                                <h5 class="title line-clamp-2 mb-3">
                                    <a href="{{ route('tours.show', $tour->slug) }}" class="stretched-link">{{ $tour->title }}</a>
                                </h5>

                                <div class="tour-package-footer d-flex justify-content-between align-items-center">
                                    <div class="tour-duration me-2">
                                        <i class="fa-regular fa-clock"></i>
                                        <span class="ms-1">{{ $tour->duration_days ?? 'Flexible' }} Days</span>
                                    </div>
                                    @if(isset($tour->price_adult))
                                        <div class="pricing-info text-end">
                                            <span class="fs-xs d-block">From</span>
                                            <span
                                                class="new-price text-theme fw-semibold fs-5">${{ number_format($tour->price_adult, 2) }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            {{ $tours->links() }}
        @else
            <p class="text-muted">No tours found for this category.</p>
        @endif

        <!-- Activities Section -->
        @if(!in_array($type, ['Multi-Day Tours', 'Garden Tours', 'Art Tours', 'Classical Tours']) && count($activities) > 0)
            <h3 class="mt-5 mb-3 h4">Activities</h3>
            <div class="row g-4">
                @foreach($activities as $activity)
                    <div class="col-md-6 col-xl-4">
                        <div class="tour-package-box style-3 bg-white-color h-100 position-relative">
                            <div class="tour-package-thumb">
                                <img src="{{ $activity->images->first()->image ?? asset('assets/img/activities/activity-placeholder.png') }}"
                                    alt="Join {{ $activity->title }} in {{ $activity->location ?? 'Morocco' }}" class="w-100"
                                    loading="lazy" style="aspect-ratio: 4/3; object-fit: cover;" />
                            </div>
                            <div class="tour-package-content">
                                <div class="location mb-2">
                                    <i class="fa-solid fa-location-dot me-1"></i>
                                    <span>{{ $activity->location ?? 'Unknown Location' }}</span>
                                </div>

                                <h5 class="title line-clamp-2 mb-3">
                                    <a href="{{ route('activities.show', $activity->slug) }}"
                                        class="stretched-link">{{ $activity->title }}</a>
                                </h5>

                                <div class="tour-package-footer d-flex justify-content-between align-items-center">
                                    <div class="tour-duration me-2">
                                        <i class="fa-regular fa-clock"></i>
                                        <span class="ms-1">{{ $activity->duration ?? 'Flexible Duration' }}</span>
                                    </div>
                                    @if(isset($activity->price_adult))
                                        <div class="pricing-info text-end">
                                            <span class="fs-xs d-block">From</span>
                                            <span
                                                class="new-price text-theme fw-semibold fs-5">${{ number_format($activity->price_adult, 2) }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            {{ $activities->links() }}
        @endif


    </div>
@endsection