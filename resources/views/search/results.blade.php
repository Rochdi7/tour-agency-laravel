@extends('layouts.app2') {{-- Using layout app2 --}}

@section('title', "Search Results for '" . e($query) . "' | " . config('app.name', 'Your Site Name'))
{{-- Sets a specific, descriptive title including the search query --}}

@section('meta_description', "Find tours, activities, and blog posts matching your search for '" . e($query) . "'. Explore options on " . config('app.name', 'Your Site Name') . ".")
{{-- Provides a relevant summary for search engines --}}

@section('canonical_url', request()->fullUrl())
{{-- Sets the canonical URL to the current search results page URL --}}

@section('content')
    <!--================= Breadcrumb Area start =================-->
    <section class="vs-breadcrumb" data-bg-src="{{ asset('assets/img/hot-air-balloon-ride-morocco-desert-adventure.webp

') }}">
        <img src="{{ asset('assets/img/icons/cloud.png') }}" alt="Decorative cloud icon"
            class="vs-breadcrumb-icon-1 animate-parachute" loading="lazy" />

        <img src="{{ asset('assets/img/icons/ballon-sclation.png') }}" alt="Decorative hot air balloon icon"
            class="vs-breadcrumb-icon-2 animate-parachute" loading="lazy" />

        <div class="container">
            <div class="row text-center">
                <div class="col-12">
                    <div class="breadcrumb-content">
                        <h1 class="breadcrumb-title">Search Results for Tours & Activities</h1>
                        <p class="breadcrumb-subtitle" style="color: white;">
                        Experience breathtaking views of the Moroccan desert at sunrise with our hot air balloon tours.
                        </p>

                        <figcaption class="image-caption visually-hidden">
                        Hot air balloons floating over the Moroccan desert with off-road vehicles parked below at sunrise, offering a unique adventure experience.

                        </figcaption>

                        <p class="visually-hidden">
                        Enjoy a magical hot air balloon ride over the beautiful Moroccan desert at sunrise, capturing breathtaking views and unique memories.
                    </p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!--================= Breadcrumb Area end =================-->
    <div class="container my-5">
        {{-- Use H1 for the primary topic of this page --}}
        <h1 class="mb-4 h2">Search Results for "{{ e($query) }}"</h1> {{-- Using h2 class for styling if needed, but
        semantically H1 --}}

        {{-- Tours Section --}}
        @if($tours->count())
            {{-- Use H2 for major content sections on the page --}}
            <h2 class="mt-4 mb-3 h4">Tours</h2> {{-- Using h4 class for styling if needed --}}
            <div class="row g-4">
                @foreach($tours as $tour)
                    <div class="col-md-6 col-xl-4">
                        <div class="tour-package-box style-3 bg-white-color h-100 position-relative">
                            <div class="tour-package-thumb">
                            @php
    $firstImage = optional($tour->firstImage)->image_path;
    $imageUrl = $firstImage ? asset('storage/' . $firstImage) : asset('assets/img/tour-packages/tour-package-1-1.png');
@endphp

