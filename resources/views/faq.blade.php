@extends('layouts.app2') {{-- Or your main layout file --}}

{{-- External CSS for Odometer - Keep if using --}}
{{-- Note: Consider loading non-critical CSS asynchronously or including it in your main bundle if possible --}}
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/odometer.js/0.4.8/themes/odometer-theme-default.min.css" /> --}}

{{-- 1. Page Title: Optimized for keywords and clarity (Existing logic is good) --}}
@section('title', 'FAQ - Morocco Travel Frequently Asked Questions | Morocco Quest')

{{-- 2. Meta Description: Specific description wrapped in <meta> tag --}}
@section('meta_description')
    {{-- Uses H1, H2, and FAQ topics. Concise, keyword-rich, under 160 chars. --}}
    <meta name="description" content="Find answers to frequently asked questions about booking Morocco tours with Morocco Quest, visa requirements, safety, packing tips, currency, and more. Prepare for your Moroccan adventure!">
@endsection

{{-- NEW SECTION: Added for page-specific JSON-LD Structured Data --}}
@section('structured_data')
    {{-- Schema.org FAQPage Script --}}
    {{-- This script uses the EXACT questions and answers displayed in the accordion below --}}
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "FAQPage",
      "mainEntity": [
        {{-- Question 1 --}}
        {
          "@type": "Question",
          "name": "What travel documents do I need for Morocco?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "<p>Most travelers need a passport valid for at least six months from their entry date. Visa requirements depend on your nationality. We recommend checking with the official Moroccan consulate or embassy website for your country well before your trip.</p>"
          }
        },
        {{-- Question 2 --}}
        {
          "@type": "Question",
          "name": "Is Morocco safe for tourists, especially solo female travelers?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "<p>Morocco is generally considered safe for tourists, including solo female travelers. Standard precautions apply, like being aware of surroundings, especially in busy markets (souks). Traveling with a reputable guide or group like Morocco Quest can enhance safety and local insights. Dressing modestly is often appreciated in more traditional areas.</p>"
          }
        },
        {{-- Question 3 --}}
        {
          "@type": "Question",
          "name": "What's the best time of year to visit Morocco?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "<p>Spring (March-May) and Autumn (September-November) offer the most pleasant weather across the country. Summers can be very hot, particularly in the desert and Marrakech. Winters are mild on the coast but can be cold with snow in the Atlas Mountains.</p>"
          }
        },
        {{-- Question 4 --}}
        {
          "@type": "Question",
          "name": "What currency should I use and how accessible are ATMs?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "<p>The currency is the Moroccan Dirham (MAD). While credit cards are common in hotels and larger shops/restaurants in cities, cash is essential for smaller purchases, taxis, and souks. ATMs are readily available in cities and larger towns.</p>"
          }
        },
        {{-- Question 5 --}}
        {
          "@type": "Question",
          "name": "How do I book a tour with Morocco Quest?",
          "acceptedAnswer": {
            "@type": "Answer",
            {{-- Note: Escaping the link properly for JSON --}}
          }
        },
        {{-- Question 6 --}}
        {
          "@type": "Question",
          "name": "What is typically included in your tour price?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "<p>Specific inclusions are listed on each tour page. Generally, multi-day tours include accommodation, transportation within Morocco, specified meals (e.g., breakfast daily, some dinners), guided sightseeing, and entrance fees mentioned in the itinerary. Flights to/from Morocco are usually not included.</p>"
          }
        },
        {{-- Question 7 --}}
        {
          "@type": "Question",
          "name": "Can you cater to dietary restrictions (vegetarian, gluten-free)?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "<p>Yes, we can usually accommodate common dietary needs like vegetarian, vegan, or gluten-free. Please inform us clearly at the time of booking so we can make necessary arrangements with our accommodation and meal partners.</p>"
          }
        },
        {{-- Question 8 --}}
        {
          "@type": "Question",
          "name": "What should I pack for a trip to Morocco?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "<p>Packing depends on the season and regions visited. Generally, bring layers (light clothing for day, warmer layers for evenings/mountains/desert nights), comfortable walking shoes, sun protection (hat, sunglasses, sunscreen), modest clothing options for visiting religious sites, and any personal medications. We provide a suggested packing list upon booking.</p>"
          }
        }
        {{-- Add more Question/Answer pairs here if you add more FAQs to the page, ensuring no trailing comma on the last item --}}
      ]
    }
    </script>
@endsection

@section('content')

{{-- Breadcrumb Section --}}
<section
  class="vs-breadcrumb"
  data-bg-src="{{ asset('assets/img/guide-dar-el-bacha-marrakech-tour-moroccan-culture.webp') }}"
