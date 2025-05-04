@php
    /**
     * Helper function to generate a safe storage URL or a default image URL.
     * Checks common storage path patterns and verifies file existence.
     *
     * @param string|null $imagePath The path stored in the database.
     * @param string $default The full URL to the default image asset.
     * @return string The resolved image URL.
     */
    function getFeaturedImageUrl($imagePath, $default) {
        if (!$imagePath) {
            return $default; // Use default if path is null or empty
        }
        // Normalize slashes for cross-platform compatibility
        $normalizedPath = str_replace('\\', '/', $imagePath);
        $relativePath = '';

        // Try to determine the path relative to the public storage disk root
        if (Illuminate\Support\Str::startsWith($normalizedPath, 'public/')) {
             $relativePath = Illuminate\Support\Str::after($normalizedPath, 'public/');
        } elseif (Illuminate\Support\Str::startsWith($normalizedPath, 'storage/app/public/')) { // More specific case
            $relativePath = Illuminate\Support\Str::after($normalizedPath, 'storage/app/public/');
        } elseif (Illuminate\Support\Str::startsWith($normalizedPath, 'storage/')) { // Maybe already relative?
            $relativePath = Illuminate\Support\Str::after($normalizedPath, 'storage/');
        } else { // Assume it might be relative to storage/app/public if no known prefix
             $relativePath = $normalizedPath;
        }

        // Clean leading/trailing slashes
        $cleanedPath = trim($relativePath, '/');

        // Check if the file exists in the 'public' disk (linked storage)
        if (!empty($cleanedPath) && Illuminate\Support\Facades\Storage::disk('public')->exists($cleanedPath)) {
             return asset('storage/' . $cleanedPath); // Generate URL using the asset helper for the public disk
        }

        // Log::warning("Featured image not found or path invalid: " . $imagePath); // Optional: Log missing images
        return $default; // Return default if path is invalid or file doesn't exist
    }

    // Prepare Schema.org JSON-LD Data for BlogPosting
    $schemaData = [
        '@context' => 'https://schema.org',
        '@type' => 'BlogPosting', // Correct type for a blog post
        // Link to the current page as the main entity
        'mainEntityOfPage' => [
            '@type' => 'WebPage',
            '@id' => url()->current(), // The canonical URL of this blog post page
        ],
        // Use the post title as the headline
        'headline' => $post->title,
        // Use the summary or an excerpt as the description
        'description' => $post->summary ?? Illuminate\Support\Str::limit(strip_tags($post->content), 160),
        // Get the featured image URL using the helper function
        'image' => getFeaturedImageUrl($post->featured_image, asset('assets/img/blog/blog-placeholder.png')),
        // Define the author (can be Person or Organization)
        'author' => [
            '@type' => 'Person', // Assuming individual author, change to Organization if needed
            'name' => $post->user->name ?? $post->written_by ?? 'Morocco Quest Team', // Use user name, fallback to written_by, then default
            // Optional: Add author URL if you have dedicated author pages
            // 'url' => isset($post->user) && Route::has('author.show') ? route('author.show', $post->user->slug) : url('/')
        ],
        // Define the publisher (your website/organization)
        'publisher' => [
            '@type' => 'Organization',
            'name' => 'Morocco Quest', // Your site's name
            'logo' => [ // Include organization logo
                '@type' => 'ImageObject',
                // Replace with the actual URL to your logo
                'url' => asset('assets/img/logo-bg.png'),
                // Optional: Add width/height if known
                // 'width' => 600,
                // 'height' => 60
            ],
        ],
        // Publication date in ISO 8601 format
        'datePublished' => $post->created_at ? $post->created_at->toIso8601String() : null,
        // Modification date (fallback to published date if not updated)
        'dateModified' => $post->updated_at ? $post->updated_at->toIso8601String() : ($post->created_at ? $post->created_at->toIso8601String() : null),
        // Include the main body content (stripped of HTML for schema)
        'articleBody' => Illuminate\Support\Str::limit(strip_tags($post->content), 5000), // Limit length if needed
        // Include the category name if available
        'articleSection' => isset($post->category) ? $post->category->name : 'Blog', // Category name or default
    ];
    // Add keywords from tags if available
    if(isset($post->tags) && $post->tags->count()) {
        $schemaData['keywords'] = $post->tags->pluck('name')->implode(', '); // Comma-separated list of tag names
    }

    // --- Clean up potential null values before outputting JSON ---
    $schemaData = array_filter($schemaData, function ($value) { return !is_null($value); });
    if(isset($schemaData['author'])) $schemaData['author'] = array_filter($schemaData['author'], function ($value) { return !is_null($value); });
    if(isset($schemaData['publisher'])) {
        if(isset($schemaData['publisher']['logo'])) $schemaData['publisher']['logo'] = array_filter($schemaData['publisher']['logo'], function ($value) { return !is_null($value); });
        $schemaData['publisher'] = array_filter($schemaData['publisher'], function ($value) { return !is_null($value); });
    }

