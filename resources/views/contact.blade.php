@extends('layouts.app2')

{{-- 1. Page Title: Optimized for keywords and clarity (Existing logic is good) --}}
@section('title', 'Contact Morocco Quest | Plan Your Morocco Tour')

{{-- 2. Meta Description: Specific description wrapped in <meta> tag --}}
@section('meta_description')
    {{-- Uses H1 and page purpose. Concise, keyword-rich, under 160 chars. --}}
    <meta name="description" content="Get in touch with Morocco Quest to plan your custom tour, ask questions, or book your Moroccan adventure. Contact our travel experts via phone, email, or contact form.">
@endsection

{{-- NEW SECTION: Added for page-specific JSON-LD Structured Data --}}
@section('structured_data')
    {{-- !! IMPORTANT: Replace placeholder values below with your ACTUAL business details !! --}}
    @php
        // Define variables for easier management - REPLACE PLACEHOLDERS
        $agencyName = "Morocco Quest";
        $streetAddress = "[Your Street Address]"; // e.g., "123 Riad Zitoun"
        $addressLocality = "[Your City, e.g., Marrakech]"; // e.g., "Marrakech"
        $postalCode = "[Postal Code]"; // e.g., "40000"
        $addressCountry = "Morocco";
        $telephone1 = "+212654069718"; // Main phone number
        $telephone2 = "+2125XXXXXXXX"; // Secondary phone number (optional, replace placeholder)
        $email = "contact@morocco-quest.com";
        $websiteUrl = url('/'); // Your website's base URL
        $contactPageUrl = url()->current(); // URL of this specific contact page
        $heroImageUrl = asset('assets/img/moroccan-travel-expert-contact-page-riad-setting.jpg');
        $mapsUrl = "https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d217897.62579990417!2d-8.078064296050858!3d31.63460254321897!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xdafee8d96175c59%3A0xb039616774c82317!2sMarrakesh!5e0!3m2!1sen!2sma!4v1716000000000!5m2!1sen!2sma"; // Replace EXAMPLE with your actual Google Maps embed URL
        $twitterUrl = "https://x.com/YourTwitterHandle"; // Replace placeholder
        $instagramUrl = "https://www.instagram.com/YourInstagramHandle"; // Replace placeholder
        $linkedinUrl = "https://www.linkedin.com/company/YourLinkedInPage"; // Replace placeholder
        $facebookUrl = "https://www.facebook.com/YourFacebookPage"; // Replace placeholder

        // Prepare Schema Array
        $schemaData = [
            '@context' => 'https://schema.org',
            '@type' => 'TravelAgency', // Specific type for your business
            'name' => $agencyName,
            'url' => $contactPageUrl, // URL of this contact page
            'image' => $heroImageUrl, // Representative image
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $streetAddress,
                'addressLocality' => $addressLocality,
                'postalCode' => $postalCode,
                'addressCountry' => $addressCountry,
            ],
             // Include multiple telephone numbers if applicable
            'telephone' => array_filter([$telephone1, ($telephone2 !== '+2125XXXXXXXX' ? $telephone2 : null)]), // Add secondary only if not placeholder
            'email' => $email,
            // Link to Google Maps location
            'hasMap' => $mapsUrl,
            // Define contact points for clarity
            'contactPoint' => [
                [
                    '@type' => 'ContactPoint',
                    'telephone' => $telephone1,
                    'contactType' => 'customer service', // Be specific
                    'areaServed' => 'MA', // ISO 3166-1 alpha-2 code for Morocco
                    'availableLanguage' => ['en', 'fr', 'ar'] // Example languages, adjust as needed
                ],
                // Add another contact point if the secondary number has a different purpose
                 ($telephone2 !== '+2125XXXXXXXX' ? [
                     '@type' => 'ContactPoint',
                     'telephone' => $telephone2,
                     'contactType' => 'reservations', // Example purpose
                     'areaServed' => 'MA',
                     'availableLanguage' => ['en', 'fr', 'ar']
                 ] : null)
            ],
            // List social media profiles
            'sameAs' => array_filter([
                ($twitterUrl !== 'https://x.com/YourTwitterHandle' ? $twitterUrl : null),
                ($instagramUrl !== 'https://www.instagram.com/YourInstagramHandle' ? $instagramUrl : null),
                ($linkedinUrl !== 'https://www.linkedin.com/company/YourLinkedInPage' ? $linkedinUrl : null),
                ($facebookUrl !== 'https://www.facebook.com/YourFacebookPage' ? $facebookUrl : null),
            ]),
            // Optional: Specify opening hours if applicable
            // 'openingHoursSpecification' => [
            //     '@type' => 'OpeningHoursSpecification',
            //     'dayOfWeek' => [
            //         'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'
            //     ],
            //     'opens' => '09:00',
            //     'closes' => '18:00'
            // ]
        ];
         // Clean up nulls from arrays
         $schemaData['telephone'] = array_values(array_filter($schemaData['telephone']));
         $schemaData['contactPoint'] = array_values(array_filter($schemaData['contactPoint']));
         $schemaData['sameAs'] = array_values(array_filter($schemaData['sameAs']));
         // Remove empty arrays
         if(empty($schemaData['telephone'])) unset($schemaData['telephone']);
         if(empty($schemaData['contactPoint'])) unset($schemaData['contactPoint']);
         if(empty($schemaData['sameAs'])) unset($schemaData['sameAs']);

    @endphp

    <script type="application/ld+json">
        @json($schemaData, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT)
    </script>
