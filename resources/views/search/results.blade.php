@extends('layouts.app2') {{-- Using layout app2 --}}

@section('title', "Search Results for '" . e($query) . "' | " . config('app.name', 'Your Site Name'))
{{-- Sets a specific, descriptive title including the search query --}}

@section('meta_description', "Find tours, activities, and blog posts matching your search for '" . e($query) . "'. Explore options on " . config('app.name', 'Your Site Name') . ".")
{{-- Provides a relevant summary for search engines --}}

@section('canonical_url', request()->fullUrl())
{{-- Sets the canonical URL to the current search results page URL --}}

@section('content')
<!--================= Breadcrumb Area start =================-->
<section class="vs-breadcrumb" data-bg-src="{{ asset('assets/img/hassan-ii-mosque-arches-casablanca-morocco.jpg') }}">
    {{-- Decorative images - Lazy loading not critical here --}}
    <img src="{{ asset('assets/img/icons/cloud.png') }}" alt="Decorative cloud icon"
        class="vs-breadcrumb-icon-1 animate-parachute" />
    <img src="{{ asset('assets/img/icons/ballon-sclation.png') }}" alt="Decorative hot air balloon icon"
        class="vs-breadcrumb-icon-2 animate-parachute" />
    <div class="container">
        <div class="row text-center">
            <div class="col-12">
                <div class="breadcrumb-content">
                    <h1 class="breadcrumb-title" style="color: #e26014;">Page Not Found</h1>
                </div>
               
                <p class="visually-hidden">
                    A stunning view of sunrise casting long shadows through the arches of the Hassan II Mosque in Casablanca, Morocco. This iconic religious and cultural landmark showcases exquisite Moroccan-Islamic design with intricate stonework and grand symmetry.
                </p>
            </div>
        </div>
    </div>