@endphp

@extends('layouts.app2')

{{-- 1. Page Title: Dynamic using Post Title --}}
{{-- $post->title: Outputs the main title of the current blog post. --}}
@section('title', $post->title . ' | Morocco Quest Blog')

{{-- 2. Meta Description: Dynamic using Post Summary or Excerpt --}}
@section('meta_description')
    {{-- $post->summary: Outputs a pre-defined summary field for the post, if it exists. --}}
    {{-- $post->content: Outputs the full HTML content of the post. strip_tags removes HTML, Str::limit truncates it to 160 characters as a fallback. --}}
    <meta name="description" content="{{ $post->summary ?? Illuminate\Support\Str::limit(strip_tags($post->content), 160) }}">
@endsection

{{-- Social Meta Tags specific to this article (Open Graph & Twitter Cards) - Kept as per provided code --}}
@push('head')
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{ e($post->title) }}" />
    <meta property="og:description" content="{{ e($post->summary ?? Illuminate\Support\Str::limit(strip_tags($post->content), 160)) }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    {{-- $post->featured_image: Path to the featured image from DB. getFeaturedImageUrl resolves it to a full URL or default. --}}
    <meta property="og:image" content="{{ getFeaturedImageUrl($post->featured_image, asset('assets/img/blog/blog-placeholder.png')) }}" />
    {{-- <meta property="og:image:width" content="1200" /> --}} {{-- Recommended: Specify image width --}}
    {{-- <meta property="og:image:height" content="630" /> --}} {{-- Recommended: Specify image height --}}
    <meta property="og:site_name" content="Morocco Quest" />
    {{-- $post->created_at: Timestamp of post creation. toIso8601String() formats it correctly. --}}
    <meta property="article:published_time" content="{{ $post->created_at ? $post->created_at->toIso8601String() : '' }}" />
    {{-- $post->updated_at: Timestamp of last update. Falls back to created_at. --}}
    <meta property="article:modified_time" content="{{ $post->updated_at ? $post->updated_at->toIso8601String() : ($post->created_at ? $post->created_at->toIso8601String() : '') }}" />
    {{-- $post->user->name: Outputs the author's name from the User relationship. --}}
    {{-- $post->written_by: Outputs a string author name if no User relationship exists. --}}
    @if($post->user || $post->written_by)
        <meta property="article:author" content="{{ e($post->user->name ?? $post->written_by ?? 'Morocco Quest Team') }}">
    @endif
     {{-- $post->tags: Collection of associated Tag models. --}}
    @if(isset($post->tags) && $post->tags->count())
        @foreach($post->tags as $tag)
            {{-- $tag->name: Outputs the name of the individual tag. --}}
            <meta property="article:tag" content="{{ e($tag->name) }}">
        @endforeach
    @endif
     {{-- $post->category->name: Outputs the name of the associated Category model. --}}
    <meta property="article:section" content="{{ e($post->category->name ?? 'Blog') }}">

    {{-- Twitter Card Meta Tags --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ e($post->title) }}">
    <meta name="twitter:description" content="{{ e($post->summary ?? Illuminate\Support\Str::limit(strip_tags($post->content), 160)) }}">
    <meta name="twitter:image" content="{{ getFeaturedImageUrl($post->featured_image, asset('assets/img/blog/blog-placeholder.png')) }}">
    {{-- <meta name="twitter:site" content="@YourTwitterHandle"> --}} {{-- Optional: Your Twitter username --}}
@endpush


@section('content')

{{-- Breadcrumb Section --}}
<section
    class="vs-breadcrumb"
    data-bg-src="{{ asset('assets/img/moroccan-souk-woman-seller-market-life-fes.jpg') }}" {{-- Ensure this background is optimized --}}
>
    {{-- Decorative Images: Added loading="lazy" --}}
    <img
        src="{{ asset('assets/img/icons/cloud.png') }}"
        alt="Decorative cloud icon"
        class="vs-breadcrumb-icon-1 animate-parachute"
        loading="lazy" {{-- Added Lazy Loading --}}
        {{-- width="X" height="Y" --}} {{-- Recommend adding dimensions --}}
    />
    <img
        src="{{ asset('assets/img/icons/ballon-sclation.png') }}"
        alt="Decorative hot air balloon icon"
        class="vs-breadcrumb-icon-2 animate-parachute"
        loading="lazy" {{-- Added Lazy Loading --}}
        {{-- width="X" height="Y" --}} {{-- Recommend adding dimensions --}}
    />

    <div class="container">
        <div class="row text-center">
            <div class="col-12">
                <div class="breadcrumb-content">
                    {{-- H1: Post Title - Correct semantic placement --}}
                    <h1 class="breadcrumb-title">{{ $post->title }}</h1>

                    <figcaption class="image-caption" style="color: white; font-size: medium;">
                        A Moroccan woman in traditional attire selling fresh vegetables at a local souk, surrounded by colorful produce and community life.
                    </figcaption>

                    <p class="visually-hidden">
                        Explore the vibrant atmosphere of a traditional Moroccan souk where locals gather to sell and buy fresh produce.
                        This authentic moment highlights the cultural richness and community spirit of everyday life in Morocco.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Main Content Section --}}
