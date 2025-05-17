@extends('layouts.app2')

{{-- 1. Page Title: Good, specific title (Unchanged) --}}
@section('title', 'About Us - Learn About Morocco Quest Travel Agency')

{{-- 2. Meta Description: Updated based on H1, H2, and intro paragraph --}}
@section('meta_description')
    {{-- This description summarizes the page content: Who Morocco Quest is, their mission/values, and focus on authentic
    tours. It's under 160 chars. --}}
    <meta name="description"
        content="Discover Morocco Quest, your authentic gateway to Moroccan adventures. Learn about our story, mission, expert team, and commitment to crafting unforgettable tours.">
@endsection
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

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
    {{-- 7. Technical SEO: Suggest adding BreadcrumbList Schema.org markup here or via JS (Assuming handled globally or not
    required now) --}}
    <section class="vs-breadcrumb" data-bg-src="{{ asset('assets/img/chefchaouen-morocco-blue-city-panorama-hero.webp') }}">
        <img src="{{ asset('assets/img/icons/cloud.png') }}" alt="Decorative cloud icon"
            class="vs-breadcrumb-icon-1 animate-parachute" loading="lazy" />

        <img src="{{ asset('assets/img/icons/ballon-sclation.png') }}" alt="Decorative hot air balloon icon"
            class="vs-breadcrumb-icon-2 animate-parachute" loading="lazy" />

        <div class="container">
            <div class="row text-center">
                <div class="col-12">
                    <div class="breadcrumb-content">
                        <h1 class="breadcrumb-title">About Us</h1>
                        <p class="breadcrumb-subtitle" style="color: white;">
                            Discover the authentic Moroccan experience with us.
                        </p>

                        <figcaption class="image-caption visually-hidden">
                            Panoramic view of Chefchaouen, Morocco’s iconic Blue City, bathed in warm morning sunlight.
                        </figcaption>

                        <p class="visually-hidden">
                            This stunning panoramic image captures Chefchaouen, Morocco's legendary Blue City, nestled in
                            the Rif Mountains. Bathed in golden sunrise light, the city's distinct blue architecture and
                            natural beauty make it
                            a symbol of serenity, tradition, and cultural richness—perfectly representing Morocco Quest’s
                            spirit of Moroccan
                            authenticity and warmth.
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
        <img src="{{ asset('assets/img/icons/plain-globe.png') }}" alt="Decorative globe icon"
            class="about-icon-1 animate-parachute" loading="lazy" {{-- Added Lazy Loading --}} {{-- width="X" height="Y"
            --}} {{-- Recommend adding dimensions --}} />
        {{-- 6. Image Optimization: Added loading="lazy" --}}
        <img src="{{ asset('assets/img/icons/map.png') }}" alt="Decorative map icon" class="about-icon-2 animate-parachute"
            loading="lazy" {{-- Added Lazy Loading --}} {{-- width="X" height="Y" --}} {{-- Recommend adding dimensions
            --}} />
        <div class="container">
            <div class="row">
                <div class="col-lg-auto mx-auto">
                    <div class="title-area text-center">
                        <span class="sec-subtitle text-capitalize fade-anim" data-direction="top">About Morocco Quest</span>
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
                            <p>
                                Welcome to Morocco Quest!

                                We are passionate about sharing the magic of Morocco with travelers from around the world.
                                Founded by Mounir Akajia in 2022, a travel enthusiast and avid explorer, our mission is
                                to provide authentic, immersive, and memorable experiences.

                                Discover our commitment to sustainable travel, our deep love for Moroccan culture, and the
                                values that drive everything we do. Whether you’re looking to explore the bustling souks of
                                Marrakech, the golden dunes of the Sahara, or the serene coasts of Essaouira, Morocco
                                Quest is here to make your journey unforgettable.

                            </p>
                            {{-- 4. Content Relevance: List relevant to agency (Unchanged) --}}
                            <div class="services-lists">
                                <ul class="custom-ul">
                                    <li>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="16" viewBox="0 0 18 16"
                                            fill="none" aria-hidden="true">
                                            <path
                                                d="M7.99949 15.7247C7.94644 15.7247 7.89396 15.7137 7.84536 15.6924C7.79675 15.6712 7.75308 15.6401 7.71707 15.6011L0.102184 7.36399C0.0514209 7.30907 0.0177684 7.24055 0.00534479 7.16681C-0.0070788 7.09306 0.00226539 7.0173 0.0322339 6.94878C0.0622023 6.88026 0.111495 6.82197 0.174079 6.78104C0.236663 6.7401 0.309824 6.7183 0.384607 6.71829H4.04999C4.10502 6.7183 4.15942 6.73011 4.2095 6.75293C4.25958 6.77575 4.30418 6.80904 4.3403 6.85056L6.88522 9.77841C7.16026 9.19049 7.69268 8.21156 8.62699 7.01872C10.0082 5.25526 12.5774 2.66176 16.9729 0.320525C17.0579 0.275283 17.1567 0.263542 17.2499 0.287618C17.3431 0.311694 17.4239 0.369838 17.4763 0.450569C17.5287 0.531301 17.5489 0.62875 17.533 0.723675C17.5171 0.8186 17.4661 0.904101 17.3902 0.963294C17.3735 0.97641 15.6787 2.31103 13.7282 4.7556C11.9331 7.00522 9.54691 10.6837 8.37272 15.4325C8.3521 15.516 8.30412 15.5901 8.23645 15.6431C8.16878 15.696 8.08532 15.7248 7.99938 15.7248L7.99949 15.7247Z"
                                                fill="currentColor" />
                                        </svg>
                                        Expert Local Guides & Personalized Itineraries
                                    </li>
                                    <li>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="16" viewBox="0 0 18 16"
                                            fill="none" aria-hidden="true">
                                            <path
                                                d="M7.99949 15.7247C7.94644 15.7247 7.89396 15.7137 7.84536 15.6924C7.79675 15.6712 7.75308 15.6401 7.71707 15.6011L0.102184 7.36399C0.0514209 7.30907 0.0177684 7.24055 0.00534479 7.16681C-0.0070788 7.09306 0.00226539 7.0173 0.0322339 6.94878C0.0622023 6.88026 0.111495 6.82197 0.174079 6.78104C0.236663 6.7401 0.309824 6.7183 0.384607 6.71829H4.04999C4.10502 6.7183 4.15942 6.73011 4.2095 6.75293C4.25958 6.77575 4.30418 6.80904 4.3403 6.85056L6.88522 9.77841C7.16026 9.19049 7.69268 8.21156 8.62699 7.01872C10.0082 5.25526 12.5774 2.66176 16.9729 0.320525C17.0579 0.275283 17.1567 0.263542 17.2499 0.287618C17.3431 0.311694 17.4239 0.369838 17.4763 0.450569C17.5287 0.531301 17.5489 0.62875 17.533 0.723675C17.5171 0.8186 17.4661 0.904101 17.3902 0.963294C17.3735 0.97641 15.6787 2.31103 13.7282 4.7556C11.9331 7.00522 9.54691 10.6837 8.37272 15.4325C8.3521 15.516 8.30412 15.5901 8.23645 15.6431C8.16878 15.696 8.08532 15.7248 7.99938 15.7248L7.99949 15.7247Z"
                                                fill="currentColor" />
                                        </svg>
                                        Commitment to Sustainable & Responsible Tourism
                                    </li>
                                    <li>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="16" viewBox="0 0 18 16"
                                            fill="none" aria-hidden="true">
                                            <path
                                                d="M7.99949 15.7247C7.94644 15.7247 7.89396 15.7137 7.84536 15.6924C7.79675 15.6712 7.75308 15.6401 7.71707 15.6011L0.102184 7.36399C0.0514209 7.30907 0.0177684 7.24055 0.00534479 7.16681C-0.0070788 7.09306 0.00226539 7.0173 0.0322339 6.94878C0.0622023 6.88026 0.111495 6.82197 0.174079 6.78104C0.236663 6.7401 0.309824 6.7183 0.384607 6.71829H4.04999C4.10502 6.7183 4.15942 6.73011 4.2095 6.75293C4.25958 6.77575 4.30418 6.80904 4.3403 6.85056L6.88522 9.77841C7.16026 9.19049 7.69268 8.21156 8.62699 7.01872C10.0082 5.25526 12.5774 2.66176 16.9729 0.320525C17.0579 0.275283 17.1567 0.263542 17.2499 0.287618C17.3431 0.311694 17.4239 0.369838 17.4763 0.450569C17.5287 0.531301 17.5489 0.62875 17.533 0.723675C17.5171 0.8186 17.4661 0.904101 17.3902 0.963294C17.3735 0.97641 15.6787 2.31103 13.7282 4.7556C11.9331 7.00522 9.54691 10.6837 8.37272 15.4325C8.3521 15.516 8.30412 15.5901 8.23645 15.6431C8.16878 15.696 8.08532 15.7248 7.99938 15.7248L7.99949 15.7247Z"
                                                fill="currentColor" />
                                        </svg>
                                        Secure Booking & Excellent Customer Support
                                    </li>
                                </ul>
                            </div>
                            <div class="btn-trigger btn-bounce">
                                {{-- 5. Internal Linking: Link to tours/services page, improved anchor text (Unchanged) --}}
                                <a href="{{ route('tours.index') ?? '#' }}" {{-- Assuming tours.index route exists --}}
                                    class="vs-btn style6 text-capitalize">Explore Our Morocco Tours</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 order-0 order-md-1">
                    <div class="about-thumb fade-anim" data-direction="right">
                        <img src="{{ asset('assets/img/desert-luxury-camp-morocco-sunset-traditional-tents.webp') }}"
                            alt="Luxury desert camp in Morocco at sunset with traditional Berber tents, red carpets, and seating areas on golden sand"
                            class="w-100" loading="lazy" />
                        <figcaption style="display: none;">
                            Enjoy the serene beauty of a luxury desert camp in Morocco. Witness the magical sunset over
                            traditional Berber tents surrounded by red carpets and cozy seating, offering a unique and
                            unforgettable Sahara experience.
                        </figcaption>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!--================= About Area end =================-->

    <!--================= Travel-guides start =================-->
    <section class="travel-guides bg-second-theme-color position-relative space"
        data-bg-src="{{ asset('assets/img/bg/travel-guides-bg.png') }}">
        {{-- 6. Image Optimization: Added loading="lazy" --}}
        <img src="{{ asset('assets/img/icons/plain-sclation.png') }}" alt="Decorative paper airplane icon"
            class="travel-guides-icon-1 animate-parachute" loading="lazy" {{-- Added Lazy Loading --}} {{-- width="X"
            height="Y" --}} {{-- Recommend adding dimensions --}} />
        {{-- 6. Image Optimization: Added loading="lazy" --}}
        <img src="{{ asset('assets/img/icons/rops.png') }}" alt="Decorative climbing ropes icon"
            class="travel-guides-icon-2 animate-parachute" loading="lazy" {{-- Added Lazy Loading --}} {{-- width="X"
            height="Y" --}} {{-- Recommend adding dimensions --}} />
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
                <!-- Hicham Echerfaoui -->
                <div class="col-md-6 col-lg-4 col-xl-3 fade-anim" data-delay="0.30">
                    <div class="guide-box">
                        <figure class="guide-thumb">
                            <img src="{{ asset('assets/img/guides/hicham-echerfaoui-rabat-morocco-tour-guide.webp') }}"
                                alt="Hicham Echerfaoui - Expert Rabat & Morocco Tour Guide" class="w-100" loading="lazy"
                                width="400" height="300" />
                        </figure>
                        <div class="guide-content text-center">
                            <h5 class="guide-name line-clamp-1 text-second-theme-color text-capitalize">
                                Hicham Echerfaoui
                            </h5>
                            <p class="guide-designation line-clamp-1 text-theme-color text-capitalize">
                                Rabat Expert Guide
                            </p>
                            <button class="vs-btn style4 w-100 btn-sm mt-2" data-bs-toggle="modal"
                                data-bs-target="#guideModalHicham">
                                Read More
                            </button>

                        </div>
                    </div>
                </div>

                <!-- Mohamed Sahraoui -->
                <div class="col-md-6 col-lg-4 col-xl-3 fade-anim" data-delay="0.40">
                    <div class="guide-box">
                        <figure class="guide-thumb">
                            <img src="{{ asset('assets/img/guides/mohamed-sahraoui-desert-expert-guide.webp') }}"
                                alt="Mohamed Sahraoui – Desert Expert Guide in the Moroccan Sahara" class="w-100"
                                loading="lazy" width="400" height="300" />
                        </figure>
                        <div class="guide-content text-center">
                            <h5 class="guide-name line-clamp-1 text-second-theme-color text-capitalize">
                                Mohamed Sahraoui
                            </h5>
                            <p class="guide-designation line-clamp-1 text-theme-color text-capitalize">
                                Desert Expert Guide
                            </p>
                            <button class="vs-btn style4 w-100 btn-sm mt-2" data-bs-toggle="modal"
                                data-bs-target="#guideModalMohamed">
                                Read More
                            </button>

                        </div>
                    </div>
                </div>

                <!-- Salwa Benayyad -->
                <div class="col-md-6 col-lg-4 col-xl-3 fade-anim" data-delay="0.50">
                    <div class="guide-box">
                        <figure class="guide-thumb">
                            <img src="{{ asset('assets/img/guides/salwa-benayyad-certified-female-guide.webp') }}"
                                alt="Salwa Benayyad – Certified Female Guide in the High Atlas Mountains" class="w-100"
                                loading="lazy" width="400" height="300" />
                        </figure>
                        <div class="guide-content text-center">
                            <h5 class="guide-name line-clamp-1 text-second-theme-color text-capitalize">
                                Salwa Benayyad
                            </h5>
                            <p class="guide-designation line-clamp-1 text-theme-color text-capitalize">
                                Mountain Female Guide
                            </p>
                            <button class="vs-btn style4 w-100 btn-sm mt-2" data-bs-toggle="modal"
                                data-bs-target="#guideModalSalwa">
                                Read More
                            </button>

                        </div>
                    </div>
                </div>

                <!-- Hassan Tebbal -->
                <div class="col-md-6 col-lg-4 col-xl-3 fade-anim" data-delay="0.60">
                    <div class="guide-box">
                        <figure class="guide-thumb">
                            <img src="{{ asset('assets/img/guides/hassan-tebbal-fes-expert-guide.webp') }}"
                                alt="Hassan Tebbal – Fes Expert Guide leading travelers through the historic medina of Fes"
                                class="w-100" loading="lazy" width="400" height="300" />
                        </figure>
                        <div class="guide-content text-center">
                            <h5 class="guide-name line-clamp-1 text-second-theme-color text-capitalize">
                                Hassan Tebbal
                            </h5>
                            <p class="guide-designation line-clamp-1 text-theme-color text-capitalize">
                                Fes Expert Guide
                            </p>
                            <button class="vs-btn style4 w-100 btn-sm mt-2" data-bs-toggle="modal"
                                data-bs-target="#guideModalHassan">
                                Read More
                            </button>

                        </div>
                    </div>
                </div>
            </div>

    </section>
    <!--================= Travel-guides end =================-->

    <!--================= Awards Area start =================-->
    <section class="awards-style1 space" data-bg-src="{{ asset('assets/img/awards/awards-style1-bg.png') }}">
        {{-- 6. Image Optimization: Added loading="lazy" --}}
        <img class="awards-icon-1" src="{{ asset('assets/img/icons/award-icon-1.png') }}" alt="Decorative award ribbon icon"
            loading="lazy" {{-- Added Lazy Loading --}} {{-- width="X" height="Y" --}} {{-- Recommend adding dimensions
            --}} />
        {{-- 6. Image Optimization: Added loading="lazy" --}}
        <img class="awards-icon-2 move-item" src="{{ asset('assets/img/icons/award-icon-2.png') }}"
            alt="Decorative parachute icon" loading="lazy" {{-- Added Lazy Loading --}} {{-- width="X" height="Y" --}} {{--
            Recommend adding dimensions --}} />
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
                            <img src="{{ asset('assets/img/icons/awards-google.png') }}" alt="Google logo" loading="lazy"
                                {{-- Added Lazy Loading --}} {{-- width="X" height="Y" --}} {{-- Recommend adding dimensions
                                --}} />
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
                                        <li><i class="fa-solid fa-star-half-stroke"></i></li> {{-- Adjusted based on 4.8
                                        --}}
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

                <!-- ISO Quality Label -->
                <div class="col-md-6 col-lg-4 fade-anim" data-delay="0.30">
                    <div class="award-box-style1">
                        <div class="award-box-style1-wrapper">
                            <figure class="award-box-icon" aria-hidden="true">
                                <img src="{{ asset('assets/img/awards/ISO-Quality-Label.webp') }}" alt="ISO Quality Label"
                                    loading="lazy" width="132" height="103">
                            </figure>
                            <div
                                class="award-box-header d-flex align-items-end justify-content-between gap-xl-4 text-center">
                                <img src="{{ asset('assets/img/awards/award-box-left-wings.png') }}"
                                    alt="Decorative award wing graphic" loading="lazy">
                                <h6 class="text-capitalize ff-rubik fw-semibold">
                                    ISO Quality Label
                                </h6>
                                <img src="{{ asset('assets/img/awards/award-box-right-wings.png') }}"
                                    alt="Decorative award wing graphic" loading="lazy">
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

                <!-- Top Adventure Operator Award -->
                <div class="col-md-6 col-lg-4 fade-anim" data-delay="0.60">
                    <div class="award-box-style1">
                        <div class="award-box-style1-wrapper">
                            <figure class="award-box-icon" aria-hidden="true">
                                <img src="{{ asset('assets/img/awards/Top-Adventure-Operator-Award.webp') }}"
                                    alt="Top Adventure Operator Award" loading="lazy" width="132" height="103">
                            </figure>
                            <div
                                class="award-box-header d-flex align-items-end justify-content-between gap-xl-4 text-center">
                                <img src="{{ asset('assets/img/awards/award-box-left-wings.png') }}"
                                    alt="Decorative award wing graphic" loading="lazy">
                                <h6 class="text-capitalize ff-rubik fw-semibold">
                                    Adventure Operator Award
                                </h6>
                                <img src="{{ asset('assets/img/awards/award-box-right-wings.png') }}"
                                    alt="Decorative award wing graphic" loading="lazy">
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

                <!-- Customer Choice Award -->
                <div class="col-md-6 col-lg-4 fade-anim" data-delay="0.80">
                    <div class="award-box-style1">
                        <div class="award-box-style1-wrapper">
                            <figure class="award-box-icon" aria-hidden="true">
                                <img src="{{ asset('assets/img/awards/Customer-Choice-Award.webp') }}"
                                    alt="Customer Choice Award" loading="lazy" width="132" height="103">
                            </figure>
                            <div
                                class="award-box-header d-flex align-items-end justify-content-between gap-xl-4 text-center">
                                <img src="{{ asset('assets/img/awards/award-box-left-wings.png') }}"
                                    alt="Decorative award wing graphic" loading="lazy">
                                <h6 class="text-capitalize ff-rubik fw-semibold">
                                    Customer Choice Award
                                </h6>
                                <img src="{{ asset('assets/img/awards/award-box-right-wings.png') }}"
                                    alt="Decorative award wing graphic" loading="lazy">
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
    <style>
        .modal-dialog {
            max-width: 70% !important;
        }

        @media (max-width: 768px) {
            .modal-dialog {
                max-width: 95% !important;
                /* Almost full width on mobile */
            }
        }

        .modal-content {
            border-radius: 8px;
        }

        /* Scrollable Modal Body */
        .modal-body {
            max-height: 70vh;
            overflow-y: auto;
        }

        /* Custom Title Styling */
        .modal-body h1 {
            font-size: 2.2rem;
            font-weight: bold;
            margin-bottom: 0.3rem;
            text-align: center;
        }

        /* Custom Sub-title Styling */
        .modal-body .guide-subtitle {
            font-size: 1rem;
            color: #6c757d;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        /* Text Justify */
        .modal-body p {
            text-align: justify;
        }
    </style>

    <style>
        .modal-dialog {
            max-width: 70% !important;
        }

        .modal-header {
            border-bottom: none;
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 1060;
            padding: 0;
        }

        .modal-content {
            border-radius: 8px;
            overflow: hidden;
        }


        .btn-close {
            
            position: absolute;
            top: 10px;
            left: -40px;
            background-color: #bb5e2a !important;
            opacity: 1;
            border: none;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* White Close Icon */
        .btn-close::before {
            /* Unicode for '×' */
            color: white;
            line-height: 1;
            position: absolute;
        }

        /* Hover Effect */
        .btn-close:hover {
            background-color: #a14d24 !important;
            cursor: pointer;
        }

        .modal-body {
            padding: 0;
            margin-top: 0;
        }

        .guide-info {
            padding: 20px;
        }

        .guide-subtitle {
            color: #0EA5E9;
            font-weight: 600;
            margin-bottom: 15px;
        }
    </style>

    <!-- Modal for Hicham Echerfaoui -->
    <div class="modal fade" id="guideModalHicham" tabindex="-1" aria-labelledby="guideModalLabelHicham" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-custom-width">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <img src="{{ asset('assets/img/guides/hicham.webp') }}" class="img-fluid w-100" alt="Hicham Echerfaoui">
                    <div class="guide-info">
                        <h1>Hicham Echerfaoui</h1>
                        <p class="guide-subtitle">Rabat Expert Guide</p>
                        <p>Hicham Echerfaoui – Expert Rabat & Morocco Tour Guide. With over a decade of hands-on experience
                            as a professional Rabat tour guide, Hicham is passionate about crafting immersive Morocco
                            cultural tours that leave a lasting impression. Born and raised in Rabat, he proudly represents
                            his homeland, sharing the city’s rich history, vibrant traditions, and hidden gems with
                            travelers from around the globe.</p>
                        <p><strong>Deep Local Knowledge:</strong> From the medieval ramparts of the Kasbah of the Udayas to
                            the buzzing souks of the Medina, Hicham’s insider expertise ensures an authentic journey through
                            Morocco’s capital.</p>
                        <p><strong>Cultural Storytelling:</strong> A natural storyteller, he brings every site to life with
                            engaging narratives about Moroccan heritage, architecture, cuisine, and social customs.</p>
                        <p><strong>Personalized Experiences:</strong> Whether you’re seeking a family-friendly day tour, an
                            in-depth history expedition, or a bespoke private excursion, Hicham tailors each itinerary to
                            your interests and pace.</p>
                        <p><strong>Warm Hospitality:</strong> As a devoted husband and father of two, Hicham understands the
                            importance of comfort and connection—ensuring every guest feels welcomed, informed, and
                            inspired.</p>
                        <p>Hicham views tourism not merely as sightseeing, but as a powerful bridge between cultures. His
                            unwavering commitment to promoting sustainable tourism and meaningful human connections has
                            earned him glowing reviews on TripAdvisor and Google. Book your next Rabat guided tour with
                            Hicham Echerfaoui and discover the true soul of Morocco—one unforgettable story at a time.</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal for Mohamed Sahraoui -->
    <div class="modal fade" id="guideModalMohamed" tabindex="-1" aria-labelledby="guideModalLabelMohamed"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-custom-width">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <img src="{{ asset('assets/img/guides/mohamed.webp') }}" class="img-fluid w-100" alt="Mohamed Sahraoui">
                    <div class="guide-info">
                        <h1>Mohamed Sahraoui</h1>
                        <p class="guide-subtitle">Desert Expert Guide</p>
                        <p>Mohamed Sahraoui is a seasoned desert guide with over 10 years of experience leading travelers
                            through the enchanting landscapes of southern Morocco. Originally from a Berber village near
                            Merzouga, Mohamed brings deep local knowledge and a passion for sharing the traditions of the
                            Sahara.</p>
                        <p>Fluent in Arabic, Berber, French, and English, he offers immersive and authentic
                            experiences—whether it's a camel trek through the dunes of Erg Chebbi, a 4x4 desert expedition,
                            or storytelling by the campfire under a canopy of stars.</p>
                        <p>With Mohamed as your guide, a desert journey becomes more than just a trip—it’s a meaningful
                            cultural encounter rooted in the warmth and wisdom of the desert.</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal for Salwa Benayyad -->
    <div class="modal fade" id="guideModalSalwa" tabindex="-1" aria-labelledby="guideModalLabelSalwa" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-custom-width">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <img src="{{ asset('assets/img/guides/salwa.webp') }}" class="img-fluid w-100" alt="Salwa Benayyad">
                    <div class="guide-info">
                        <h1>Salwa Benayyad</h1>
                        <p class="guide-subtitle">Mountain Female Guide</p>
                        <p>Salwa Benayyad is a rising star among Morocco’s new generation of female mountain guides. With 5
                            years of experience leading treks through the stunning High Atlas Mountains, she brings both
                            expertise and a fresh, inspiring perspective to every journey.</p>
                        <p>Born and raised in a Berber village near Imlil, Salwa knows the trails, valleys, and peaks of the
                            region intimately. She guides travelers through authentic cultural experiences, whether it’s a
                            scenic village walk, a challenging ascent to Mount Toubkal, or an overnight stay in a
                            traditional mountain lodge.</p>
                        <p>Fluent in Arabic, Berber, French, and English, Salwa bridges cultures with warmth and confidence.
                            As one of the few female guides in the field, she’s not just leading hikes—she’s opening new
                            paths for women in Moroccan tourism.</p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal for Hassan Tebbal -->
    <div class="modal fade" id="guideModalHassan" tabindex="-1" aria-labelledby="guideModalLabelHassan" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-custom-width">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <img src="{{ asset('assets/img/guides/hassan.webp') }}" class="img-fluid w-100" alt="Hassan Tebbal">
                    <div class="guide-info">
                        <h1>Hassan Tebbal</h1>
                        <p class="guide-subtitle">Fes Expert Guide</p>
                        <p>Hassan Tebbal is a skilled guide specializing in exploring the historic medina of Fes. With deep
                            knowledge of Moroccan history and culture, Hassan brings the ancient alleys and vibrant souks of
                            Fes to life through engaging stories and local expertise.</p>
                    </div>
                </div>

            </div>
        </div>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        .guide-box {
            cursor: pointer;
            transition: transform 0.3s;
        }

        .guide-box:hover {
            transform: scale(1.02);
        }

        .modal-content {
            border-radius: 8px;
        }

        .modal-title {
            font-size: 1.25rem;
            font-weight: bold;
        }

        .btn-primary {
            background-color: #0EA5E9;
            border: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #0b89c4;
        }

        .modal-backdrop {
            z-index: 1040 !important;
        }

        .modal {
            z-index: 1050 !important;
        }

        .offcanvas-backdrop {
            z-index: 1030 !important;
        }

        .vs-btn.style4 {
            border-radius: 4px;
            font-size: 12px;
            padding: 2px 6px;
            height: 28px;
            min-height: 40px;
        }

        .vs-btn.style4.w-100 {
            max-width: 100px;
            margin: 0 auto;
        }

        .btn-sm {
            height: 24px;
            line-height: 1;
        }

        .about-info p {
            margin-right: 15px;
            /* Correct unit is px, not x */
            text-align: justify;
            text-justify: inter-word;
        }

        .modal-custom-width {
            max-width: 70% !important;
        }

        .modal-content {
            border-radius: 8px;
        }

        @media (max-width: 767px) {
            .modal-dialog {
                max-width: 95% !important;
                margin: 30px auto !important;
            }

            .modal-body img {
                height: 200px;
                object-fit: cover;
            }
        }
    </style>

@endsection