<img src="{{ $imageUrl }}" alt="{{ $tour->title }}" class="w-100" loading="lazy" />

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
                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                                xmlns="http://www.w3.org/2000/svg" style="vertical-align: middle;">
                                                <path
                                                    d="M8 0C3.58888 0 0 3.58888 0 8C0 12.4111 3.58888 16 8 16C12.4111 16 16 12.4111 16 8C16 3.58888 12.4111 0 8 0ZM8 15C4.14013 15 1 11.8599 1 8C1 4.14013 4.14013 1 8 1C11.8599 1 15 4.14013 15 8C15 11.8599 11.8599 15 8 15Z"
                                                    fill="currentColor" />
                                                <path d="M8.5 3H7.5V8.20702L10.6465 11.3535L11.3535 10.6465L8.5 7.79295V3Z"
                                                    fill="currentColor" />
                                            </svg>
                                            <span
                                                class="ms-1">{{ $tour->duration_days ? $tour->duration_days . Str::plural(' Day', $tour->duration_days) : $tour->duration }}</span>
                                        </div>
                                    @endif
                                    @if(isset($tour->price_adult))
                                        <div class="pricing-info text-end">
                                            <span class="fs-xs d-block">From</span>
                                            <span
                                                class="new-price text-theme fw-semibold fs-5">${{ number_format($tour->price_adult) }}</span>
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
                <div class="tour-package-box style-3 bg-white-color h-100 position-relative">
                    
                    {{-- Tour Package Thumbnail --}}
                    <div class="tour-package-thumb">
                        <img 
                            src="{{ asset('storage/' . optional($activity->images->first())->image) }}" 
                            alt="{{ $activity->title }}" 
                            class="w-100"
                            loading="lazy"
                            width="400"
                            height="300"
                            onerror="this.onerror=null;this.src='{{ asset('assets/img/activities/activity-placeholder.png') }}';"
                        />
                    </div>

                    {{-- Tour Package Content --}}
                    <div class="tour-package-content">
                        
                        {{-- Location Display --}}
                        @if($activity->location)
                            <div class="location mb-2">
                                <i class="fa-sharp fa-light fa-location-dot me-1"></i>
                                <span>{{ $activity->location }}</span>
                            </div>
                        @endif
                        
                        {{-- Activity Title --}}
                        <h5 class="title line-clamp-2 mb-3">
                            <a href="{{ route('activities.show', $activity->slug) }}" class="stretched-link">
                                {{ $activity->title }}
                            </a>
                        </h5>

                        {{-- Tour Package Footer --}}
                        <div class="tour-package-footer d-flex justify-content-between align-items-center">
                            
                            {{-- Duration Display --}}
                            @if($activity->duration)
                                <div class="tour-duration me-2">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"
                                        xmlns="http://www.w3.org/2000/svg" style="vertical-align: middle;">
                                        <path
                                            d="M8 0C3.58888 0 0 3.58888 0 8C0 12.4111 3.58888 16 8 16C12.4111 16 16 12.4111 16 8C16 3.58888 12.4111 0 8 0ZM8 15C4.14013 15 1 11.8599 1 8C1 4.14013 4.14013 1 8 1C11.8599 1 15 4.14013 15 8C15 11.8599 11.8599 15 8 15Z"
                                            fill="currentColor" />
                                        <path d="M8.5 3H7.5V8.20702L10.6465 11.3535L11.3535 10.6465L8.5 7.79295V3Z"
                                            fill="currentColor" />
                                    </svg>
                                    <span class="ms-1">{{ $activity->duration }}</span>
                                </div>
                            @endif

                            {{-- Pricing Information --}}
                            @if(isset($activity->price_adult))
                                <div class="pricing-info text-end">
                                    <span class="fs-xs d-block">From</span>
                                    <span class="new-price text-theme fw-semibold fs-5">
                                        ${{ number_format($activity->price_adult, 2) }}
                                    </span>
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
    <h2 class="mt-5 mb-3 h4">Blog Posts</h2>
    <div class="row g-4">
        @foreach($blogs as $blog)
            <div class="col-md-6 col-lg-4 move-anim">
                <div class="vs-blog-box style1 position-relative h-100">
                    
                    {{-- Blog Thumbnail --}}
                    <figure class="blog-thumb">
                        <a href="{{ route('blog.show', $blog->slug) }}">
                            @php
                                // Image path logic with fallback
                                $imagePath = $blog->featured_image ? trim(str_replace('public/', '', $blog->featured_image), '/') : null;
                                $featuredImage = $imagePath ? asset('storage/' . $imagePath) : asset('assets/img/blog/blog-placeholder.png');
                            @endphp
                            <img 
                                class="w-100"
                                src="{{ $featuredImage }}"
                                alt="Blog: {{ $blog->title }}"
                                loading="lazy"
                                width="400"
                                height="300"
                                style="aspect-ratio: 4/3; object-fit: cover;"
                                onerror="this.onerror=null;this.src='{{ asset('assets/img/blog/blog-placeholder.png') }}';"
                            />
                        </a>
                    </figure>

                    {{-- Blog Content --}}
                    <div class="blog-content">
                        <div class="blog-meta">
                            <ul class="custom-ul">
                                <li>
                                    <a href="#">
                                        <i class="fa-sharp fa-solid fa-circle-user"></i> 
                                        by {{ $blog->written_by ?? 'Admin' }}
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('blog.show', $blog->slug) }}#comments">
                                        <i class="fa-sharp fa-solid fa-comments"></i>
                                        {{ $blog->comments_count ?? ($blog->comments ? $blog->comments->count() : 0) }} comments
                                    </a>
                                </li>
                                <li class="date">
                                    @if ($blog->created_at)
                                        <div class="vs-blog-date">
                                            <span class="date-number">{{ \Carbon\Carbon::parse($blog->created_at)->format('d') }}</span>
                                            <span class="date-month">{{ \Carbon\Carbon::parse($blog->created_at)->format('M') }}</span>
                                        </div>
                                    @endif
                                </li>
                            </ul>
                        </div>

                        {{-- Blog Title --}}
                        <h5 class="blog-title line-clamp-2">
                            <a href="{{ route('blog.show', $blog->slug) }}">{{ $blog->title }}</a>
                        </h5>

                        {{-- Blog Footer --}}
                        <div class="blog-footer">
                            <a href="{{ route('blog.show', $blog->slug) }}" class="vs-btn style4">
                                <span>Read Full Post</span>
                                <i class="fa-duotone fa-regular fa-arrow-right"></i>
                            </a>

                            {{-- Social Share Links --}}
                            <ul class="custom-ul blog-share">
                                <li>
                                    <i class="fa-solid fa-share-nodes"></i>
                                    <ul class="custom-ul share-list">
                                        <li><a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog.show', $blog->slug)) }}" class="facebook" target="_blank" aria-label="Share on Facebook"><i class="fa fa-brands fa-facebook"></i></a></li>
                                        <li><a href="https://twitter.com/intent/tweet?url={{ urlencode(route('blog.show', $blog->slug)) }}&text={{ urlencode($blog->title) }}" class="twitter" target="_blank" aria-label="Share on Twitter"><i class="fa fa-brands fa-twitter"></i></a></li>
                                        <li><a href="https://pinterest.com/pin/create/button/?url={{ urlencode(route('blog.show', $blog->slug)) }}&media={{ urlencode($featuredImage) }}&description={{ urlencode($blog->title) }}" class="pinterest" target="_blank" aria-label="Share on Pinterest"><i class="fa-brands fa-pinterest"></i></a></li>
                                        <li><a href="https://www.instagram.com/?url={{ urlencode(route('blog.show', $blog->slug)) }}" class="instagram" target="_blank" aria-label="Share on Instagram"><i class="fa-brands fa-instagram"></i></a></li>
                                        <li><a href="https://www.tiktok.com/upload?url={{ urlencode(route('blog.show', $blog->slug)) }}" class="tiktok" target="_blank" aria-label="Share on TikTok"><i class="fa-brands fa-tiktok"></i></a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
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
                <p class="text-muted">Try searching for a different term or browse our categories.</p> {{-- Suggest next steps
                --}}
                <a href="{{ route('home') }}" class="btn btn-primary mt-3">Back to Homepage</a> {{-- Link back home --}}
            </div>
        @endif
    </div>
@endsection