@endsection


@section('content')

{{-- Breadcrumb Section --}}
<section
  class="vs-breadcrumb"
  data-bg-src="{{ asset('assets/img/moroccan-travel-expert-contact-page-riad-setting.jpg') }}" {{-- Ensure background image is optimized --}}
>
  {{-- Decorative Images: Added loading="lazy" --}}
  <img
    src="{{ asset('assets/img/icons/cloud.png') }}"
    alt="Decorative cloud icon"
    class="vs-breadcrumb-icon-1 animate-parachute"
    loading="lazy" {{-- Added Lazy Loading --}}
    {{-- width="X" height="Y" --}} {{-- Recommended: Add dimensions --}}
  />
  <img
    src="{{ asset('assets/img/icons/ballon-sclation.png') }}"
    alt="Decorative hot air balloon icon"
    class="vs-breadcrumb-icon-2 animate-parachute"
    loading="lazy" {{-- Added Lazy Loading --}}
    {{-- width="X" height="Y" --}} {{-- Recommended: Add dimensions --}}
  />
  <div class="container">
    <div class="row text-center">
      <div class="col-12">
        <div class="breadcrumb-content">
          {{-- H1: Main heading for the page --}}
          <h1 class="breadcrumb-title">Contact Us</h1>

          <figcaption class="image-caption" style="font-size: medium; color: white;">
            We’re here to help you craft your perfect Moroccan journey — reach out anytime.
          </figcaption>

          <p class="visually-hidden">
            Reach out to our Morocco travel experts for personalized service and authentic cultural experiences. Whether you’re planning a trip or need assistance, we’re here to guide you every step of the way.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- Main Contact Section --}}
{{-- Schema.org TravelAgency/ContactPage data added via JSON-LD in head --}}
<section class="vs-contact space">
    <div class="container">
        <div class="row g-4 gx-xl-5 overflow-hidden">
            {{-- Contact Info Column --}}
            <div class="col-lg-5">
                <div class="title-area text-start mb-2">
                    <span class="sec-subtitle style-2">Contact Us</span>
                    {{-- H2: Section Heading --}}
                    <h2 class="sec-title">Get in touch with us</h2>
                </div>
                <div class="vs-contact-info mt-3 mb-2">
                    {{-- !! IMPORTANT: Replace ALL placeholders below with your ACTUAL business details !! --}}
                    <p>
                        <span class="text-theme-color fw-bold">Address:</span>
                        Morocco Quest, [Your Street Address], [Your City, e.g., Marrakech], [Postal Code], Morocco
                    </p>
                    <div class="vs-contact-list">
                        <div class="contact-item">
                            <span class="icon">
                                <i class="fa-solid fa-phone-volume"></i>
                            </span>
                            <div class="info">
                                {{-- H6: Sub-heading for contact type --}}
                                <h6 class="info-title">Customer Service:</h6>
                                <p>
                                    {{-- Use tel: links for phone numbers --}}
                                    <a href="tel:+212654069718" aria-label="Call Morocco Quest Customer Service at +212 654 069 718">+212 654 069 718</a>,
                                    <a href="tel:+2125XXXXXXXX" aria-label="Call Morocco Quest Secondary Number at +212 5XX XXX XXX">+212 5XX XXX XXX</a> {{-- Example secondary, replace placeholder --}}
                                </p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <span class="icon">
                                <i class="fa-light fa-envelope"></i>
                            </span>
                            <div class="info">
                                <h6 class="info-title">Email Us:</h6>
                                <p>
                                     {{-- Use mailto: link for email --}}
                                    <a href="mailto:contact@morocco-quest.com" aria-label="Email Morocco Quest at contact@morocco-quest.com">contact@morocco-quest.com</a>
                                </p>
                            </div>
                        </div>
                        {{-- Optional: Add Opening Hours here if relevant --}}
                        {{-- <div class="contact-item">
                             <span class="icon"><i class="fa-solid fa-clock"></i></span>
                             <div class="info">
                                 <h6 class="info-title">Opening Hours:</h6>
                                 <p>Monday - Friday: 9:00 AM - 6:00 PM (GMT+1)</p>
                                 <p>Saturday: 10:00 AM - 2:00 PM (GMT+1)</p>
                                 <p>Sunday: Closed</p>
                             </div>
                         </div> --}}
                    </div>
                    <div class="social-follow">
                        <span>Follow Us:</span>
                        <ul class="custom-ul">
                            {{-- !! IMPORTANT: Replace # or placeholder URLs with your actual social media profile URLs !! --}}
                            <li>
                                <a href="https://x.com/YourTwitterHandle" target="_blank" rel="noopener noreferrer" aria-label="Follow Morocco Quest on X (Twitter)">
                                    <i class="fa-brands fa-x-twitter"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.instagram.com/YourInstagramHandle" target="_blank" rel="noopener noreferrer" aria-label="Follow Morocco Quest on Instagram">
                                    <i class="fa-brands fa-instagram"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.linkedin.com/company/YourLinkedInPage" target="_blank" rel="noopener noreferrer" aria-label="Follow Morocco Quest on LinkedIn">
                                    <i class="fa-brands fa-linkedin-in"></i>
                                </a>
                            </li>
                            <li>
                                <a href="https://www.facebook.com/YourFacebookPage" target="_blank" rel="noopener noreferrer" aria-label="Follow Morocco Quest on Facebook">
                                    <i class="fa-brands fa-facebook-f"></i>
                                </a>
                            </li>
                            {{-- Add other relevant social links (e.g., Pinterest, YouTube) --}}
                        </ul>
                    </div>
                </div>
            </div>
            {{-- Contact Form Column --}}
            <div class="col-lg-7">
                {{-- Session messages for form submission feedback --}}
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                {{-- Display validation errors --}}
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <h4 class="alert-heading">Please fix the following errors:</h4>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                {{-- Contact Form --}}
                {{-- Ensure 'contact.submit' route exists and handles POST requests --}}
                <form action="{{ route('contact.submit') ?? '#' }}" method="POST" class="form-style1" novalidate> {{-- Added novalidate --}}
                    @csrf
                    <div class="row">
                        {{-- Form fields with validation error handling and accessibility attributes --}}
                        <div class="col-md-6 form-group">
                            <input name="name" type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Full Name*" value="{{ old('name') }}" required autocomplete="name" aria-label="Full Name" aria-required="true"/>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email Address*" value="{{ old('email') }}" required autocomplete="email" aria-label="Email Address" aria-required="true"/>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <input name="nationality" type="text" class="form-control @error('nationality') is-invalid @enderror" placeholder="Nationality*" value="{{ old('nationality') }}" required autocomplete="country-name" aria-label="Nationality" aria-required="true"/>
                            @error('nationality')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <input name="phone" type="tel" class="form-control @error('phone') is-invalid @enderror" placeholder="Phone Number*" value="{{ old('phone') }}" required autocomplete="tel" aria-label="Phone Number" aria-required="true"/>
                            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <input name="arrival_date" type="date" class="form-control @error('arrival_date') is-invalid @enderror" placeholder="Arrival Date*" value="{{ old('arrival_date') }}" min="{{ date('Y-m-d') }}" required aria-label="Planned Arrival Date" aria-required="true"/>
                            @error('arrival_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 form-group">
                             <input name="duration_days" type="number" min="1" class="form-control @error('duration_days') is-invalid @enderror" placeholder="Trip Duration (Days)*" value="{{ old('duration_days') }}" required aria-label="Trip Duration in Days" aria-required="true"/>
                            @error('duration_days')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 form-group">
                            <input name="adults" type="number" min="1" class="form-control @error('adults') is-invalid @enderror" placeholder="Number of Adults (>12)*" value="{{ old('adults') }}" required aria-label="Number of Adults (Over 12)" aria-required="true"/>
                            @error('adults')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 form-group">
                             <input name="children" type="number" min="0" class="form-control @error('children') is-invalid @enderror" placeholder="Number of Children (2-11)" value="{{ old('children') ?? 0 }}" aria-label="Number of Children (2-11)"/> {{-- Default to 0 --}}
                            @error('children')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12 form-group">
                            <textarea name="travel_ideas" class="form-control @error('travel_ideas') is-invalid @enderror" placeholder="Tell us about your travel ideas (e.g., interests, places, pace, special occasions)" rows="4" aria-label="Your Travel Ideas">{{ old('travel_ideas') }}</textarea>
                            @error('travel_ideas')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12 form-group mt-3 mb-0">
                            <button class="vs-btn" type="submit" aria-label="Send Your Inquiry">Send Message</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

{{-- Google Map Embed --}}
<div class="map-layout1">
    {{-- !! IMPORTANT: Replace src with your actual Google Maps embed URL !! --}}
    <iframe
        title="Morocco Quest Location Map" {{-- Added descriptive title --}}
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d217897.62579990417!2d-8.078064296050858!3d31.63460254321897!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xdafee8d96175c59%3A0xb039616774c82317!2sMarrakesh!5e0!3m2!1sen!2sma!4v1716000000000!5m2!1sen!2sma" {{-- EXAMPLE for Marrakech - Replace this --}}
        height="500"
        style="border:0; width: 100%;" {{-- Ensures map is responsive --}}
        allowfullscreen=""
        loading="lazy" {{-- Added Lazy Loading for map iframe --}}
        referrerpolicy="no-referrer-when-downgrade"> {{-- Recommended referrer policy --}}
    </iframe>
</div>

@endsection