<section class="space">
    <div class="container">
        <div class="row gx-3 g-4 gx-xl-5">
            {{-- Main Article Content Area --}}
            <div class="col-lg-8">
                {{-- Using <article> tag for semantic structure --}}
                <article class="vs-blog vs-blog-box3 blog-single" itemscope itemtype="https://schema.org/BlogPosting"> {{-- Added Schema type --}}

                    <div class="blog-img rounded-bottom-0">
                        @php
                            // Use helper function to get the image URL
                            $blogImage = getFeaturedImageUrl($post->featured_image, asset('assets/img/blog/blog-placeholder.png'));
                        @endphp
                        {{-- Featured Image: Added loading="lazy", itemprop="image", dynamic alt, onerror fallback --}}
                        <img itemprop="image" class="img w-100" {{-- Added w-100 for responsiveness if needed --}}
                             src="{{ $blogImage }}"
                             alt="{{ $post->title }}"
                             loading="lazy" {{-- Added Lazy Loading --}}
                             onerror="this.onerror=null;this.src='{{ asset('assets/img/blog/blog-placeholder.png') }}';" {{-- Fallback image on error --}}
                             {{-- width="800" height="450" --}} {{-- CRITICAL: Add actual width/height to prevent layout shift --}}
                             />
                    </div>
                    <div class="blog-content">
                        <div class="blog-meta">
                            {{-- Author --}}
                            <span class="blog-author" itemprop="author" itemscope itemtype="https://schema.org/Person">
                                Written by:
                                {{-- Simple link for now, can be conditional based on route existence --}}
                                <a itemprop="url" href="#">
                                    <span itemprop="name">{{ $post->user->name ?? $post->written_by ?? 'Morocco Quest Team' }}</span>
                                </a>
                            </span>
                            {{-- Published Date --}}
                            <span class="blog-date">
                                <i class="fa-regular fa-calendar-days"></i>
                                {{-- Using <time> tag for semantics and providing datetime attribute for machines --}}
                                <time itemprop="datePublished" datetime="{{ $post->created_at ? $post->created_at->toIso8601String() : '' }}">
                                    {{ $post->created_at ? $post->created_at->format('F d, Y') : 'Date not set' }}
                                </time>
                                {{-- Hidden updated date for schema --}}
                                <meta itemprop="dateModified" content="{{ $post->updated_at ? $post->updated_at->toIso8601String() : ($post->created_at ? $post->created_at->toIso8601String() : '') }}">
                            </span>
                            {{-- Category --}}
                             @if($post->category)
                                <span class="blog-category" itemprop="articleSection"> {{-- Schema property for category --}}
                                    <i class="fa-solid fa-folder-open"></i>
                                    {{-- Link to the category archive page (update route if needed) --}}
                                    <a href="{{ route('blog.category', $post->category->slug) ?? '#' }}" rel="category tag" aria-label="View posts in category {{ $post->category->name }}">{{ $post->category->name }}</a>
                                </span>
                            @endif
                        </div>

                        {{-- Main Article Body --}}
                        {{-- $post->content: Outputs the full HTML content of the blog post. --}}
                        <div itemprop="articleBody" class="dynamic-content-area blog-text vs-content-box"> {{-- Added class for potential styling, itemprop --}}
                            {!! $post->content !!} {{-- Outputting raw HTML content --}}
                        </div>

                        {{-- Quote Section --}}
                         @if($post->quote)
                            <blockquote class="vs-quote">
                                <i class="quote-icon">
                                    {{-- Quote Icon: Added loading="lazy" --}}
                                    <img src="{{ asset('assets/img/icons/svg-blog-details-quote-icon-1-1.svg') }}"
                                         alt="Quote icon"
                                         loading="lazy" {{-- Added Lazy Loading --}}
                                         width="40" height="30" {{-- Example dimensions --}}
                                    />
                                </i>
                                <div class="quote-content">
                                    <p>{{ $post->quote }}</p>
                                    @if($post->quote_author)<cite>{{ $post->quote_author }}</cite>@endif
                                </div>
                            </blockquote>
                        @endif

                        {{-- Footer: Tags & Share --}}
                        <div class="blog-footer flex-wrap">
                            {{-- Tags --}}
                            @if(isset($post->tags) && $post->tags->count() > 0)
                                <div class="block-tag-cloud" itemprop="keywords"> {{-- Schema property for keywords/tags --}}
                                    <span class="title">Tags:</span>
                                    @foreach($post->tags as $tag)
                                         {{-- $tag->slug: URL-friendly identifier for the tag. --}}
                                         {{-- Link to the tag archive page --}}
                                        <a href="{{ route('blog.tag', $tag->slug) ?? '#' }}" class="tag-cloud-link" rel="tag" aria-label="View posts tagged with {{ $tag->name }}">{{ $tag->name }}</a>
                                    @endforeach
                                </div>
                            @endif
                            {{-- Share Buttons --}}
                            <div class="share-box">
                                <span>share <i class="fa-solid fa-share-nodes ms-2"></i></span>
                                <ul class="custom-ul">
                                    {{-- Links updated to use url()->current() for the specific post URL --}}
                                    <li><a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" rel="noopener noreferrer" aria-label="Share this post on Facebook"><i class="fa-brands fa-facebook-f"></i></a></li>
                                    <li><a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($post->title) }}" target="_blank" rel="noopener noreferrer" aria-label="Share this post on X (Twitter)"><i class="fa-brands fa-x-twitter"></i></a></li>
                                    <li><a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}&title={{ urlencode($post->title) }}" target="_blank" rel="noopener noreferrer" aria-label="Share this post on LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a></li>
                                    {{-- Add Pinterest, WhatsApp etc. if needed --}}
                                </ul>
                            </div>
                        </div>
                    </div>{{-- End blog-content --}}
                </article> {{-- End <article> tag --}}

                {{-- Author Box (outside main article for structure) --}}
                @if($post->user || $post->written_by)
                    <div class="blog-single-author">
                        <div class="media-img">
                             {{-- Author Avatar: Added loading="lazy", dynamic alt, onerror fallback --}}
                            @php
                                // Use helper or direct logic for avatar path resolution
                                $authorAvatar = asset('assets/img/blog/blog-author.png'); // Default
                                if(isset($post->user) && $post->user->avatar) {
                                    $avatarPath = trim(str_replace('\\','/', $post->user->avatar), '/');
                                    if (Illuminate\Support\Str::startsWith($avatarPath, 'storage/')) {
                                        $avatarPath = Illuminate\Support\Str::after($avatarPath, 'storage/');
                                    }
                                     if(!empty($avatarPath) && Illuminate\Support\Facades\Storage::disk('public')->exists($avatarPath)) {
                                         $authorAvatar = asset('storage/'.$avatarPath);
                                     }
                                }
                            @endphp
                            <img src="{{ $authorAvatar }}"
                                 alt="Avatar of author {{ e($post->user->name ?? $post->written_by ?? 'Morocco Quest Team') }}"
                                 loading="lazy" {{-- Added Lazy Loading --}}
                                 onerror="this.onerror=null;this.src='{{ asset('assets/img/blog/blog-author.png') }}';"
                                 width="80" height="80" {{-- Recommended: Add actual width/height --}}
                            />
                        </div>
                        <div class="media-body">
                            <p class="author-name"><strong>{{ e($post->user->name ?? $post->written_by ?? 'Morocco Quest Team') }}</strong></p>
                            {{-- $post->user->bio: Outputs the bio field from the User model, if available. --}}
                            @if(isset($post->user) && $post->user->bio)
                                <p class="author-text">{{ e($post->user->bio) }}</p>
                            @else
                                <p class="author-text">Contributor to the Morocco Quest travel blog.</p> {{-- Default text --}}
                            @endif
                            {{-- Optional: Link to author archive page --}}
                        </div>
                    </div>
                @endif

                {{-- Previous/Next Post Navigation --}}
                @if($previousPost || $nextPost)
                    {{-- Using <nav> for semantics --}}
                    <nav class="post-pagination" aria-label="Post Navigation">
                        @isset($previousPost)
                            {{-- $previousPost->slug, ->title: Data for the previous post in sequence. --}}
                            <a href="{{ route('blog.show', $previousPost->slug) ?? '#' }}" class="post-pagi-box prev" aria-label="Previous post: {{ e($previousPost->title) }}">
                                <i class="fa-regular fa-arrow-left"></i>
                                <span class="d-none d-sm-inline">Previous Post: </span>
                                {{ Illuminate\Support\Str::limit($previousPost->title, 15) }}
                            </a>
                        @else
                            {{-- Disabled state if no previous post --}}
                            <span class="post-pagi-box prev disabled" aria-disabled="true">
                                 <i class="fa-regular fa-arrow-left"></i>
                                No Previous Post
                            </span>
                        @endisset
                        @isset($nextPost)
                             {{-- $nextPost->slug, ->title: Data for the next post in sequence. --}}
                            <a href="{{ route('blog.show', $nextPost->slug) ?? '#' }}" class="post-pagi-box next" aria-label="Next post: {{ e($nextPost->title) }}">
                                <span class="d-none d-sm-inline">Next Post: </span>
                                {{ Illuminate\Support\Str::limit($nextPost->title, 15) }}
                                <i class="fa-regular fa-arrow-right"></i>
                            </a>
                        @else
                             {{-- Disabled state if no next post --}}
                             <span class="post-pagi-box next disabled" aria-disabled="true">
                                 No Next Post
                                <i class="fa-regular fa-arrow-right"></i>
                            </span>
                        @endisset
                    </nav>
                @endif

                 {{-- Comments Section --}}
                 {{-- Check if comments relation is loaded to avoid errors --}}
                 @if($post->relationLoaded('comments'))
                    {{-- Added ID for potential linking, Schema scope --}}
                    <div id="comments" class="vs-comments-wrap mt-5" itemscope itemtype="https://schema.org/UserComments">
                        {{-- H2 for section title, dynamic count --}}
                        <h2 class="blog-inner-title" itemprop="name">{{ $post->comments->count() }} Comment{{ $post->comments->count() != 1 ? 's' : '' }}</h2>
                        <meta itemprop="commentCount" content="{{ $post->comments->count() }}"> {{-- Schema comment count --}}

                        @if($post->comments->count() > 0)
                            <ul class="comment-list custom-ul">
                                @foreach($post->comments as $comment)
                                    {{-- $comment->name: Name provided by the commenter. --}}
                                    {{-- $comment->created_at: Timestamp when the comment was submitted. --}}
                                    {{-- $comment->content: The text content of the comment. --}}
                                    <li class="vs-comment-item" itemprop="comment" itemscope itemtype="https://schema.org/Comment">
                                        <div class="vs-post-comment">
                                            <div class="vs-post-comment-inner">
                                                <div class="comment-avater">
                                                    {{-- Comment Author Avatar: Added loading="lazy", dynamic alt --}}
                                                    <img src="{{ asset('assets/img/blog/comment-author-1.png') }}" {{-- Consider user-specific avatars --}}
                                                         alt="Avatar for {{ e($comment->name ?? 'Guest') }}"
                                                         loading="lazy" {{-- Added Lazy Loading --}}
                                                         width="60" height="60" {{-- Recommended: Add actual width/height --}}
                                                         onerror="this.onerror=null;this.src='{{ asset('assets/img/icons/user-avatar-placeholder.png') }}';" {{-- Fallback avatar --}}
                                                         />
                                                </div>
                                                <div class="comment-content">
                                                    <div class="content-header">
                                                        {{-- Commenter name with Schema --}}
                                                        <h5 class="name" itemprop="author" itemscope itemtype="https://schema.org/Person"><span itemprop="name">{{ e($comment->name ?? 'Guest') }}</span></h5>
                                                        {{-- Comment date with <time> and Schema --}}
                                                        <span class="commented-on"><time itemprop="dateCreated" datetime="{{ $comment->created_at->toIso8601String() }}">{{ $comment->created_at->format('F d, Y \a\t H:i') }}</time></span>
                                                    </div>
                                                    {{-- Comment text, escaped and preserving line breaks, with Schema --}}
                                                    <p class="text" itemprop="text">{!! nl2br(e($comment->content)) !!}</p>
                                                     {{-- Optional: Reply link --}}
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <p>Be the first to leave a comment!</p>
                        @endif
                    </div> {{-- End #comments --}}

                     {{-- Comment Form --}}
                    <div class="vs-comment-form mt-4">
                        <div id="respond" class="comment-respond">
                            <div class="form-title">
                                {{-- H3 for form title --}}
                                <h3 class="blog-inner-title">Leave a Comment</h3>
                                <p class="form-text">
                                    Your email address will not be published. Required fields are marked *
                                </p>
                                {{-- Display success/error messages --}}
                                @if (session('success')) <div class="alert alert-success mt-2" role="alert">{{ session('success') }}</div> @endif
                                @if ($errors->any() && !$errors->hasAny(['content', 'name', 'email']))
                                    <div class="alert alert-danger mt-2" role="alert">An unexpected error occurred. Please try again.</div>
                                @endif
                            </div>
                             {{-- Ensure route name 'comments.store' exists and accepts the post --}}
                            <form id="commentform" class="comment-form" action="{{ route('comments.store', $post) ?? '#' }}" method="POST" novalidate> {{-- Added novalidate --}}
                                @csrf
                                <div class="row gx-20">
                                    <div class="col-12 form-group">
                                        <textarea id="comment" name="content" class="form-control @error('content') is-invalid @enderror" placeholder="Your Comment *" required aria-required="true" aria-label="Your Comment">{{ old('content') }}</textarea>
                                        @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                    {{-- Show name/email only if user is not logged in --}}
                                    @guest
                                        <div class="col-md-6 form-group">
                                            <input type="text" id="author" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Your Name *" value="{{ old('name') }}" required aria-required="true" autocomplete="name" aria-label="Your Name"/>
                                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Your Email *" value="{{ old('email') }}" required aria-required="true" autocomplete="email" aria-label="Your Email Address"/>
                                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    @endguest
                                    {{-- Hidden fields and info for logged-in users --}}
                                     @auth
                                        <input type="hidden" name="name" value="{{ auth()->user()->name }}">
                                        <input type="hidden" name="email" value="{{ auth()->user()->email }}">
                                        <div class="col-12 form-group">
                                            <p>Commenting as: <strong>{{ e(auth()->user()->name) }}</strong></p>
                                        </div>
                                    @endauth
                                    <div class="col-12 form-group mb-0">
                                        <button type="submit" class="vs-btn" aria-label="Submit Comment">Post Comment</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div> {{-- End vs-comment-form --}}
                @endif {{-- End comments loaded check --}}

            </div> {{-- End col-lg-8 --}}

            {{-- Sidebar Area --}}
            <div class="col-lg-4">
                <aside class="sidebar-area">
                    {{-- Search Widget --}}
                    <div class="widget widget_search">
                        <h3 class="widget_title title-shep">Search Blog</h3> {{-- H3 for widget title --}}
                        <form class="search-form" action="{{ route('blog.search') ?? '#' }}" method="GET">
                            <input type="text" name="query" placeholder="Search articles..." value="{{ request('query') ?? '' }}" aria-label="Search Blog Posts" />
                            <button type="submit" aria-label="Submit Search"><i class="far fa-search"></i></button>
                        </form>
                    </div>

                    {{-- Recent Posts Widget --}}
                    @isset($recentBlogs)
                         @if($recentBlogs->count() > 0)
                            <div class="widget widget_recent-posts">
                                <h3 class="widget_title title-shep">Recent Posts</h3> {{-- H3 for widget title --}}
                                <div class="recent-post-wrap">
                                    @foreach($recentBlogs as $recent)
                                        <div class="recent-post">
                                            <div class="media-img">
                                                <a href="{{ route('blog.show', $recent->slug) ?? '#' }}" aria-label="Read more about {{ e($recent->title) }}">
                                                    @php
                                                        // Use helper for consistency
                                                        $recentImage = getFeaturedImageUrl($recent->featured_image, asset('assets/img/blog/recent-post-placeholder.png'));
                                                    @endphp
                                                    {{-- Recent Post Image: Added loading="lazy", dynamic alt, onerror --}}
                                                    <img src="{{ $recentImage }}"
                                                         alt="{{ e($recent->title) }}"
                                                         loading="lazy" {{-- Added Lazy Loading --}}
                                                         onerror="this.onerror=null;this.src='{{ asset('assets/img/blog/recent-post-placeholder.png') }}';"
                                                         width="80" height="80" {{-- Recommended: Add actual width/height --}}
                                                    />
                                                </a>
                                            </div>
                                            <div class="media-body">
                                                <div class="recent-post-meta">
                                                    <a href="{{ route('blog.show', $recent->slug) ?? '#' }}">
                                                        <i class="fa-solid fa-calendar"></i>
                                                        {{ $recent->created_at ? $recent->created_at->format('F d, Y') : '' }}
                                                    </a>
                                                </div>
                                                {{-- H6 acceptable within widget --}}
                                                <h6 class="post-title">
                                                    <a class="text-inherit" href="{{ route('blog.show', $recent->slug) ?? '#' }}">
                                                        {{ Illuminate\Support\Str::limit($recent->title, 35) }}
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
                     @isset($categories)
                        @if ($categories->count() > 0)
                            <div class="widget widget_categories">
                                <h3 class="widget_title title-shep">Categories</h3> {{-- H3 for widget title --}}
                                <ul class="custom-ul">
                                    @foreach($categories as $categorySidebar)
                                        <li>
                                            {{-- Link to category archive (Update route if needed) --}}
                                            <a href="{{ route('blog.category', $categorySidebar->slug) ?? '#' }}" aria-label="View posts in category {{ e($categorySidebar->name) }}">{{ e($categorySidebar->name) }}</a>
                                            <span>({{ $categorySidebar->blogs_count ?? 0 }})</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    @endisset

                    {{-- Tags Widget --}}
                     @isset($tags)
                         @if ($tags->count() > 0)
                            <div class="widget widget_meta">
                                <h3 class="widget_title title-shep">Tags</h3> {{-- H3 for widget title --}}
                                <div class="tagcloud">
                                     @foreach($tags as $tagSidebar)
                                        {{-- Link to tag archive (Update route if needed) --}}
                                         <a href="{{ route('blog.tag', $tagSidebar->slug) ?? '#' }}" class="tag-cloud-link" rel="tag" aria-label="View posts tagged with {{ e($tagSidebar->name) }}">{{ e($tagSidebar->name) }}</a>
                                     @endforeach
                                </div>
                            </div>
                        @endif
                    @endisset
                </aside>
            </div> {{-- End Sidebar --}}
        </div> {{-- End row --}}
    </div> {{-- End container --}}
</section>

{{-- Push JSON-LD Schema Script to the 'scripts' stack in the layout --}}
@push('scripts')
<script type="application/ld+json">
    @json($schemaData, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) {{-- Output the prepared schema data as JSON --}}
</script>
@endpush

@endsection