</section>
<!--================= Breadcrumb Area end =================-->
<div class="container my-5">
    {{-- Use H1 for the primary topic of this page --}}
    <h1 class="mb-4 h2">Search Results for "{{ e($query) }}"</h1> {{-- Using h2 class for styling if needed, but semantically H1 --}}

    {{-- Tours Section --}}
    @if($tours->count())
        {{-- Use H2 for major content sections on the page --}}
        <h2 class="mt-4 mb-3 h4">Tours</h2> {{-- Using h4 class for styling if needed --}}
        <div class="row g-4">
            @foreach($tours as $tour)
                <div class="col-md-6 col-xl-4">
                    <div class="tour-package-box style-3 bg-white-color h-100 position-relative">
                        <div class="tour-package-thumb">
                            <img
                                src="{{ $tour->image_url ?? asset('assets/img/tour-packages/tour-package-placeholder.png') }}"
                                alt="Tour: {{ $tour->title }}" {{-- Added context to Alt Text --}}
                                class="w-100"
                                loading="lazy" {{-- Improve performance --}}
                                style="aspect-ratio: 4/3; object-fit: cover;" {{-- Prevent layout shift, ensure consistency --}}
                            />
                        </div>
                        <div class="tour-package-content">
                            {{-- Refined location display logic --}}
                            @php
                                $locationName = $tour->places->first()->name ?? $tour->location ?? null;
                            @endphp
                            @if($locationName)
                            <div class="location mb-2">
                                <i class="fa-sharp fa-light fa-location-dot me-1"></i>
                                <span>{{ $locationName }}</span>
                            </div>
                            @endif
                            <h5 class="title line-clamp-2 mb-3">
                                {{-- Link covers the title, stretched-link makes card clickable --}}
                                <a href="{{ route('tours.show', $tour->slug) }}" class="stretched-link">{{ $tour->title }}</a>
                            </h5>
                            <div class="tour-package-footer d-flex justify-content-between align-items-center">
                                @if($tour->duration)
                                <div class="tour-duration me-2">
                                    {{-- SVG Clock Icon --}}
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" style="vertical-align: middle;"> <path d="M8 0C3.58888 0 0 3.58888 0 8C0 12.4111 3.58888 16 8 16C12.4111 16 16 12.4111 16 8C16 3.58888 12.4111 0 8 0ZM8 15C4.14013 15 1 11.8599 1 8C1 4.14013 4.14013 1 8 1C11.8599 1 15 4.14013 15 8C15 11.8599 11.8599 15 8 15Z" fill="currentColor"/> <path d="M8.5 3H7.5V8.20702L10.6465 11.3535L11.3535 10.6465L8.5 7.79295V3Z" fill="currentColor"/> </svg>
                                    <span class="ms-1">{{ $tour->duration_days ? $tour->duration_days . Str::plural(' Day', $tour->duration_days) : $tour->duration }}</span>
                                </div>
                                @endif
                                @if(isset($tour->price_adult))
                                <div class="pricing-info text-end">
                                    <span class="fs-xs d-block">From</span>
                                    <span class="new-price text-theme fw-semibold fs-5">${{ number_format($tour->price_adult) }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Activities Section --}}
    @if($activities->count())
        <h2 class="mt-5 mb-3 h4">Activities</h2> {{-- Use H2 for major section --}}
         <div class="row g-4">
            @foreach($activities as $activity)
                 <div class="col-md-6 col-xl-4">
                    <div class="tour-package-box style-3 bg-white-color h-100 position-relative"> {{-- Use same card style --}}
                        <div class="tour-package-thumb">
                            <img
                                src="{{ $activity->first_image_url ?? asset('assets/img/activities/activity-placeholder.png') }}"
                                alt="Activity: {{ $activity->title }}" {{-- Added context to Alt Text --}}
                                class="w-100"
                                loading="lazy" {{-- Improve performance --}}
                                style="aspect-ratio: 4/3; object-fit: cover;" {{-- Prevent layout shift --}}
                            />
                        </div>
                        <div class="tour-package-content">
                            @if($activity->location) {{-- Assuming activity has a simple location field --}}
                            <div class="location mb-2">
                                <i class="fa-sharp fa-light fa-location-dot me-1"></i>
                                <span>{{ $activity->location }}</span>
                            </div>
                            @endif
                             <h5 class="title line-clamp-2 mb-3">
                                <a href="{{ route('activities.show', $activity->slug) }}" class="stretched-link">{{ $activity->title }}</a>
                            </h5>
                            <div class="tour-package-footer d-flex justify-content-between align-items-center">
                                @if($activity->duration)
                                <div class="tour-duration me-2">
                                    {{-- SVG Clock Icon --}}
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" style="vertical-align: middle;"> <path d="M8 0C3.58888 0 0 3.58888 0 8C0 12.4111 3.58888 16 8 16C12.4111 16 16 12.4111 16 8C16 3.58888 12.4111 0 8 0ZM8 15C4.14013 15 1 11.8599 1 8C1 4.14013 4.14013 1 8 1C11.8599 1 15 4.14013 15 8C15 11.8599 11.8599 15 8 15Z" fill="currentColor"/> <path d="M8.5 3H7.5V8.20702L10.6465 11.3535L11.3535 10.6465L8.5 7.79295V3Z" fill="currentColor"/> </svg>
                                    <span class="ms-1">{{ $activity->duration }}</span>
                                </div>
                                @endif
                                @if(isset($activity->price_adult))
                                <div class="pricing-info text-end">
                                     <span class="fs-xs d-block">From</span>
                                     <span class="new-price text-theme fw-semibold fs-5">${{ number_format($activity->price_adult) }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- Blogs Section --}}
     @if($blogs->count())
        <h2 class="mt-5 mb-3 h4">Blog Posts</h2> {{-- Use H2 for major section --}}
        <div class="row g-4">
            @foreach($blogs as $blog)
                <div class="col-md-6 col-lg-4 move-anim"> {{-- Ensure consistent column usage or adjust as needed --}}
                  <div class="vs-blog-box style1 position-relative h-100"> {{-- Added h-100 for consistency --}}
                    <figure class="blog-thumb">
                       <img
                          src="{{ $blog->featured_image_url ?? asset('assets/img/blog/blog-placeholder.png') }}" {{-- Use accessor if defined --}}
                          alt="Blog: {{ $blog->title }}" {{-- Added context to Alt Text --}}
                          class="w-100"
                          loading="lazy" {{-- Improve performance --}}
                          style="aspect-ratio: 4/3; object-fit: cover;" {{-- Prevent layout shift --}}
                        />
                    </figure>
                    <div class="blog-content">
                      <div class="blog-meta">
                        <ul class="custom-ul">
                           {{-- Removed list items for author/comments/date if not always needed or available --}}
                           {{-- Re-add if data is consistently available --}}
                            <li class="date">{{ $blog->created_at->format('M d, Y') }}</li> {{-- More standard date format --}}
                        </ul>
                      </div>
                      <h5 class="blog-title line-clamp-2">
                        <a href="{{ route('blog.show', $blog->slug) }}" class="stretched-link">
                          {{ $blog->title }}
                        </a>
                      </h5>
                      {{-- Removed blog footer with share icons if not essential for search results page --}}
                       <a href="{{ route('blog.show', $blog->slug) }}" class="vs-btn style4 stretched-link-pseudo mt-3"> {{-- Simple Read More --}}
                          <span>Read More</span>
                          <i class="fa-solid fa-arrow-right ms-1"></i>
                       </a>
                    </div>
                  </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- No Results Message --}}
    @if(!$tours->count() && !$activities->count() && !$blogs->count())
        <div class="text-center my-5 py-5"> {{-- Added more spacing --}}
             <i class="fas fa-search fa-3x text-muted mb-3"></i> {{-- Optional: Add an icon --}}
             <p class="text-muted fs-4">No results found for "{{ e($query) }}".</p>
             <p class="text-muted">Try searching for a different term or browse our categories.</p> {{-- Suggest next steps --}}
             <a href="{{ route('home') }}" class="btn btn-primary mt-3">Back to Homepage</a> {{-- Link back home --}}
         </div>
    @endif
</div>
@endsection