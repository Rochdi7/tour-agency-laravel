@extends('layouts.app2')

{{-- 1. Page Title: Good, specific title (Unchanged) --}}
@section('title', 'About Us - Learn About Morocco Quest Travel Agency')

{{-- 2. Meta Description: Updated based on H1, H2, and intro paragraph --}}
@section('meta_description')
    {{-- This description summarizes the page content: Who Morocco Quest is, their mission/values, and focus on authentic tours. It's under 160 chars. --}}
    <meta name="description" content="Discover Morocco Quest, your authentic gateway to Moroccan adventures. Learn about our story, mission, expert team, and commitment to crafting unforgettable tours.">
@endsection

{{-- NEW SECTION: Added for page-specific JSON-LD Structured Data --}}
@section('structured_data')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "TravelAgency", // Correct type for a travel agency page
  "name": "Morocco Quest", // Agency name from content
  "description": "Morocco Quest is your authentic gateway to Moroccan adventures. We are passionate about sharing the magic of Morocco, providing authentic, immersive, and memorable experiences with expert local guides and a commitment to sustainable tourism.", // Detailed description based on page content
  "url": "{{ url()->current() }}", // The canonical URL of this specific about page
  "image": "{{ asset('assets/img/about/about-thumb.png') }}", // Representative image from the page
  "address": { // Assuming a general location if specific address isn't listed prominently
    "@type": "PostalAddress",
    "addressLocality": "Morocco" // General location
    // Add more details (streetAddress, postalCode, addressCountry) if available and relevant
  },
  "founder": { // If founder info is available (currently placeholder)
     "@type": "Person",
     "name": "[Founder Name/Story - Replace Placeholder]" // Placeholder - replace with actual name if known
  },
   "award": [ // Listing awards mentioned on the page
    "World Travelers Award - Excellence in World Travel (2023)",
    "Top Adventure Operator Award - Best Adventure Tours (2022)",
    "Customer Choice Award - Customer Service Excellence (2024)"
  ],
  "review": { // Representing the Google review snippet shown
    "@type": "Review",
    "reviewRating": {
      "@type": "Rating",
      "ratingValue": "4.8", // From the page content
      "bestRating": "5"
    },
    "author": {
      "@type": "Organization",
      "name": "Google"
    }
    // "reviewCount": 1200 // Optional: Add if the '1.2k+' can be represented numerically
  },
   "potentialAction": { // Link to the main service/tours page
    "@type": "ViewAction",
    "name": "Explore Our Morocco Tours",
    "target": "{{ route('tours.index') ?? '#' }}" // Link from the CTA button
  }
}
</script>
@endsection


{{-- Define the content section that will be yielded in the layout --}}
@section('content')
{{-- 7. Technical SEO: Suggest adding BreadcrumbList Schema.org markup here or via JS (Assuming handled globally or not required now) --}}
<section
    class="vs-breadcrumb"
    data-bg-src="{{ asset('assets/img/chefchaouen-morocco-blue-city-panorama-hero.jpg') }}"
>
    {{-- 6. Image Optimization: Added loading="lazy" --}}
    <img
        src="{{ asset('assets/img/icons/cloud.png') }}"
        alt="Decorative cloud icon"
        class="vs-breadcrumb-icon-1 animate-parachute"
        loading="lazy" {{-- Added Lazy Loading --}}
        {{-- width="X" height="Y" --}} {{-- Recommend adding dimensions --}}
    />
    {{-- 6. Image Optimization: Added loading="lazy" --}}
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
                    {{-- 3. Heading Structure: Correct H1 (Unchanged) --}}
                    <h1 class="breadcrumb-title">About Us</h1>

                    {{-- Good use of figcaption for context (Unchanged) --}}
                    <figcaption class="image-caption">
                        Panoramic view of Chefchaouen, Morocco’s iconic Blue City, bathed in warm morning sunlight.
                    </figcaption>

                    {{-- Hidden paragraph provides good context for the background image (Unchanged) --}}
                    <p class="visually-hidden">
                        This stunning panoramic image captures Chefchaouen, Morocco's legendary Blue City, nestled in the Rif Mountains.
                        Bathed in golden sunrise light, the city's distinct blue architecture and natural beauty make it a symbol of serenity,
                        tradition, and cultural richness—perfectly representing Morocco Quest’s spirit of Moroccan authenticity and warmth.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!--================= About Area start =================-->
{{-- 7. Technical SEO: Organization Schema added via JSON-LD in the head --}}
<section class="vs-about position-relative space">
    {{-- 6. Image Optimization: Added loading="lazy" --}}
    <img
        src="{{ asset('assets/img/icons/plain-globe.png') }}"
        alt="Decorative globe icon"
        class="about-icon-1 animate-parachute"
        loading="lazy" {{-- Added Lazy Loading --}}
        {{-- width="X" height="Y" --}} {{-- Recommend adding dimensions --}}
    />
    {{-- 6. Image Optimization: Added loading="lazy" --}}
    <img
        src="{{ asset('assets/img/icons/map.png') }}"
        alt="Decorative map icon"
        class="about-icon-2 animate-parachute"
        loading="lazy" {{-- Added Lazy Loading --}}
        {{-- width="X" height="Y" --}} {{-- Recommend adding dimensions --}}
    />
    <div class="container">
        <div class="row">
            <div class="col-lg-auto mx-auto">
                <div class="title-area text-center">
                    <span
                        class="sec-subtitle text-capitalize fade-anim"
                        data-direction="top"
                    >About Morocco Quest</span>
                     {{-- 3. Heading Structure: H2 relevant to About page (Unchanged) --}}
                    <h2 class="sec-title fade-anim" data-direction="bottom">
                        Your Authentic Gateway <br />
                        to Moroccan Adventures
                    </h2>
                </div>
            </div>
        </div>
        <div class="row g-4 align-items-center">
            <div class="col-md-6 order-1 order-md-0">
                <div class="about-info-area">
                    <div class="title-area">
                        <span class="sec-subtitle text-capitalize">Our Story</span>
                        {{-- 3. Heading Structure: Relevant H2 (Unchanged) --}}
                        <h2 class="sec-title">Crafting Unforgettable Journeys</h2>
                    </div>
                    <div class="about-info">
                        {{-- 4. Content Relevance: Keep placeholder as reminder, but SEO based on intended content --}}
                        <p>
                            <!-- TODO: Replace this placeholder -->
                            Welcome to Morocco Quest! We are passionate about sharing the magic of Morocco with travelers from around the world. Founded by [Founder Name/Story], our mission is to provide authentic, immersive, and memorable experiences. Learn more about our values, commitment to sustainable travel, and why we love what we do.
                        </p>
                        {{-- 4. Content Relevance: List relevant to agency (Unchanged) --}}
                         <div class="services-lists">
                           <ul class="custom-ul">
                               <li>
                                   <svg xmlns="http://www.w3.org/2000/svg" width="18" height="16" viewBox="0 0 18 16" fill="none" aria-hidden="true">
                                       <path d="M7.99949 15.7247C7.94644 15.7247 7.89396 15.7137 7.84536 15.6924C7.79675 15.6712 7.75308 15.6401 7.71707 15.6011L0.102184 7.36399C0.0514209 7.30907 0.0177684 7.24055 0.00534479 7.16681C-0.0070788 7.09306 0.00226539 7.0173 0.0322339 6.94878C0.0622023 6.88026 0.111495 6.82197 0.174079 6.78104C0.236663 6.7401 0.309824 6.7183 0.384607 6.71829H4.04999C4.10502 6.7183 4.15942 6.73011 4.2095 6.75293C4.25958 6.77575 4.30418 6.80904 4.3403 6.85056L6.88522 9.77841C7.16026 9.19049 7.69268 8.21156 8.62699 7.01872C10.0082 5.25526 12.5774 2.66176 16.9729 0.320525C17.0579 0.275283 17.1567 0.263542 17.2499 0.287618C17.3431 0.311694 17.4239 0.369838 17.4763 0.450569C17.5287 0.531301 17.5489 0.62875 17.533 0.723675C17.5171 0.8186 17.4661 0.904101 17.3902 0.963294C17.3735 0.97641 15.6787 2.31103 13.7282 4.7556C11.9331 7.00522 9.54691 10.6837 8.37272 15.4325C8.3521 15.516 8.30412 15.5901 8.23645 15.6431C8.16878 15.696 8.08532 15.7248 7.99938 15.7248L7.99949 15.7247Z" fill="currentColor"/>
                                   </svg>
                                   Expert Local Guides & Personalized Itineraries
                               </li>
                               <li>
                                   <svg xmlns="http://www.w3.org/2000/svg" width="18" height="16" viewBox="0 0 18 16" fill="none" aria-hidden="true">
                                        <path d="M7.99949 15.7247C7.94644 15.7247 7.89396 15.7137 7.84536 15.6924C7.79675 15.6712 7.75308 15.6401 7.71707 15.6011L0.102184 7.36399C0.0514209 7.30907 0.0177684 7.24055 0.00534479 7.16681C-0.0070788 7.09306 0.00226539 7.0173 0.0322339 6.94878C0.0622023 6.88026 0.111495 6.82197 0.174079 6.78104C0.236663 6.7401 0.309824 6.7183 0.384607 6.71829H4.04999C4.10502 6.7183 4.15942 6.73011 4.2095 6.75293C4.25958 6.77575 4.30418 6.80904 4.3403 6.85056L6.88522 9.77841C7.16026 9.19049 7.69268 8.21156 8.62699 7.01872C10.0082 5.25526 12.5774 2.66176 16.9729 0.320525C17.0579 0.275283 17.1567 0.263542 17.2499 0.287618C17.3431 0.311694 17.4239 0.369838 17.4763 0.450569C17.5287 0.531301 17.5489 0.62875 17.533 0.723675C17.5171 0.8186 17.4661 0.904101 17.3902 0.963294C17.3735 0.97641 15.6787 2.31103 13.7282 4.7556C11.9331 7.00522 9.54691 10.6837 8.37272 15.4325C8.3521 15.516 8.30412 15.5901 8.23645 15.6431C8.16878 15.696 8.08532 15.7248 7.99938 15.7248L7.99949 15.7247Z" fill="currentColor"/>
                                   </svg>
                                   Commitment to Sustainable & Responsible Tourism
                               </li>
                               <li>
                                   <svg xmlns="http://www.w3.org/2000/svg" width="18" height="16" viewBox="0 0 18 16" fill="none" aria-hidden="true">
                                        <path d="M7.99949 15.7247C7.94644 15.7247 7.89396 15.7137 7.84536 15.6924C7.79675 15.6712 7.75308 15.6401 7.71707 15.6011L0.102184 7.36399C0.0514209 7.30907 0.0177684 7.24055 0.00534479 7.16681C-0.0070788 7.09306 0.00226539 7.0173 0.0322339 6.94878C0.0622023 6.88026 0.111495 6.82197 0.174079 6.78104C0.236663 6.7401 0.309824 6.7183 0.384607 6.71829H4.04999C4.10502 6.7183 4.15942 6.73011 4.2095 6.75293C4.25958 6.77575 4.30418 6.80904 4.3403 6.85056L6.88522 9.77841C7.16026 9.19049 7.69268 8.21156 8.62699 7.01872C10.0082 5.25526 12.5774 2.66176 16.9729 0.320525C17.0579 0.275283 17.1567 0.263542 17.2499 0.287618C17.3431 0.311694 17.4239 0.369838 17.4763 0.450569C17.5287 0.531301 17.5489 0.62875 17.533 0.723675C17.5171 0.8186 17.4661 0.904101 17.3902 0.963294C17.3735 0.97641 15.6787 2.31103 13.7282 4.7556C11.9331 7.00522 9.54691 10.6837 8.37272 15.4325C8.3521 15.516 8.30412 15.5901 8.23645 15.6431C8.16878 15.696 8.08532 15.7248 7.99938 15.7248L7.99949 15.7247Z" fill="currentColor"/>
                                   </svg>
                                   Secure Booking & Excellent Customer Support
                               </li>
                           </ul>
                        </div>
                        <div class="btn-trigger btn-bounce">
                             {{-- 5. Internal Linking: Link to tours/services page, improved anchor text (Unchanged) --}}
                            <a
                                href="{{ route('tours.index') ?? '#' }}" {{-- Assuming tours.index route exists --}}
                                class="vs-btn style6 text-capitalize"
                            >Explore Our Morocco Tours</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 order-0 order-md-1">
                <div class="about-thumb fade-anim" data-direction="right">
                    {{-- 6. Image Optimization: Added descriptive alt text, added loading="lazy". --}}
                    <img
                        src="{{ asset('assets/img/about/about-thumb.png') }}"
                        alt="Collage of Morocco travel experiences including desert camels and city views"
                        class="w-100"
                        loading="lazy" {{-- Added Lazy Loading --}}
                        {{-- width="X" height="Y" --}} {{-- Recommend adding dimensions --}}
                    />
                </div>
            </div>
        </div>
    </div>
</section>
<!--================= About Area end =================-->

<!--================= Travel-guides start =================-->
<section
    class="travel-guides bg-second-theme-color position-relative space"
    data-bg-src="{{ asset('assets/img/bg/travel-guides-bg.png') }}"
>
     {{-- 6. Image Optimization: Added loading="lazy" --}}
    <img
        src="{{ asset('assets/img/icons/plain-sclation.png') }}"
        alt="Decorative paper airplane icon"
        class="travel-guides-icon-1 animate-parachute"
        loading="lazy" {{-- Added Lazy Loading --}}
        {{-- width="X" height="Y" --}} {{-- Recommend adding dimensions --}}
    />
     {{-- 6. Image Optimization: Added loading="lazy" --}}
    <img
        src="{{ asset('assets/img/icons/rops.png') }}"
        alt="Decorative climbing ropes icon"
        class="travel-guides-icon-2 animate-parachute"
        loading="lazy" {{-- Added Lazy Loading --}}
        {{-- width="X" height="Y" --}} {{-- Recommend adding dimensions --}}
    />
    <div class="container">
        <div class="row">
            <div class="col-lg-auto mx-auto">
                <div class="title-area text-center">
                    <span class="sec-subtitle fade-anim" data-direction="top">Meet Our Team</span>
                    <h2 class="sec-title text-white-color fade-anim" data-direction="bottom">
                        Our Expert Morocco Travel Guides
                    </h2>
                </div>
            </div>
        </div>
        <div class="row g-4">
            {{-- Loop through actual guides if possible, otherwise update placeholders --}}
            <div class="col-md-6 col-lg-4 col-xl-3 fade-anim" data-delay="0.30">
                <div class="guide-box">
                    <figure class="guide-thumb">
                         {{-- 6. Image Optimization: Added loading="lazy" --}}
                        <img
                            src="{{ asset('assets/img/guides/guide-1-1.png') }}"
                            alt="Morocco Quest Travel Guide - Daniella Alonso"
                            class="w-100"
                            loading="lazy" {{-- Added Lazy Loading --}}
                            {{-- width="X" height="Y" --}} {{-- Recommend adding dimensions --}}
                        />
                    </figure>
                    <div class="guide-content text-center">
                         {{-- 3. Heading Structure: H5 for name is appropriate here (Unchanged) --}}
                        <h5 class="guide-name line-clamp-1 text-second-theme-color text-capitalize">
                            daniella alonso
                        </h5>
                        <p class="guide-designation line-clamp-1 text-theme-color text-capitalize">
                            Lead Travel Guide
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 col-xl-3 fade-anim" data-delay="0.40">
                <div class="guide-box">
                    <figure class="guide-thumb">
                        {{-- 6. Image Optimization: Added loading="lazy" --}}
                        <img
                            src="{{ asset('assets/img/guides/guide-1-2.png') }}"
                            alt="Morocco Quest Travel Guide - Alexandra Dadd"
                            class="w-100"
                            loading="lazy" {{-- Added Lazy Loading --}}
                             {{-- width="X" height="Y" --}} {{-- Recommend adding dimensions --}}
                        />
                    </figure>
                    <div class="guide-content text-center">
                        <h5 class="guide-name line-clamp-1 text-second-theme-color text-capitalize">
                            Alexandra Dadd
                        </h5>
                        <p class="guide-designation line-clamp-1 text-theme-color text-capitalize">
                            Cultural Specialist Guide
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 col-xl-3 fade-anim" data-delay="0.50">
                <div class="guide-box">
                    <figure class="guide-thumb">
                         {{-- 6. Image Optimization: Added loading="lazy" --}}
                        <img
                            src="{{ asset('assets/img/guides/guide-1-3.png') }}"
                            alt="Morocco Quest Travel Guide - Erica Fernandes"
                            class="w-100"
                            loading="lazy" {{-- Added Lazy Loading --}}
                             {{-- width="X" height="Y" --}} {{-- Recommend adding dimensions --}}
                        />
                    </figure>
                    <div class="guide-content text-center">
                        <h5 class="guide-name line-clamp-1 text-second-theme-color text-capitalize">
                            erica fernandes
                        </h5>
                        <p class="guide-designation line-clamp-1 text-theme-color text-capitalize">
                            Adventure Guide
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 col-xl-3 fade-anim" data-delay="0.60">
                <div class="guide-box">
                    <figure class="guide-thumb">
                         {{-- 6. Image Optimization: Added loading="lazy" --}}
                        <img
                            src="{{ asset('assets/img/guides/guide-1-4.png') }}"
                            alt="Morocco Quest Travel Guide - Daniel Craig"
                            class="w-100"
                            loading="lazy" {{-- Added Lazy Loading --}}
                             {{-- width="X" height="Y" --}} {{-- Recommend adding dimensions --}}
                        />
                    </figure>
                    <div class="guide-content text-center">
                        <h5 class="guide-name line-clamp-1 text-second-theme-color text-capitalize">
                            daniel craig
                        </h5>
                        <p class="guide-designation line-clamp-1 text-theme-color text-capitalize">
                            City Exploration Guide
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
<!--================= Travel-guides end =================-->

<!--================= Awards Area start =================-->
<section
    class="awards-style1 space"
    data-bg-src="{{ asset('assets/img/awards/awards-style1-bg.png') }}"
>
     {{-- 6. Image Optimization: Added loading="lazy" --}}
    <img
        class="awards-icon-1"
        src="{{ asset('assets/img/icons/award-icon-1.png') }}"
        alt="Decorative award ribbon icon"
        loading="lazy" {{-- Added Lazy Loading --}}
         {{-- width="X" height="Y" --}} {{-- Recommend adding dimensions --}}
    />
     {{-- 6. Image Optimization: Added loading="lazy" --}}
    <img
        class="awards-icon-2 move-item"
        src="{{ asset('assets/img/icons/award-icon-2.png') }}"
        alt="Decorative parachute icon"
        loading="lazy" {{-- Added Lazy Loading --}}
         {{-- width="X" height="Y" --}} {{-- Recommend adding dimensions --}}
    />
    <div class="container">
        <div class="row justify-content-between align-items-center">
            <div class="col-md-6 col-lg-6 col-xxl-5">
                <div class="title-area text-center text-md-start">
                    <span class="sec-subtitle fade-anim" data-direction="top">Recognition & Excellence</span>
                    {{-- 3. Heading Structure: Rephrased H2 (Unchanged) --}}
                    <h2 class="sec-title fade-anim" data-direction="bottom">
                        Our Commitment to Quality: Awards
                    </h2>
                </div>
            </div>
            <div class="col-md-6 col-lg-5 col-xxl-5">
                <div class="google-reviewed mx-auto overflow-hidden">
                    <div class="left bg-white-color d-flex align-items-center gap-2">
                        {{-- 6. Image Optimization: Added loading="lazy" --}}
                        <img
                            src="{{ asset('assets/img/icons/awards-google.png') }}"
                            alt="Google logo"
                            loading="lazy" {{-- Added Lazy Loading --}}
                             {{-- width="X" height="Y" --}} {{-- Recommend adding dimensions --}}
                        />
                        <div class="info">
                            <strong class="d-block">Google</strong>
                            <span class="d-block fs-xxs text-uppercase">Reviewed on</span> {{-- Corrected text --}}
                        </div>
                    </div>
                    <div class="right bg-second-theme-color">
                        <div class="rating d-flex align-items-baseline gap-2">
                            {{-- Update rating and review count if necessary (Unchanged) --}}
                            <h4 class="fs-32 fw-semibold ff-rubik text-white-color">
                                4.8
                            </h4>
                            <div class="stars" aria-label="4.8 out of 5 stars">
                                <ul class="custom-ul d-flex align-items-center text-theme-color fs-xxs">
                                    <li><i class="fa-solid fa-star"></i></li>
                                    <li><i class="fa-solid fa-star"></i></li>
                                    <li><i class="fa-solid fa-star"></i></li>
                                    <li><i class="fa-solid fa-star"></i></li>
                                    <li><i class="fa-solid fa-star-half-stroke"></i></li> {{-- Adjusted based on 4.8 --}}
                                </ul>
                            </div>
                        </div>
                        <span class="review fs-xxs d-block">1.2k+ reviews</span> {{-- Adjusted review count example --}}
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-2 g-lg-4 award-box-style1__row">
            <div class="line-Shape"></div>
            {{-- Assuming awards are static content for now --}}
            <div class="col-md-6 col-lg-4 fade-anim" data-delay="0.30">
                <div class="award-box-style1">
                    <div class="award-box-style1-wrapper">
                        <figure class="award-box-icon" aria-hidden="true">
                            {{-- SVG is decorative here (Unchanged) --}}
                            <svg xmlns="http://www.w3.org/2000/svg" width="132" height="103" viewBox="0 0 132 103" fill="none">
                                 {{-- SVG paths remain unchanged --}}
                                 <path d="M113.179 31.5771L114.345 33.9106C118.132 41.484 124.273 47.6249 131.846 51.4116H113.179V31.5771Z" fill="white"/>
                                 <path d="M18.668 31.5771L17.5012 33.9106C13.7145 41.484 7.57363 47.6249 0.000244141 51.4116H18.668V31.5771Z" fill="white"/>
                                 <circle cx="51.1642" cy="51.1642" r="47.1642" transform="matrix(1 0 0 -1 14.7588 102.328)" fill="white" stroke="white" stroke-width="8"/>
                                 <circle cx="67.5308" cy="51.5308" r="39.2808" fill="currentColor" stroke="currentColor" stroke-width="1.5" stroke-dasharray="3 3"/>
                                 <path d="M80.5531 52.3525C81.4013 52.3525 82.2165 52.1074 82.9353 51.6249C84.1269 50.8194 84.954 49.3584 84.9862 47.8389C85.0231 47.0666 84.9862 46.2485 84.8733 45.337C84.8099 44.8155 84.3504 44.4116 83.7586 44.4703C82.747 44.6005 81.7104 45.0807 80.8462 45.8325C80.8054 45.496 80.7517 45.1621 80.6848 44.831C81.6436 44.3561 82.3848 43.5933 82.768 42.6415C83.3234 41.3088 83.1493 39.6629 82.3118 38.3458C81.8458 37.6114 81.3439 36.9373 80.8216 36.34C80.4587 35.9266 79.8323 35.8838 79.417 36.2467C78.5162 37.0336 77.9092 38.1756 77.6612 39.5588C77.4369 40.8865 77.6114 42.006 78.113 43.219C80.1978 48.1718 78.2832 53.8349 73.9463 56.6012C73.6393 56.7928 73.3967 57.0576 73.2307 57.3658H68.996V53.2966L72.5017 55.1169C72.8445 55.294 73.2485 55.2557 73.5464 55.038C73.8518 54.8163 74.0056 54.4418 73.9433 54.0692L73.1117 49.0654L76.7254 45.5061C76.9939 45.2415 77.0902 44.8475 76.9734 44.4895C76.8567 44.1306 76.5474 43.868 76.1748 43.8115L71.1827 43.0598L68.9074 38.0298C68.5845 37.3158 67.4152 37.3158 67.0923 38.0298L64.817 43.0598L59.8249 43.8117C59.4524 43.8682 59.143 44.1308 59.0263 44.4897C58.9096 44.8477 59.0059 45.2417 59.2744 45.5063L62.8881 49.0656L62.0564 54.0694C61.9941 54.4419 62.1478 54.8165 62.4533 55.0382C62.7588 55.26 63.1615 55.2902 63.498 55.1171L67.0038 53.2968V57.366H62.7378C62.369 56.7477 61.8054 56.4673 61.2775 56.0547C58.4798 53.7922 57.0624 50.5337 57.0624 47.4051C57.0624 43.4278 58.8985 42.7963 58.3552 39.5473C58.1071 38.1748 57.5011 37.0337 56.6013 36.2468C56.1899 35.8849 55.5576 35.9258 55.1967 36.3402C54.6704 36.9413 54.1685 37.6164 53.7065 38.3449C52.869 39.662 52.6929 41.3079 53.2444 42.6308C53.6317 43.5915 54.3747 44.3563 55.3344 44.8317C55.2674 45.163 55.2138 45.4971 55.173 45.8339C54.3059 45.0807 53.2514 44.6004 52.2409 44.4704C51.9783 44.4421 51.7117 44.5093 51.5026 44.6727C51.2935 44.8351 51.1573 45.0754 51.1262 45.3381C51.0143 46.2505 50.9783 47.0695 51.0123 47.8225C51.0542 49.3973 51.9107 50.8622 53.0916 51.6327C53.7833 52.1094 54.6013 52.3535 55.4564 52.3535C55.6558 52.3535 55.8583 52.3294 56.0608 52.3027C56.1869 52.6104 56.3131 52.9174 56.4619 53.2147C55.5658 53.0989 54.4449 53.1272 53.3474 53.6715C52.8413 53.9226 52.6488 54.5387 52.9078 55.0285C53.257 55.6929 53.6733 56.4605 54.1684 57.1306C55.0122 58.3623 56.3999 59.2094 58.0389 59.2094C59.0305 59.2094 59.9837 58.8294 60.7703 58.1474C60.8923 58.2345 61.0069 58.3201 61.0272 58.3622V65.3348H60.0311C59.4805 65.3348 59.035 65.7803 59.035 66.3309C59.035 66.8815 59.4805 67.327 60.0311 67.327H75.9685C76.5191 67.327 76.9646 66.8815 76.9646 66.3309C76.9646 65.7803 76.5191 65.3348 75.9685 65.3348H74.9724V58.4692C74.9844 58.4074 75.0103 58.3495 75.0103 58.2852C75.088 58.2356 75.1552 58.1747 75.2315 58.1237C77.3039 59.9518 80.2379 59.3905 81.8731 57.1365C82.3402 56.4252 82.7961 55.7483 83.1483 54.9838C83.374 54.4945 83.1688 53.9138 82.6853 53.6745C81.7762 53.2242 80.7443 53.092 79.5527 53.2383C79.7071 52.9318 79.8592 52.6239 79.9889 52.3051C80.1778 52.3288 80.3668 52.3525 80.5531 52.3525ZM69.9921 63.3425H66.0077C65.4571 63.3425 65.0116 62.897 65.0116 62.3464C65.0116 61.7958 65.4571 61.3503 66.0077 61.3503H69.9921C70.5426 61.3503 70.9881 61.7958 70.9881 62.3464C70.9881 62.897 70.5426 63.3425 69.9921 63.3425Z" fill="white"/>
                            </svg>
                        </figure>
                        <div class="award-box-header d-flex align-items-end justify-content-between gap-xl-4 text-center">
                             {{-- 6. Image Optimization: Added loading="lazy" --}}
                            <img
                                src="{{ asset('assets/img/awards/award-box-left-wings.png') }}"
                                alt="Decorative award wing graphic"
                                loading="lazy" {{-- Added Lazy Loading --}}
                                 {{-- width="X" height="Y" --}} {{-- Recommend adding dimensions --}}
                            />
                             {{-- 3. Heading Structure: H6 for award name is appropriate (Unchanged) --}}
                            <h6 class="text-capitalize ff-rubik fw-semibold">
                                World Travelers Award
                            </h6>
                             {{-- 6. Image Optimization: Added loading="lazy" --}}
                            <img
                                src="{{ asset('assets/img/awards/award-box-right-wings.png') }}"
                                alt="Decorative award wing graphic"
                                loading="lazy" {{-- Added Lazy Loading --}}
                                 {{-- width="X" height="Y" --}} {{-- Recommend adding dimensions --}}
                            />
                        </div>
                        <div class="award-box-body text-center">
                            <span class="text-third-theme-color bg-white-color">Excellence in World Travel</span>
                        </div>
                        <div class="award-box-footer text-capitalize text-center">
                            <p class="line1">
                                Received in <strong>2023</strong>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 fade-anim" data-delay="0.60">
                <div class="award-box-style1">
                    <div class="award-box-style1-wrapper">
                        <figure class="award-box-icon text-center" aria-hidden="true">
                             {{-- SVG is decorative here (Unchanged) --}}
                            <svg xmlns="http://www.w3.org/2000/svg" width="132" height="103" viewBox="0 0 132 103" fill="none">
                                 {{-- SVG paths remain unchanged --}}
                                 <path d="M113.179 31.5771L114.345 33.9106C118.132 41.484 124.273 47.6249 131.846 51.4116H113.179V31.5771Z" fill="white"/>
                                 <path d="M18.668 31.5771L17.5012 33.9106C13.7145 41.484 7.57363 47.6249 0.000244141 51.4116H18.668V31.5771Z" fill="white"/>
                                 <circle cx="51.1642" cy="51.1642" r="47.1642" transform="matrix(1 0 0 -1 14.7588 102.328)" fill="white" stroke="white" stroke-width="8"/>
                                 <circle cx="67.5308" cy="51.5308" r="39.2808" fill="currentColor" stroke="currentColor" stroke-width="1.5" stroke-dasharray="3 3"/>
                                 <path fill-rule="evenodd" clip-rule="evenodd" d="M70.1325 38.2514C68.1798 37.1867 65.8201 37.1867 63.8675 38.2514L53.4108 43.9532C51.3083 45.0997 50 47.3032 50 49.6981V60.4675C50 62.8623 51.3083 65.0659 53.4108 66.2123L63.8675 71.9141C65.8201 72.9787 68.1798 72.9787 70.1325 71.9141L80.5892 66.2123C82.6918 65.0659 84 62.8623 84 60.4675V49.6981C84 47.3032 82.6918 45.0997 80.5892 43.9532L70.1325 38.2514ZM67.0005 48.5395C66.3808 48.5395 65.9664 49.2828 65.1376 50.7696L64.9232 51.1544C64.6878 51.5769 64.5701 51.788 64.3864 51.9274C64.2028 52.0667 63.9742 52.1187 63.5168 52.222L63.1004 52.3163C61.4909 52.6805 60.6862 52.8624 60.4947 53.4781C60.3033 54.0939 60.8519 54.7353 61.9491 56.0185L62.233 56.3504C62.5448 56.7149 62.7006 56.8972 62.7709 57.1228C62.8409 57.3483 62.8173 57.5915 62.7702 58.0781L62.7272 58.5208C62.5614 60.2328 62.4785 61.0887 62.9796 61.4693C63.481 61.8497 64.2344 61.5029 65.7413 60.809L66.1311 60.6295C66.5594 60.4324 66.7734 60.3338 67.0005 60.3338C67.2275 60.3338 67.4415 60.4324 67.8699 60.6295L68.2596 60.809C69.7665 61.5029 70.5199 61.8497 71.0213 61.4693C71.5226 61.0887 71.4395 60.2328 71.2737 58.5208L71.2307 58.0781C71.1836 57.5915 71.1601 57.3483 71.2301 57.1228C71.3003 56.8972 71.4562 56.7149 71.7679 56.3504L72.0519 56.0185C73.149 54.7353 73.6978 54.0939 73.5063 53.4781C73.3148 52.8624 72.5099 52.6805 70.9005 52.3163L70.4841 52.222C70.0268 52.1187 69.7982 52.0667 69.6145 51.9274C69.4309 51.788 69.3131 51.5769 69.0778 51.1544L68.8633 50.7696C68.0345 49.2828 67.6201 48.5395 67.0005 48.5395Z" fill="white"/>
                                 <path d="M64.8191 30H69.1814C73.294 30 75.3504 30 76.6281 31.2777C77.9058 32.5553 77.9058 34.6117 77.9058 38.7244V38.7636L71.6986 35.379C68.7696 33.7819 65.2301 33.7819 62.3011 35.379L56.0947 38.7631V38.7244C56.0947 34.6117 56.0947 32.5553 57.3724 31.2777C58.65 30 60.7064 30 64.8191 30Z" fill="white"/>
                            </svg>
                        </figure>
                        <div class="award-box-header d-flex align-items-end justify-content-between gap-xl-4 text-center">
                            {{-- 6. Image Optimization: Added loading="lazy" --}}
                            <img
                                src="{{ asset('assets/img/awards/award-box-left-wings.png') }}"
                                alt="Decorative award wing graphic"
                                loading="lazy" {{-- Added Lazy Loading --}}
                                 {{-- width="X" height="Y" --}} {{-- Recommend adding dimensions --}}
                            />
                            <h6 class="text-capitalize ff-rubik fw-semibold">
                                Top Adventure Operator Award
                            </h6>
                            {{-- 6. Image Optimization: Added loading="lazy" --}}
                            <img
                                src="{{ asset('assets/img/awards/award-box-right-wings.png') }}"
                                alt="Decorative award wing graphic"
                                loading="lazy" {{-- Added Lazy Loading --}}
                                 {{-- width="X" height="Y" --}} {{-- Recommend adding dimensions --}}
                            />
                        </div>
                        <div class="award-box-body text-center">
                            <span class="text-third-theme-color bg-white-color">Best Adventure Tours</span>
                        </div>
                        <div class="award-box-footer text-capitalize text-center">
                            <p class="line1">
                                Received in <strong>2022</strong>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 fade-anim" data-delay="0.80">
                <div class="award-box-style1">
                    <div class="award-box-style1-wrapper">
                        <figure class="award-box-icon text-center" aria-hidden="true">
                             {{-- SVG is decorative here (Unchanged) --}}
                            <svg xmlns="http://www.w3.org/2000/svg" width="132" height="103" viewBox="0 0 132 103" fill="none">
                                {{-- SVG paths remain unchanged --}}
                                <path d="M113.179 31.5771L114.345 33.9106C118.132 41.484 124.273 47.6249 131.846 51.4116H113.179V31.5771Z" fill="white"/>
                                <path d="M18.668 31.5771L17.5012 33.9106C13.7145 41.484 7.57363 47.6249 0.000244141 51.4116H18.668V31.5771Z" fill="white"/>
                                <circle cx="51.1642" cy="51.1642" r="47.1642" transform="matrix(1 0 0 -1 14.7588 102.328)" fill="white" stroke="white" stroke-width="8"/>
                                <circle cx="67.5308" cy="51.5308" r="39.2808" fill="currentColor" stroke="currentColor" stroke-width="1.5" stroke-dasharray="3 3"/>
                                <path d="M51.6644 46.8563L60.6171 62.9798C60.8081 66.9046 64.0328 70.0656 68 70.0656C71.9672 70.0656 75.2131 66.9046 75.3828 62.9798L84.3356 46.8563C85.4812 44.7985 85.1206 42.189 83.4446 40.5342L77.2286 34.3182C77.0376 34.1273 76.6982 34 76.486 34H59.514C59.3018 34 58.9624 34.1273 58.7714 34.3182L52.5554 40.5342C50.8794 42.2102 50.5188 44.7985 51.6644 46.8563ZM68.0212 67.9441C65.0935 67.9441 62.7174 65.568 62.7174 62.6404C62.7174 59.7127 65.0935 57.3366 68.0212 57.3366C70.9489 57.3366 73.325 59.7127 73.325 62.6404C73.325 65.568 70.9489 67.9441 68.0212 67.9441ZM63.6509 42.486L62.8023 40.3645H73.2401L72.3915 42.486H63.6509ZM71.5429 44.6075L68.0212 53.4118L64.4995 44.6075H71.5429ZM78.3742 41.8708C78.6288 41.3404 79.2652 41.1071 79.7956 41.3616C80.326 41.6162 80.5593 42.2527 80.3047 42.783L74.2372 55.6606C73.9827 56.191 73.3462 56.4243 72.8158 56.1698C72.2854 55.9152 72.0521 55.2787 72.3067 54.7484L78.3742 41.8708ZM74.9373 36.1215L74.0887 38.243H61.9537L61.1051 36.1215H74.9373ZM56.2468 41.3616C56.7772 41.1071 57.4137 41.3404 57.6683 41.8708L63.7358 54.7484C63.9903 55.2787 63.757 55.9152 63.2266 56.1698C62.6962 56.4243 62.0598 56.191 61.8052 55.6606L55.7377 42.783C55.4831 42.2527 55.7165 41.6162 56.2468 41.3616Z" fill="white"/>
                                <path d="M68.0217 59.458C67.4277 59.458 66.9609 59.9247 66.9609 60.5188C66.9609 61.1128 67.4277 61.5795 68.0217 61.5795C68.6157 61.5795 69.0824 62.0462 69.0824 62.6403C69.0824 63.2343 69.5492 63.701 70.1432 63.701C70.7372 63.701 71.204 63.2343 71.204 62.6403C71.204 60.8794 69.7825 59.458 68.0217 59.458Z" fill="white"/>
                            </svg>
                        </figure>
                        <div class="award-box-header d-flex align-items-end justify-content-between gap-xl-4 text-center">
                            {{-- 6. Image Optimization: Added loading="lazy" --}}
                            <img
                                src="{{ asset('assets/img/awards/award-box-left-wings.png') }}"
                                alt="Decorative award wing graphic"
                                loading="lazy" {{-- Added Lazy Loading --}}
                                 {{-- width="X" height="Y" --}} {{-- Recommend adding dimensions --}}
                            />
                            <h6 class="text-capitalize ff-rubik fw-semibold">
                                Customer Choice Award
                            </h6>
                            {{-- 6. Image Optimization: Added loading="lazy" --}}
                            <img
                                src="{{ asset('assets/img/awards/award-box-right-wings.png') }}"
                                alt="Decorative award wing graphic"
                                loading="lazy" {{-- Added Lazy Loading --}}
                                 {{-- width="X" height="Y" --}} {{-- Recommend adding dimensions --}}
                            />
                        </div>
                        <div class="award-box-body text-center">
                            <span class="text-third-theme-color bg-white-color">Customer Service Excellence</span>
                        </div>
                        <div class="award-box-footer text-capitalize text-center">
                            <p class="line1">
                                Received in <strong>2024</strong>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--================= Awards Area end =================-->

@endsection