>
  <img
    src="{{ asset('assets/img/icons/cloud.png') }}"
    alt="Decorative cloud icon"
    class="vs-breadcrumb-icon-1 animate-parachute"
    loading="lazy"
  />
  <img
    src="{{ asset('assets/img/icons/ballon-sclation.png') }}"
    alt="Decorative hot air balloon icon"
    class="vs-breadcrumb-icon-2 animate-parachute"
    loading="lazy"
  />
  <div class="container">
    <div class="row text-center">
      <div class="col-12">
        <div class="breadcrumb-content">
          <h1 class="breadcrumb-title">Frequently Asked Questions (FAQ)</h1>
          <p class="breadcrumb-subtitle" style="color: white;">
            Quick answers to common queries about your Moroccan adventure.
          </p>

          <p class="visually-hidden">
            A knowledgeable Moroccan guide engages travelers with cultural insights during a guided tour of Dar El Bacha in Marrakech. Known for its stunning architecture and rich history, Dar El Bacha is a must-visit landmark for those exploring Morocco’s imperial heritage.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>


{{-- Main FAQ Section --}}
{{-- Schema.org FAQPage added via JSON-LD in head --}}
<section class="vs-faq space" data-bg-src="{{ asset('assets/img/bg/404-faq.png') }}"> {{-- Ensure background image is optimized --}}
    <div class="container">
        <div class="row">
            <div class="col-lg-auto mx-auto">
                <div class="title-area text-center">
                    <span
                      class="sec-subtitle text-capitalize fade-anim"
                      data-direction="top"
                    >Help Center</span>
                    {{-- H2: Section heading --}}
                    <h2 class="sec-title fade-anim" data-direction="bottom">
                      Answers to Common Morocco Travel Questions
                    </h2>
                </div>
            </div>
        </div>
        <div class="row g-3">
            {{-- Left Column of FAQs --}}
            <div class="col-lg-6">
                <div class="accordion accordion-style1" id="accordionLeft">

                    {{-- === FAQ Item 1 === --}}
                    <div class="accordion-item">
                        {{-- H6 used for styling consistency as per original code, but H3 would be semantically better --}}
                        <h6 class="accordion-header" id="headingOneV1"> {{-- Added ID for aria-labelledby --}}
                            <button
                                class="accordion-button"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#collapseOneV1"
                         aria-expanded="true"
                                aria-controls="collapseOneV1"
                            >
                                What travel documents do I need for Morocco? {{-- Real Question --}}
                            </button>
                        </h6>
                        <div
                            id="collapseOneV1"
                            class="accordion-collapse collapse show"
                            aria-labelledby="headingOneV1" {{-- Link header to body --}}
                            data-bs-parent="#accordionLeft"
                        >
                            <div class="accordion-body">
                                {{-- Real Answer --}}
                                <p>Most travelers need a passport valid for at least six months from their entry date. Visa requirements depend on your nationality. We recommend checking with the official Moroccan consulate or embassy website for your country well before your trip.</p>
                            </div>
                        </div>
                    </div>

                    {{-- === FAQ Item 2 === --}}
                    <div class="accordion-item">
                        <h6 class="accordion-header" id="headingTwoV1">
                            <button
                                class="accordion-button collapsed"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#collapseTwoV1"
                                aria-expanded="false"
                                aria-controls="collapseTwoV1"
                            >
                                Is Morocco safe for tourists, especially solo female travelers? {{-- Real Question --}}
                            </button>
                        </h6>
                        <div
                            id="collapseTwoV1"
                            class="accordion-collapse collapse"
                             aria-labelledby="headingTwoV1"
                            data-bs-parent="#accordionLeft"
                        >
                            <div class="accordion-body">
                                {{-- Real Answer --}}
                                <p>Morocco is generally considered safe for tourists, including solo female travelers. Standard precautions apply, like being aware of surroundings, especially in busy markets (souks). Traveling with a reputable guide or group like Morocco Quest can enhance safety and local insights. Dressing modestly is often appreciated in more traditional areas.</p>
                            </div>
                        </div>
                    </div>

                    {{-- === FAQ Item 3 === --}}
                    <div class="accordion-item">
                        <h6 class="accordion-header" id="headingThreeV1">
                            <button
                                class="accordion-button collapsed"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#collapseThreeV1"
                                aria-expanded="false"
                                aria-controls="collapseThreeV1"
                            >
                                What's the best time of year to visit Morocco? {{-- Real Question --}}
                            </button>
                        </h6>
                        <div
                            id="collapseThreeV1"
                            class="accordion-collapse collapse"
                            aria-labelledby="headingThreeV1"
                            data-bs-parent="#accordionLeft"
                        >
                            <div class="accordion-body">
                                {{-- Real Answer --}}
                                <p>Spring (March-May) and Autumn (September-November) offer the most pleasant weather across the country. Summers can be very hot, particularly in the desert and Marrakech. Winters are mild on the coast but can be cold with snow in the Atlas Mountains.</p>
                            </div>
                        </div>
                    </div>

                    {{-- === FAQ Item 4 === --}}
                    <div class="accordion-item">
                        <h6 class="accordion-header" id="headingFourV1">
                            <button
                                class="accordion-button collapsed"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#collapseFourV1"
                                aria-expanded="false"
                                aria-controls="collapseFourV1"
                            >
                                What currency should I use and how accessible are ATMs? {{-- Real Question --}}
                            </button>
                        </h6>
                        <div
                            id="collapseFourV1"
                            class="accordion-collapse collapse"
                             aria-labelledby="headingFourV1"
                            data-bs-parent="#accordionLeft"
                        >
                            <div class="accordion-body">
                                {{-- Real Answer --}}
                                <p>The currency is the Moroccan Dirham (MAD). While credit cards are common in hotels and larger shops/restaurants in cities, cash is essential for smaller purchases, taxis, and souks. ATMs are readily available in cities and larger towns.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
             {{-- Right Column of FAQs --}}
            <div class="col-lg-6">
                <div class="accordion accordion-style1" id="accordionRight">

                    {{-- === FAQ Item 5 === --}}
                    <div class="accordion-item">
                        <h6 class="accordion-header" id="headingOneV2">
                            <button
                                class="accordion-button collapsed" {{-- Changed default state to collapsed --}}
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#collapseOneV2"
                                aria-expanded="false" {{-- Changed default state --}}
                                aria-controls="collapseOneV2"
                            >
                                How do I book a tour with Morocco Quest? {{-- Real Question --}}
                            </button>
                        </h6>
                        <div
                            id="collapseOneV2"
                            class="accordion-collapse collapse" {{-- Changed default state --}}
                            aria-labelledby="headingOneV2"
                            data-bs-parent="#accordionRight"
                        >
                            <div class="accordion-body">
                                {{-- Real Answer --}}
                            </div>
                        </div>
                    </div>

                    {{-- === FAQ Item 6 === --}}
                    <div class="accordion-item">
                        <h6 class="accordion-header" id="headingTwoV2">
                            <button
                                class="accordion-button collapsed"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#collapseTwoV2"
                                aria-expanded="false"
                                aria-controls="collapseTwoV2"
                            >
                                What is typically included in your tour price? {{-- Real Question --}}
                            </button>
                        </h6>
                        <div
                            id="collapseTwoV2"
                            class="accordion-collapse collapse"
                            aria-labelledby="headingTwoV2"
                            data-bs-parent="#accordionRight"
                        >
                            <div class="accordion-body">
                                {{-- Real Answer --}}
                                <p>Specific inclusions are listed on each tour page. Generally, multi-day tours include accommodation, transportation within Morocco, specified meals (e.g., breakfast daily, some dinners), guided sightseeing, and entrance fees mentioned in the itinerary. Flights to/from Morocco are usually not included.</p>
                            </div>
                        </div>
                    </div>

                    {{-- === FAQ Item 7 === --}}
                    <div class="accordion-item">
                        <h6 class="accordion-header" id="headingThreeV2">
                            <button
                                class="accordion-button collapsed"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#collapseThreeV2"
                                aria-expanded="false"
                                aria-controls="collapseThreeV2"
                            >
                                Can you cater to dietary restrictions (vegetarian, gluten-free)? {{-- Real Question --}}
                            </button>
                        </h6>
                        <div
                            id="collapseThreeV2"
                            class="accordion-collapse collapse"
                            aria-labelledby="headingThreeV2"
                            data-bs-parent="#accordionRight"
                        >
                            <div class="accordion-body">
                                {{-- Real Answer --}}
                                <p>Yes, we can usually accommodate common dietary needs like vegetarian, vegan, or gluten-free. Please inform us clearly at the time of booking so we can make necessary arrangements with our accommodation and meal partners.</p>
                            </div>
                        </div>
                    </div>

                    {{-- === FAQ Item 8 === --}}
                    <div class="accordion-item">
                        <h6 class="accordion-header" id="headingFourV2">
                            <button
                                class="accordion-button collapsed"
                                type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#collapseFourV2"
                                aria-expanded="false"
                                aria-controls="collapseFourV2"
                            >
                                What should I pack for a trip to Morocco? {{-- Real Question --}}
                            </button>
                        </h6>
                        <div
                            id="collapseFourV2"
                            class="accordion-collapse collapse"
                            aria-labelledby="headingFourV2"
                            data-bs-parent="#accordionRight"
                        >
                            <div class="accordion-body">
                                {{-- Real Answer --}}
                                <p>Packing depends on the season and regions visited. Generally, bring layers (light clothing for day, warmer layers for evenings/mountains/desert nights), comfortable walking shoes, sun protection (hat, sunglasses, sunscreen), modest clothing options for visiting religious sites, and any personal medications. We provide a suggested packing list upon booking.</p>
                            </div>
                        </div>
                    </div>
                      {{-- Add more FAQ items here as needed, following the pattern --}}
                </div>
            </div>
        </div>

        {{-- Counter Section - Kept structure, ensure counts are accurate --}}
        <div class="row space-top">
            <div class="col-12">
                <div
                    class="counter-style1"
                    data-bg-src="{{ asset('assets/img/bg/counter-style1-bg.png') }}" {{-- Ensure background image is optimized --}}
                >
                    <div class="counter-thumb">
                         {{-- Counter Image: Added loading="lazy", improved alt text --}}
                        <img
                            src="{{ asset('assets/img/morocco-desert-4x4-adventure-tour-rural-landscape.webp') }}"
                            alt="Group of happy tourists on a Morocco Quest tour enjoying the scenery" {{-- Improved alt text --}}
                            class="w-100"
                            loading="lazy" {{-- Added Lazy Loading --}}
                            {{-- width="X" height="Y" --}} {{-- Recommended: Add dimensions --}}
                        />
                    </div>
                    <div class="counter-states">
                        {{-- !! IMPORTANT: Update data-count values to reflect real numbers !! --}}
                        <div class="counter-box">
                            <svg xmlns="http://www.w3.org/2000/svg" width="56" height="54" viewBox="0 0 56 54" fill="none" aria-hidden="true">
                                <path d="M53.8999 40.2584C52.5697 39.0983 50.7893 38.5682 49.0391 38.8083L31.6864 41.2085C25.8997 41.7679 25.2951 33.2425 31.1164 32.9976C31.1163 32.9976 38.0874 32.9976 38.0874 32.9976C37.9644 32.3857 37.9751 31.6205 38.0774 30.9974H31.1163C25.5336 30.9454 22.8546 38.1145 27.0958 41.7386C28.4259 42.8987 30.2062 43.4288 31.9564 43.1888L49.3091 40.7885C55.0909 40.2274 55.7045 48.7531 49.8791 48.9994C49.8792 48.9994 16.9141 48.9994 16.9141 48.9994C17.0206 49.612 17.0181 50.3771 16.9141 50.9997H49.8792C55.4594 51.0523 58.1425 43.8827 53.8999 40.2584Z" fill="currentColor "/>
                                <path d="M5.07372 48.9995H0.993071C-0.319719 49.0244 -0.321509 50.9746 0.993111 50.9997C0.993071 50.9997 5.08373 50.9997 5.08373 50.9997C4.96072 50.3875 4.97147 49.6229 5.07372 48.9995Z" fill="currentColor "/>
                                <path d="M14.9973 30.9973C14.8353 25.7092 7.15735 25.7105 6.99609 30.9974C7.15817 36.2854 14.836 36.2842 14.9973 30.9973Z" fill="currentColor "/>
                                <path d="M12.7354 46.4092L19.6665 37.5982C23.077 33.2677 22.697 27.067 18.7664 23.1866C14.4857 18.9461 7.5046 18.9361 3.2239 23.1866C-0.706709 27.067 -1.08677 33.2677 2.3238 37.5982L9.25488 46.4092C5.48352 48.1656 6.77443 54.0205 10.9953 54.0001C15.2164 54.0164 16.5077 48.1697 12.7354 46.4092ZM4.99419 30.9974C4.99419 27.6871 7.68461 24.9968 10.9951 24.9968C18.9379 25.2763 18.9358 36.7198 10.995 36.9981C7.68461 36.9981 4.99419 34.3078 4.99419 30.9974Z" fill="currentColor "/>
                                <path d="M42.2394 28.407C38.4968 30.2055 39.7829 36.0101 43.9998 35.9979C48.2309 35.9859 49.5079 30.2291 45.7599 28.407C45.76 28.407 53.4512 18.8359 53.4512 18.8359C57.1918 14.1954 56.7717 7.55462 52.471 3.39411C47.8003 -1.12637 40.1991 -1.13638 35.5284 3.39411C31.2277 7.55462 30.8076 14.1954 34.5482 18.8359L42.2394 28.407ZM43.9997 4.99433C47.8603 4.99433 51.0008 8.13471 51.0008 11.9951C50.6491 21.2699 37.3489 21.2674 36.9986 11.9951C36.9986 8.13471 40.1391 4.99433 43.9997 4.99433Z" fill="currentColor "/>
                                <path d="M43.9997 16.9958C50.6094 16.7898 50.6078 7.19968 43.9996 6.99463C37.39 7.20066 37.3915 16.7907 43.9997 16.9958Z" fill="currentColor "/>
                            </svg>
                            <h2 class="counter-number">
                                <span class="d-block odometer" data-count="1100">0</span>
                                <em>+</em>
                            </h2>
                            <span class="counter-info">Happy Travelers</span>
                        </div>
                        <div class="counter-box">
                            <svg xmlns="http://www.w3.org/2000/svg" width="49" height="50" viewBox="0 0 49 50" fill="none" aria-hidden="true">
                                <path d="M43.3847 17.943C42.0938 17.0898 40.6425 16.5723 39.1875 16.4458C38.5828 16.3848 37.9819 16.3914 37.3988 16.4598L48.9084 12.8139C46.8487 11.3289 43.9875 10.9145 41.2481 11.7798C39.7734 12.2467 38.4581 13.0492 37.4437 14.1002C36.8175 14.732 36.3094 15.4492 35.9353 16.2067C36.1444 15.3602 36.2156 14.4602 36.1359 13.5527C36.0178 12.092 35.5125 10.637 34.6753 9.33859C33.1125 6.92641 30.6422 5.42734 28.1128 5.25953L35.6091 16.8508L35.6053 16.8498C35.0372 15.933 34.2609 15.1136 33.3206 14.4705C32.1169 13.6352 30.6722 13.1017 29.1375 12.9245C26.2819 12.6011 23.5556 13.5573 21.8194 15.4061L35.3859 16.9548C29.9934 24.4267 28.365 32.7358 27.8737 36.9939H22.9491C22.6969 33.3948 21.3891 22.8358 14.6428 13.488L29.3344 11.8108C27.4547 9.80922 24.5016 8.77328 21.4097 9.12391C19.7475 9.31609 18.1828 9.89359 16.8797 10.7983C15.8625 11.4948 15.0216 12.3827 14.4056 13.3755L14.4019 13.3764L22.5197 0.824219C19.7803 1.00609 17.1047 2.62984 15.4125 5.24172C14.5059 6.64797 13.9594 8.22391 13.8309 9.80453C13.7447 10.787 13.8225 11.7611 14.0484 12.678C13.6434 11.8577 13.0931 11.0814 12.4144 10.397C11.3166 9.25891 9.89156 8.38984 8.295 7.88359C5.32781 6.94609 2.22938 7.39516 0 9.00297L12.4641 12.9517C11.8322 12.8767 11.1816 12.8702 10.5272 12.9358C8.95125 13.0727 7.38 13.6333 5.98219 14.5567C3.38719 16.2733 1.78688 18.9639 1.63406 21.7089L13.6866 13.7505C14.8678 17.5323 18.6338 30.2439 18.1172 37.0267C15.0975 37.1898 12.2813 38.1358 10.1109 39.7455C7.91156 41.3692 6.76125 44.1873 6.435 46.1336C5.62031 46.8048 4.94625 47.3383 3.54281 47.3383C3.00656 47.3383 2.57812 47.777 2.57812 48.3133C2.57812 48.8495 3.01688 49.2883 3.55312 49.2883C5.67844 49.2883 6.81844 48.3527 7.725 47.5923C8.57344 46.9005 9.23625 46.3548 10.6687 46.3445H10.6781C11.2041 46.3445 11.6241 46.4223 11.9944 46.5395C12.6178 46.7636 13.0866 47.1442 13.6125 47.583C13.6416 47.612 13.6809 47.6411 13.7194 47.6711C14.3822 48.2073 15.1716 48.8214 16.3509 49.0942C16.77 49.2011 17.2481 49.2602 17.7834 49.2602H17.8031H17.8125C19.9275 49.2508 21.0581 48.3142 21.975 47.5642C22.8131 46.8723 23.4862 46.3267 24.9094 46.3164H24.9291C26.3522 46.3164 27.015 46.862 27.8531 47.5539C28.7691 48.3048 29.91 49.2302 32.025 49.2302H32.0447C32.6006 49.2302 33.0975 49.1617 33.5259 49.0548C34.7147 48.753 35.4947 48.1286 36.1575 47.583C36.1772 47.5633 36.1969 47.5539 36.2156 47.5342C36.7519 47.0955 37.2103 46.7158 37.8431 46.4917C38.2134 46.3652 38.6325 46.2873 39.1491 46.2873H39.1687C40.5825 46.2873 41.2547 46.833 42.0928 47.5248C43.0087 48.2758 44.1394 49.2011 46.2647 49.2011C46.8497 49.2105 47.2491 48.7623 47.2491 48.2261C47.2491 47.6898 46.8103 47.2511 46.2741 47.2511C46.2647 47.2511 46.2647 47.2511 46.2647 47.2511C44.865 47.2511 44.19 46.7223 43.3706 46.0455C42.5081 41.4864 37.6744 37.7298 32.1431 37.0961C32.2453 30.602 35.2669 20.402 36.2691 17.1958L47.3991 24.5448C47.2594 22.0136 45.7809 19.5283 43.3847 17.943Z" fill="currentColor "/>
                                <path d="M33.8706 18.242C33.8706 17.5277 33.2894 16.9464 32.5759 16.9464C31.8625 16.9464 31.2812 17.5277 31.2812 18.242C31.2812 18.9555 31.8625 19.5367 32.5759 19.5367C33.2894 19.5367 33.8706 18.9564 33.8706 18.242Z" fill="currentColor "/>
                                <path d="M35.9414 19.5367C35.9414 20.2511 36.5227 20.8323 37.237 20.8323C37.9514 20.8323 38.5317 20.2511 38.5317 19.5367C38.5317 18.8233 37.9505 18.242 37.237 18.242C36.5236 18.242 35.9414 18.8233 35.9414 19.5367Z" fill="currentColor "/>
                                <path d="M16.2852 14.8821C16.2852 15.6546 16.9142 16.2836 17.6877 16.2836C18.4611 16.2836 19.0902 15.6546 19.0902 14.8821C19.0902 14.1086 18.4611 13.4796 17.6877 13.4796C16.9142 13.4796 16.2852 14.1086 16.2852 14.8821Z" fill="currentColor "/>
                                <path d="M14.0394 16.2836C14.0394 15.5111 13.4103 14.882 12.6369 14.882C11.8634 14.882 11.2344 15.5111 11.2344 16.2836C11.2344 17.057 11.8634 17.6861 12.6369 17.6861C13.4103 17.6861 14.0394 17.057 14.0394 16.2836Z" fill="currentColor "/>
                            </svg>
                            <h2 class="counter-number">
                                <span class="d-block odometer" data-count="150">0</span> {{-- Example Count --}}
                                <em>+</em>
                            </h2>
                            <span class="counter-info">Tours Organized</span>
                        </div>
                        <div class="counter-box">
                            <svg xmlns="http://www.w3.org/2000/svg" width="55" height="54" viewBox="0 0 55 54" fill="none" aria-hidden="true">
                                <path d="M54.6327 18.8126C54.3892 19.6668 53.589 20.2642 52.6854 20.2642H33.343L25.3679 29.8475C24.9816 30.3112 24.4149 30.5767 23.8124 30.5767H19.8638C19.1863 30.5767 18.5564 30.2402 18.1801 29.6762C17.8047 29.1123 17.7352 28.4018 17.9961 27.7761L21.1219 20.2642H4.46368C3.57653 20.2642 2.7791 19.6709 2.52551 18.8213L0.0865394 10.6809C-0.0984012 10.062 0.0160395 9.41013 0.401483 8.89195C0.787836 8.37376 1.37927 8.07667 2.02472 8.07667H3.87683C4.57813 8.07667 5.24097 8.44883 5.60535 9.0485L7.82275 12.6932C7.8493 12.7372 7.89783 12.7642 7.9491 12.7642H21.6793C21.7324 12.7642 21.7736 12.7417 21.8029 12.6983C21.8322 12.6543 21.8367 12.6076 21.8166 12.5591L17.9961 3.37726C17.7352 2.7515 17.8048 2.04105 18.1801 1.47708C18.5564 0.91312 19.1863 0.57666 19.8638 0.57666H23.8124C24.4149 0.57666 24.9816 0.84216 25.367 1.30497L34.8592 12.7106C34.8876 12.7449 34.9288 12.7642 34.9727 12.7642H50.1439C51.6252 12.7642 52.9875 13.4435 53.882 14.6282C54.7783 15.817 55.0521 17.3423 54.6327 18.8126ZM8.39867 44.8361C9.16743 46.1673 9.16743 47.7517 8.39867 49.0829L6.4768 52.411C6.11117 53.0392 5.45496 53.4235 4.72368 53.4235C3.9924 53.4235 3.3362 53.0392 2.97055 52.411L1.04869 49.0829C0.279927 47.7517 0.279927 46.1673 1.04869 44.8361C1.81745 43.5142 3.18616 42.7173 4.72367 42.7173C6.26118 42.7173 7.62992 43.5142 8.39867 44.8361ZM5.66119 47.4517C5.66119 46.9361 5.2393 46.5142 4.72369 46.5142C4.20807 46.5142 3.78619 46.9361 3.78619 47.4517C3.78619 47.9673 4.20807 48.3892 4.72369 48.3892C5.2393 48.3892 5.66119 47.9673 5.66119 47.4517ZM53.3987 44.8361C54.1674 46.1673 54.1674 47.7517 53.3987 49.0829L51.4768 52.411C51.1112 53.0392 50.455 53.4235 49.7237 53.4235C48.9924 53.4235 48.3362 53.0392 47.9706 52.411L46.0487 49.0829C45.2799 47.7517 45.2799 46.1673 46.0487 44.8361C46.8174 43.5142 48.1862 42.7173 49.7237 42.7173C51.2612 42.7173 52.6299 43.5142 53.3987 44.8361ZM50.6612 47.4517C50.6612 46.9361 50.2393 46.5142 49.7237 46.5142C49.2081 46.5142 48.7862 46.9361 48.7862 47.4517C48.7862 47.9673 49.2081 48.3892 49.7237 48.3892C50.2393 48.3892 50.6612 47.9673 50.6612 47.4517ZM16.5734 34.2163C15.9609 34.4301 15.353 34.6645 14.7679 34.9121C14.2919 35.1145 14.0685 35.6647 14.2708 36.1412C14.4228 36.4988 14.7698 36.7135 15.1342 36.7135C15.2568 36.7135 15.3804 36.6892 15.5004 36.6388C16.0515 36.4049 16.6164 36.1875 17.1923 35.9861C17.6811 35.8158 17.9384 35.2811 17.7681 34.7922C17.5969 34.3033 17.0632 34.0456 16.5734 34.2163ZM21.2444 32.9886C20.6053 33.1054 19.9755 33.2404 19.3566 33.3924C18.853 33.516 18.5463 34.0241 18.6699 34.5267C18.7743 34.9543 19.1579 35.2404 19.579 35.2404C19.6532 35.2404 19.7283 35.2317 19.8033 35.2133C20.3875 35.0696 20.9807 34.9428 21.5813 34.8325C22.0912 34.7396 22.4282 34.2511 22.3348 33.7416C22.2423 33.2326 21.7534 32.8957 21.2444 32.9886ZM12.1541 36.1815C11.5828 36.496 11.0225 36.832 10.4869 37.1799C10.053 37.4619 9.92937 38.0428 10.2114 38.4767C10.3917 38.7532 10.692 38.9034 10.9987 38.9034C11.1736 38.9034 11.3512 38.8544 11.5087 38.7519C12.0067 38.4287 12.5276 38.116 13.0586 37.8231C13.5127 37.5731 13.6775 37.0032 13.4276 36.5496C13.1767 36.0964 12.6055 35.9316 12.1541 36.1815ZM8.13127 38.9112C7.62499 39.3337 7.13793 39.7745 6.68474 40.2217C6.31579 40.5852 6.31212 41.1789 6.67558 41.5474C6.85868 41.7337 7.1013 41.8267 7.343 41.8267C7.58104 41.8267 7.81907 41.7369 8.00126 41.5566C8.41783 41.146 8.86552 40.7404 9.33244 40.3513C9.72978 40.0199 9.7838 39.4284 9.45237 39.0311C9.12004 38.6333 8.53136 38.5793 8.13127 38.9112ZM42.7483 36.4365C42.3006 36.1779 41.7265 36.3303 41.4675 36.7798C41.2084 37.2284 41.3622 37.802 41.8108 38.0606C42.3363 38.3637 42.8508 38.6859 43.3425 39.0197C43.5036 39.1291 43.6867 39.1812 43.868 39.1812C44.1683 39.1812 44.4631 39.0375 44.6443 38.7702C44.9355 38.3417 44.8238 37.7585 44.3953 37.4678C43.8661 37.1089 43.3122 36.762 42.7483 36.4365ZM46.4461 41.5561C46.6283 41.7365 46.8663 41.8267 47.1044 41.8267C47.3461 41.8267 47.5878 41.7337 47.7718 41.5479C48.1352 41.1794 48.1316 40.5857 47.7626 40.2222C47.4257 39.8894 47.0751 39.5649 46.7125 39.2495C46.3225 38.9098 45.7301 38.9492 45.3896 39.3415C45.0499 39.7319 45.0911 40.3243 45.482 40.6639C45.8153 40.9537 46.1366 41.2508 46.4461 41.5561ZM40.1555 35.1191C39.5714 34.859 38.9672 34.6137 38.3611 34.3907C37.8758 34.2131 37.3357 34.4608 37.1572 34.9469C36.9786 35.4331 37.2277 35.9719 37.7129 36.1504C38.286 36.361 38.8463 36.5885 39.3938 36.832C39.5174 36.8874 39.6465 36.9135 39.7737 36.9135C40.1335 36.9135 40.4759 36.7057 40.6316 36.3568C40.8412 35.8835 40.6288 35.3296 40.1555 35.1191ZM26.0353 32.4723C25.3871 32.4956 24.7463 32.5364 24.1109 32.5954C23.5955 32.643 23.2164 33.0999 23.264 33.6153C23.3098 34.1014 23.7181 34.4663 24.197 34.4663C24.2253 34.4663 24.2546 34.4649 24.2848 34.4622C24.8836 34.4068 25.4897 34.3679 26.1013 34.3463C26.6194 34.3276 27.0232 33.8932 27.0049 33.3759C26.9875 32.8582 26.5123 32.4553 26.0353 32.4723ZM35.5934 33.5201C34.9755 33.3571 34.3483 33.212 33.7111 33.0848C33.2039 32.9873 32.7095 33.3136 32.6088 33.8213C32.5072 34.3289 32.8368 34.8224 33.3449 34.924C33.9437 35.0431 34.5342 35.1799 35.1155 35.3328C35.1961 35.3543 35.2758 35.3644 35.3554 35.3644C35.7701 35.3644 36.1501 35.0861 36.2609 34.6654C36.3927 34.1646 36.0942 33.6519 35.5934 33.5201ZM30.8501 32.6467C30.2165 32.578 29.5748 32.5272 28.9266 32.4947C28.4102 32.4576 27.9698 32.8669 27.9433 33.3837C27.9177 33.9009 28.3159 34.3413 28.8332 34.367C29.4447 34.3976 30.0499 34.4457 30.6468 34.5107C30.6816 34.5144 30.7155 34.5162 30.7494 34.5162C31.2218 34.5162 31.6283 34.16 31.6805 33.6799C31.7363 33.1653 31.3646 32.7025 30.8501 32.6467Z" fill="currentColor "/>
                            </svg>
                            <h2 class="counter-number">
                                <span class="d-block odometer" data-count="15">0</span> {{-- Example Count --}}
                                <em>+</em>
                            </h2>
                            <span class="counter-info">Years Experience</span>
                        </div>
                        <div class="counter-box">
                            <svg xmlns="http://www.w3.org/2000/svg" width="56" height="56" viewBox="0 0 56 56" fill="none" aria-hidden="true">
                                <path d="M22.7535 44.2768C22.7027 43.015 23.191 41.776 24.0905 40.8783L25.011 39.956C25.8632 39.1055 27.034 38.6172 28.2275 38.6172C28.7192 38.6172 29.2022 38.6978 29.666 38.8552L30.422 39.1125L31.9322 37.4762L28.0718 34.181C27.1373 33.3812 26.5755 32.2158 26.5265 30.982C26.4775 29.7238 26.9657 28.4883 27.8635 27.5923L28.8942 26.5615C29.9425 25.5115 31.3845 24.9112 32.851 24.9112C33.719 24.9112 34.5817 25.1213 35.3465 25.5203L40.5072 28.2082L42.4165 26.1502C43.715 24.745 45.3582 23.7388 47.1398 23.1997C46.0477 12.1397 36.722 3.5 25.375 3.5C13.293 3.5 3.5 13.293 3.5 25.375C3.5 37.002 12.5772 46.4835 24.0292 47.1818C23.2698 46.4048 22.799 45.3775 22.7535 44.2768ZM18.1895 35.6877L17.2008 39.1493C16.9785 39.9263 16.5865 40.6157 16.0895 41.2125C11.7058 38.6365 8.47875 34.307 7.399 29.176C7.588 29.1288 7.77 29.0623 7.966 29.0342L11.8982 28.4725C13.6762 28.2188 15.47 28.8172 16.7405 30.086C18.2052 31.5507 18.7618 33.6962 18.193 35.6877H18.1895ZM21.6283 18.4485C21.2537 19.9482 19.9062 21 18.3593 21C15.008 21 11.795 19.6542 9.44475 17.2638C9.31875 17.136 9.22425 16.982 9.1035 16.849C12.1765 10.997 18.305 6.99825 25.3732 6.99825C28.7647 6.99825 31.9323 7.93275 34.6588 9.53575C34.741 12.0417 33.796 14.4882 32.004 16.2785C31.0503 17.2323 29.6222 17.5245 28.371 17.024L26.1467 16.135C24.2515 15.3773 22.1217 16.4658 21.6265 18.4468L21.6283 18.4485Z" fill="currentColor "/>
                                <path d="M48.6831 48.4137L49.7156 47.3812C50.3561 46.7407 50.5241 45.7817 50.1286 45.0222L46.2068 37.4937L50.2196 33.768C51.8628 32.249 52.7011 30.0615 52.4596 27.9212C52.3598 27.041 51.7088 26.3882 50.8286 26.2902C48.6883 26.0487 46.5008 26.887 44.9818 28.5302L41.2561 32.543L33.7276 28.6212C32.9681 28.2257 32.0091 28.3937 31.3686 29.0342L30.3361 30.0667C29.9161 30.4867 29.9196 31.1535 30.3448 31.5175L36.9721 37.177L31.4491 43.162L28.5388 42.168C28.1801 42.0455 27.7706 42.147 27.4888 42.4287L26.5631 43.3545C26.1413 43.7762 26.1466 44.4447 26.5736 44.807L29.4331 47.2342C30.1838 47.8712 30.8803 48.5677 31.5173 49.3185L33.9446 52.178C34.3068 52.605 34.9753 52.6102 35.3971 52.1885L36.3228 51.2627C36.6046 50.981 36.7061 50.5715 36.5836 50.2127L35.5896 47.3025L41.5746 41.7795L47.2341 48.4067C47.5963 48.832 48.2648 48.8355 48.6848 48.4155L48.6831 48.4137Z" fill="currentColor "/>
                            </svg>
                            <h2 class="counter-number">
                                <span class="d-block odometer" data-count="8">0</span> {{-- Example Count --}}
                                <em>+</em>
                            </h2>
                            <span class="counter-info">Awards Won</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Odometer JS & Initialization Script - Kept structure, refined JS --}}
{{-- Consider loading this JS only when needed or bundling it --}}
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/odometer.js/0.4.8/odometer.min.js"></script>
    <script>
        function animateOdometers() {
            // Find all odometer elements that haven't been counted yet
            const odometersToAnimate = document.querySelectorAll(".odometer:not(.counted)");

            odometersToAnimate.forEach(el => {
                const rect = el.getBoundingClientRect();
                // Check if the element is at least partially in the viewport
                const inView = rect.top < window.innerHeight && rect.bottom >= 0;

                if (inView) {
                    el.classList.add('counted'); // Mark as counted to prevent re-animation
                    // Use setTimeout to ensure the class is applied before Odometer updates
                    setTimeout(() => {
                        el.innerHTML = el.getAttribute("data-count");
                    }, 50); // Small delay
                }
            });
        }

        // Check on initial load
        document.addEventListener("DOMContentLoaded", animateOdometers);

        // Check on scroll, using passive listener for performance
        window.addEventListener("scroll", animateOdometers, { passive: true });
    </script>
@endpush

@endsection