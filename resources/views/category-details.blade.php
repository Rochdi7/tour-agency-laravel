@extends('layouts.app') {{-- Or layouts.app2 if that's the correct layout --}}

{{-- 1. Page Title: Optimized for keywords and clarity (Existing logic is good) --}}
{{-- $category->name: Outputs the name of the current category (e.g., "Travel Tips") --}}
@section('title', $category->name . ' - Blog Articles | Morocco Quest')

{{-- 2. Meta Description: Specific dynamic description wrapped in <meta> tag --}}
@section('meta_description')
    {{-- Uses the category name dynamically. Concise and keyword-rich. --}}
    <meta name="description" content="Read blog articles about {{ $category->name }} and Morocco travel tips, guides, and stories from Morocco Quest. Discover insights for your next adventure.">
@endsection

{{-- NEW SECTION: Added for page-specific JSON-LD Structured Data --}}
@section('structured_data')
    {{-- Prepare data for ItemList based on the posts shown on the current page --}}
    @php
        $itemListElements = [];
        // Ensure $blogs exists and is a paginator/collection with items
        if(isset($blogs) && method_exists($blogs, 'items') && count($blogs->items()) > 0) {
            // Calculate the starting index based on pagination for accurate position
            $startIndex = ($blogs->currentPage() - 1) * $blogs->perPage();
            foreach ($blogs as $index => $blog) {
                // Helper to get image URL safely
                $imageUrl = $blog->featured_image ? asset('storage/' . $blog->featured_image) : asset('assets/img/blog/blog-placeholder.png'); // Default placeholder

                $itemListElements[] = [
                    '@type' => 'ListItem',
                    'position' => $startIndex + $index + 1, // Correct position across pages
                    'item' => [
                        '@type' => 'BlogPosting', // Each item in the list is a blog post
                        'url' => route('blog.show', $blog->slug) ?? '#', // URL to the specific blog post
                        'headline' => $blog->title, // The title of the post
                        'image' => $imageUrl, // The featured image of the post
                        'datePublished' => $blog->created_at ? $blog->created_at->toIso8601String() : null,
                        'dateModified' => $blog->updated_at ? $blog->updated_at->toIso8601String() : ($blog->created_at ? $blog->created_at->toIso8601String() : null),
                        // Include a short description if available
                        'description' => Str::limit(strip_tags($blog->summary ?? $blog->content), 160) // Use summary or content excerpt
                    ]
                ];
            }
        }

        // Helper to safely get the meta description content
        $metaDescriptionContent = '';
        try {
            $metaDescriptionContent = strip_tags($__env->yieldContent('meta_description'));
        } catch (\Throwable $e) {
             $metaDescriptionContent = 'Read blog articles about ' . $category->name . ' from Morocco Quest.'; // Fallback
        }
         if (empty($metaDescriptionContent)) {
              $metaDescriptionContent = 'Read blog articles about ' . $category->name . ' and Morocco travel tips, guides, and stories from Morocco Quest.';
         }

    @endphp

    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      // This page lists a collection of blog posts within a category
      "@type": "CollectionPage",
      // Name derived from the H1/Title
      "name": "{{ $category->name }} - Blog Articles",
      // Description derived from the meta description content
      "description": "{{ $metaDescriptionContent }}",
      // URL of this specific category archive page
      "url": "{{ url()->current() }}",
       // You might use the category image here if available, or a default blog hero image
      "image": "{{ asset('assets/img/default-blog-category-hero.webp') }}", // Replace with a relevant category image or default
      "mainEntity": { // The primary content is the list of blog posts
        "@type": "ItemList",
        // Contains details about each blog post listed on this specific page
        "itemListElement": @json($itemListElements, JSON_UNESCAPED_SLASHES) // Safely outputs the PHP array as JSON
      },
      "publisher": { // Information about the site publishing the content
            "@type": "Organization",
            "name": "Morocco Quest"
            // "url": "{{ url('/') }}", // Optional homepage URL
            // "logo": { "@type": "ImageObject", "url": asset('path/to/your/logo.png') } // Optional logo
      }
      // Optional: Add BreadcrumbList schema here if not handled globally
    }
    </script>
@endsection


@section('content')
{{-- Main container for the category archive page --}}
<div class="container py-5">
    {{-- H1: Main heading indicating the category being viewed --}}
    {{-- $category->name: Outputs the name of the current category. --}}
    <h1 class="mb-4">Articles in Category: "{{ $category->name }}"</h1>

    {{-- Check if there are any blog posts in this category --}}
    @if ($blogs->count())
        {{-- Row containing the blog post cards --}}
        {{-- Schema.org CollectionPage added via JSON-LD in the 'structured_data' section --}}
        <div class="row">
            {{-- Loop through the paginated blog posts for the current page --}}
            @foreach ($blogs as $blog)
                {{-- $blog->title: The title of the individual blog post. --}}
                {{-- $blog->featured_image: Path to the featured image relative to storage/app/public. --}}
                {{-- $blog->summary: A short summary of the post (if available). --}}
                {{-- $blog->content: The full content of the post (used as fallback for summary). --}}
                {{-- $blog->slug: The URL-friendly identifier for the post. --}}
                <div class="col-md-4 mb-4">
                    <div class="card h-100"> {{-- Bootstrap card styling --}}
                        {{-- Check if a featured image exists for the post --}}
                        @if ($blog->featured_image)
                            {{-- Blog Post Featured Image: Added loading="lazy" --}}
                            <img src="{{ asset('storage/' . $blog->featured_image) }}" {{-- Generates URL to image in public storage --}}
                                 class="card-img-top" {{-- Bootstrap class --}}
                                 alt="{{ e($blog->title) }}" {{-- Use post title as alt text, escaped --}}
                                 loading="lazy" {{-- Added Lazy Loading --}}
                                 onerror="this.onerror=null;this.src='{{ asset('assets/img/blog/blog-placeholder.png') }}';" {{-- Fallback image --}}
                                 {{-- width="350" height="200" --}} {{-- CRITICAL: Add actual width/height to prevent layout shift --}}
                                 />
                        @else
                             {{-- Optional: Display a placeholder if no image exists --}}
                             <img src="{{ asset('assets/img/blog/blog-placeholder.png') }}"
                                  class="card-img-top"
                                  alt="{{ e($blog->title) }}"
                                  loading="lazy"
                                  {{-- width="350" height="200" --}} {{-- Match dimensions of real images --}}
                                  />
                        @endif
                        <div class="card-body d-flex flex-column"> {{-- Added flex classes for button alignment --}}
                            {{-- Post Title (H5 is appropriate within a card) --}}
                            <h5 class="card-title">{{ e($blog->title) }}</h5>
                            {{-- Post Excerpt/Summary --}}
                            {{-- Uses summary if available, otherwise takes first 100 chars of content --}}
                            <p class="card-text">{{ Str::limit(strip_tags($blog->summary ?? $blog->content), 100) }}</p>
                            {{-- "Read More" Link - Pushed to bottom with mt-auto --}}
                            <a href="{{ route('blog.show', $blog->slug) }}" class="btn btn-primary mt-auto" aria-label="Read more about {{ e($blog->title) }}">Read Full Post</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination Links --}}
        <div class="d-flex justify-content-center mt-4"> {{-- Added margin top --}}
             {{-- $blogs->links(): Renders Laravel's pagination links --}}
             {{ $blogs->links() }}
        </div>

    @else
        {{-- Message displayed if no posts are found in this category --}}
        <p class="text-center mt-4">No articles found in the "{{ e($category->name) }}" category yet. Please check back later!</p>
         <div class="text-center mt-3">
             <a href="{{ route('blog.index') ?? url('/blog') }}" class="btn btn-secondary">View All Blog Posts</a>
         </div>
    @endif
</div>
@endsection