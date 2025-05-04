@extends('layouts.app2')

{{-- 1. Page Title: Dynamically optimized (Unchanged - Logic is good) --}}
@section('title')
    @if(isset($tag))
        Blog Posts tagged: {{ $tag->name }} | Morocco Quest
        {{-- $tag->name: Outputs the name of the specific tag being viewed (e.g., "Desert Travel") --}}
    @elseif(isset($category))
        {{ $category->name }} - Blog Category | Morocco Quest
        {{-- $category->name: Outputs the name of the specific category being viewed (e.g., "Food & Drink") --}}
    @elseif(isset($query) && $query)
        Blog Search Results for: "{{ e($query) }}" | Morocco Quest
        {{-- $query: Outputs the user's search term, safely escaped using e() --}}
    @else
        Morocco Travel Blog & Latest News | Morocco Quest
    @endif
@endsection

{{-- 2. Meta Description: Dynamic - Wrapped in <meta> tag --}}
@section('meta_description')
    {{-- This section dynamically generates the meta description based on the context (tag, category, search, or default blog index). --}}
    <meta name="description" content="@if(isset($tag))Read Morocco Quest blog posts tagged with '{{ $tag->name }}'. Discover travel tips, stories, and guides related to {{ $tag->name }} in Morocco.@elseif(isset($category))Explore Morocco Quest blog articles in the category '{{ $category->name }}'. Find insights on {{ $category->name }}, travel planning, and Moroccan culture.@elseif(isset($query) && $query)Search results for '{{ e($query) }}' on the Morocco Quest travel blog. Find articles related to your search query.@else{{-- Default description --}}Stay updated with the latest news, travel tips, destination guides, and stories from Morocco on the Morocco Quest blog.@endif">
@endsection

{{-- 7. Technical SEO: Add 'noindex' ONLY for search results scenario (Unchanged - Logic is correct) --}}
@if(isset($query) && $query)
    @push('head')
        <meta name="robots" content="noindex, follow">
    @endpush
@endif

{{-- NEW SECTION: Added for page-specific JSON-LD Structured Data --}}
@section('structured_data')
    {{-- Prepare data for ItemList based on the posts shown on the current page --}}
    @php
        $itemListElements = [];
        // Ensure $posts exists and is countable (like a Paginator) before looping
        if(isset($posts) && method_exists($posts, 'items') && count($posts->items()) > 0) {
            // Calculate the starting index based on pagination for accurate position
            $startIndex = ($posts->currentPage() - 1) * $posts->perPage();
            foreach ($posts as $index => $post) {
                // Helper for image path extraction and fallback
                $imagePath = $post->featured_image ? trim(str_replace('public/', '', $post->featured_image), '/') : null;
                $featuredImage = $imagePath ? asset('storage/' . $imagePath) : asset('assets/img/blog/blog-3-1.png'); // Default placeholder

                 // Get Author details safely
                 $authorName = $post->user->name ?? $post->written_by ?? 'Morocco Quest Team';
                 // Basic author schema - could link to an author URL if available
                 $authorSchema = [
                     '@type' => 'Person', // Or 'Organization' if it's a team post
                     'name' => $authorName
                 ];
                 // if ($post->user && route('author.show', $post->user->slug)) { // Example linking
                 //    $authorSchema['url'] = route('author.show', $post->user->slug);
                 // }

                $itemListElements[] = [
                    '@type' => 'ListItem',
                    'position' => $startIndex + $index + 1, // Correct position across pages
                    'item' => [
                        '@type' => 'BlogPosting', // Each item in the list is a blog post
                        'url' => route('blog.show', $post->slug) ?? '#', // URL to the specific blog post
                        'headline' => $post->title, // The title of the post
                        'image' => $featuredImage, // The featured image of the post
                        'datePublished' => $post->created_at ? $post->created_at->toIso8601String() : null, // Publication date in ISO format
                        'dateModified' => $post->updated_at ? $post->updated_at->toIso8601String() : null, // Last modification date
                        'author' => $authorSchema, // Author details
                        'publisher' => [ // The publisher is the website/organization
                             '@type' => 'Organization',
                             'name' => 'Morocco Quest',
                             // Optional: Add logo URL if available globally
                             // 'logo' => ['@type' => 'ImageObject', 'url' => asset('path/to/logo.png')]
                         ],
                        // Include a short description if available
                         'description' => $post->summary ?? Str::limit(strip_tags($post->content), 160)
                    ]
                ];
            }
        }

        // Determine the main Schema type for the page itself
        $pageSchemaType = 'Blog'; // Default for the main blog index
        $pageName = $__env->yieldContent('title'); // Get the rendered title
        $pageDescription = strip_tags($__env->yieldContent('meta_description')); // Get the rendered meta description text

        if (isset($tag) || isset($category)) {
            $pageSchemaType = 'CollectionPage'; // Archives are collections
        } elseif (isset($query) && $query) {
            $pageSchemaType = 'SearchResultsPage'; // Search results page
        }
    @endphp

    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "{{ $pageSchemaType }}",
      "name": "{{ $pageName }}", // Use the dynamic page title
      "description": "{{ $pageDescription }}", // Use the dynamic meta description
      "url": "{{ url()->current() }}", // URL of this specific archive/search/index page
      "image": "{{ asset('assets/img/chefchaouen-blue-house-door-morocco-blog-hero.jpg') }}", // Main hero image for this page type
      @if($pageSchemaType === 'SearchResultsPage' && isset($query) && $query)
      "query": "input={{ e($query) }}", // Add the search query for SearchResultsPage
      @endif
      "mainEntity": { // The primary content of the page is the list of posts
        "@type": "ItemList",
        "itemListElement": @json($itemListElements) // Embed the array of ListItems (posts on this page)
      },
       "publisher": { // Publisher of the blog/website
             "@type": "Organization",
             "name": "Morocco Quest"
             // "url": "{{ url('/') }}", // Optional: URL to homepage
             // "logo": { "@type": "ImageObject", "url": asset('path/to/logo.png') } // Optional: Logo
       }
       // Depending on the page type, you might add breadcrumbs here if not handled globally
       // "breadcrumb": { ... }
    }
    </script>
@endsection


@section('content')

{{-- Breadcrumb Section --}}
<section
    class="vs-breadcrumb"
    data-bg-src="{{ asset('assets/img/chefchaouen-blue-house-door-morocco-blog-hero.jpg') }}"
>
    {{-- Decorative Images: Added loading="lazy" --}}
    <img src="{{ asset('assets/img/icons/cloud.png') }}"
         alt="Decorative cloud icon"
         class="vs-breadcrumb-icon-1 animate-parachute"
         loading="lazy" {{-- Added Lazy Loading --}}
         {{-- width="X" height="Y" --}} {{-- Recommend adding dimensions --}}
         />
    <img src="{{ asset('assets/img/icons/ballon-sclation.png') }}"
         alt="Decorative hot air balloon icon"
         class="vs-breadcrumb-icon-2 animate-parachute"
         loading="lazy" {{-- Added Lazy Loading --}}
         {{-- width="X" height="Y" --}} {{-- Recommend adding dimensions --}}
         />
    <div class="container">
        <div class="row text-center">
            <div class="col-12">
                <div class="breadcrumb-content">
                    {{-- Dynamic H1 (Unchanged - Logic is good) --}}
                    <h1 class="breadcrumb-title">
                        @if(isset($tag))
                            Posts tagged with "{{ $tag->name }}"
                        @elseif(isset($category))
                            Blog Category: "{{ $category->name }}"
                        @elseif(isset($query) && $query)
                            Blog Search Results
                        @else
                            Latest News & Travel Blog
                        @endif
                    </h1>
                     @if(isset($query) && $query) {{-- Display search query if applicable --}}
                        <p class="text-white">Showing results for: "{{ e($query) }}"</p>
                     @endif

                     {{-- Caption (Unchanged) --}}
                    <figcaption class="image-caption" style="color: white; font-size: medium;">
                        A vibrant blue house in Chefchaouen, Morocco, showcasing the town’s unique architecture and colorful charm.
                    </figcaption>

                     {{-- Hidden description (Unchanged) --}}
                    <p class="visually-hidden">
                        Experience the serene beauty of Chefchaouen, Morocco’s Blue City. Famous for its painted streets and vibrant doors,
                        this peaceful mountain town is a favorite among travelers and photographers.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Main Blog Content Section --}}
{{-- Schema.org Blog/CollectionPage/SearchResultsPage added via JSON-LD in head --}}
<section class="vs-blog-wrapper space">
    <div class="container">
        <div class="row gx-3 g-5">
            {{-- Main Content Area (Posts) --}}
            <div class="col-lg-8">
                <div class="row g-4 gy-4 gy-sm-5">
                    {{-- Loop through posts or show empty state --}}
                    @forelse ($posts as $post)
                        {{-- $post->slug: URL-friendly identifier for the post (e.g., "my-first-trip-to-marrakech") --}}
                        {{-- $post->title: The main title of the blog post --}}
                        {{-- $post->featured_image: Path to the image file relative to storage/app/public --}}
                        {{-- $post->user->name: Name of the User who authored the post (if relationship exists) --}}
                        {{-- $post->written_by: Fallback author name string if user relationship doesn't exist or isn't set --}}
                        {{-- $post->created_at: Timestamp of when the post was created --}}
                        {{-- $post->summary: A short summary text for the post --}}
                        {{-- $post->content: The full content of the post (used for excerpt fallback) --}}
                        <div class="col-12">
                            <div class="vs-blog vs-blog-box3">
                                <div class="blog-img">
                                    <a href="{{ route('blog.show', $post->slug) ?? '#' }}" aria-label="Read more about {{ $post->title }}">
                                        @php
                                            // Image path logic with fallback
                                            $imagePath = $post->featured_image ? trim(str_replace('public/', '', $post->featured_image), '/') : null;
                                            $featuredImage = $imagePath ? asset('storage/' . $imagePath) : asset('assets/img/blog/blog-3-1.png'); // Default placeholder
                                        @endphp
                                        {{-- Featured Image: Added loading="lazy", dynamic alt --}}
                                        <img class="img"
                                             src="{{ $featuredImage }}"
                                             alt="{{ $post->title }}"
                                             loading="lazy" {{-- Added Lazy Loading --}}
                                             onerror="this.onerror=null;this.src='{{ asset('assets/img/blog/blog-3-1.png') }}';" {{-- Basic image error fallback --}}
                                             {{-- width="X" height="Y" --}} {{-- Recommend adding dimensions --}}
                                        >
                                    </a>
                                </div>
                                <div class="blog-content">
                                    <div class="blog-meta">
                                        <span class="blog-author">
                                            <span class="written-by-label">Written by:</span>
                                            {{-- Link author name if route exists, otherwise just display --}}
                                            {{-- Example conditional link: @if($post->user && Route::has('author.show')) <a href="{{ route('author.show', $post->user->slug) }}">...</a> @else ... @endif --}}
                                             <a href="#"> {{-- Keep simple link for now --}}
                                                {{ $post->user->name ?? $post->written_by ?? 'Morocco Quest Team' }}
                                            </a>
                                        </span>
                                        <span class="blog-date">
                                            <i class="fa-regular fa-calendar-days"></i>
                                            {{ $post->created_at ? $post->created_at->format('F d, Y') : 'Date not set' }}
                                        </span>
                                    </div>
                                    {{-- Post Title (H3) --}}
                                    <h3 class="blog-title">
                                        <a href="{{ route('blog.show', $post->slug) ?? '#' }}" aria-label="Read more about {{ $post->title }}">
                                            {{ $post->title }}
                                        </a>
                                    </h3>
                                    {{-- Post Excerpt/Summary --}}
                                    <p class="blog-text">
                                        {{ $post->summary ?? Str::limit(strip_tags($post->content), 180) }}
                                    </p>
                                    <div class="blog-footer">
                                         {{-- Read More Link --}}
                                        <a href="{{ route('blog.show', $post->slug) ?? '#' }}" class="blog-link" aria-label="Read more about {{ $post->title }}">
                                            Read Full Post
                                            <i class="fa-sharp fa-regular fa-angles-right"></i>
                                        </a>
                                        {{-- Social Share Links (Unchanged structure, improved aria-labels) --}}
                                        <div class="share-box">
                                            <span>
                                                share <i class="fa-solid fa-share-nodes ms-2"></i>
                                            </span>
                                            <ul class="custom-ul">
                                                <li><a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('blog.show', $post->slug) ?? url('/')) }}" target="_blank" rel="noopener noreferrer" aria-label="Share {{ $post->title }} on Facebook"><i class="fa-brands fa-facebook-f"></i></a></li>
                                                <li><a href="https://twitter.com/intent/tweet?url={{ urlencode(route('blog.show', $post->slug) ?? url('/')) }}&text={{ urlencode($post->title) }}" target="_blank" rel="noopener noreferrer" aria-label="Share {{ $post->title }} on X (Twitter)"><i class="fa-brands fa-x-twitter"></i></a></li>
                                                <li><a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(route('blog.show', $post->slug) ?? url('/')) }}&title={{ urlencode($post->title) }}" target="_blank" rel="noopener noreferrer" aria-label="Share {{ $post->title }} on LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        {{-- Display when no posts are found --}}
                        <div class="col-12 text-center">
                            <p class="lead mt-5">
                                @if(isset($query) && $query)
                                    No posts found matching your search query "{{ e($query) }}".
                                @elseif(isset($category))
                                    No posts found in the category "{{ $category->name }}".
                                @elseif(isset($tag))
                                     No posts found with the tag "{{ $tag->name }}".
                                @else
                                    No blog posts have been published yet. Please check back soon!
                                @endif
                             </p>
                            <a href="{{ route('blog.index') ?? '#' }}" class="vs-btn mt-3">View All Posts</a>
                        </div>
                    @endforelse
                </div>

                {{-- Pagination Links --}}
                 @if ($posts->hasPages()) {{-- Check if pagination is needed --}}
                     <div class="vs-pagination pt-50 pb-30">
                         {{-- Append query parameters (like tag, category, query) to pagination links --}}
                         {{ $posts->appends(request()->except('page'))->links() }}
                     </div>
                 @endif
            </div>

            {{-- Sidebar Area --}}
            <div class="col-lg-4">
                <aside class="sidebar-area">
                    {{-- Search Widget --}}
                    <div class="widget widget_search">
                        <h5 class="widget_title title-shep">Search Blog</h5>
                        {{-- Ensure form action points to the correct search route --}}
                        <form class="search-form" action="{{ route('blog.search') ?? '#' }}" method="GET">
                            <input type="text" name="query" placeholder="Search articles..." value="{{ $query ?? '' }}" aria-label="Search Blog Posts" />
                            <button type="submit" aria-label="Submit Search"><i class="far fa-search"></i></button>
                        </form>
                    </div>

                    {{-- Recent Posts Widget --}}
                    {{-- Check if $recentBlogs exists and has items --}}
                    @isset($recentBlogs)
                         @if($recentBlogs->count() > 0)
                            <div class="widget widget_recent-posts">
                                <h5 class="widget_title title-shep">Recent Posts</h5>
                                <div class="recent-post-wrap">
                                    @foreach($recentBlogs as $recent)
                                        {{-- $recent->slug, ->title, ->featured_image, ->created_at : Same meaning as in the main $post loop --}}
                                        <div class="recent-post">
                                            <div class="media-img">
                                                <a href="{{ route('blog.show', $recent->slug) ?? '#' }}" aria-label="Read more about {{ $recent->title }}">
                                                    @php
                                                        // Recent image path logic
                                                        $recentImagePath = $recent->featured_image ? trim(str_replace('public/', '', $recent->featured_image), '/') : null;
                                                        $recentImage = $recentImagePath ? asset('storage/' . $recentImagePath) : asset('assets/img/blog/recent-post-1-1.png'); // Default
                                                    @endphp
                                                    {{-- Recent Post Image: Added loading="lazy", dynamic alt --}}
                                                    <img src="{{ $recentImage }}"
                                                         alt="{{ $recent->title }}"
                                                         loading="lazy" {{-- Added Lazy Loading --}}
                                                         onerror="this.onerror=null;this.src='{{ asset('assets/img/blog/recent-post-1-1.png') }}';"
                                                         {{-- width="X" height="Y" --}} {{-- Recommend adding dimensions --}}
                                                    >
                                                </a>
                                            </div>
                                            <div class="media-body">
                                                <div class="recent-post-meta">
                                                    <a href="{{ route('blog.show', $recent->slug) ?? '#' }}">
                                                        <i class="fa-solid fa-calendar"></i>
                                                        {{ $recent->created_at ? $recent->created_at->format('F d, Y') : '' }}
                                                    </a>
                                                </div>
                                                <h6 class="post-title">
                                                    <a class="text-inherit" href="{{ route('blog.show', $recent->slug) ?? '#' }}">
                                                        {{ Str::limit($recent->title, 35) }}
                                                    </a>
                                                </h6>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @endisset

                     {{-- Categories Widget --}}
                     {{-- Check if $categories exists and has items --}}
                     @isset($categories)
                        @if ($categories->count() > 0)
                            <div class="widget widget_categories">
                                <h5 class="widget_title title-shep">Categories</h5>
                                <ul class="custom-ul">
                                    @foreach($categories as $cat)
                                        {{-- $cat->slug: URL-friendly identifier for the category --}}
                                        {{-- $cat->name: Display name of the category --}}
                                        {{-- $cat->blogs_count: Number of blog posts in this category (assuming this attribute exists) --}}
                                        <li>
                                            {{-- Link to category archive page --}}
                                            {{-- *** Using blog.category route as it's more likely for blog section *** --}}
                                             <a href="{{ route('blog.category', $cat->slug) ?? '#' }}" aria-label="View posts in category {{ $cat->name }}">{{ $cat->name }}</a>

                                            <span>({{ $cat->blogs_count ?? 0 }})</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    @endisset

                     {{-- Tags Widget --}}
                     {{-- Check if $tags exists and has items --}}
                     @isset($tags)
                         @if ($tags->count() > 0)
                            <div class="widget widget_meta">
                                <h5 class="widget_title title-shep">Tags</h5>
                                <div class="tagcloud">
                                     @foreach($tags as $t)
                                         {{-- $t->slug: URL-friendly identifier for the tag --}}
                                         {{-- $t->name: Display name of the tag --}}
                                         {{-- Link to tag archive page --}}
                                         {{-- *** Using blog.tag route as it's more likely for blog section *** --}}
                                         <a href="{{ route('blog.tag', $t->slug) ?? '#' }}" aria-label="View posts tagged with {{ $t->name }}">{{ $t->name }}</a>
                                     @endforeach
                                </div>
                            </div>
                        @endif
                    @endisset

                </aside>
            </div>
        </div>
    </div>
</section>
@endsection