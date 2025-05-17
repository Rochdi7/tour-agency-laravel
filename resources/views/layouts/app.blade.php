{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
{{-- 6. Correct lang attribute using Laravel's locale helper --}}
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  {{-- 11. UTF-8 Charset --}}
  <meta charset="utf-8" />
  <meta http-equiv="x-ua-compatible" content="ie=edge" />

  {{-- 1. Dynamic Title (pulled from specific page views) --}}
  <title>@yield('title', 'Morocco Quest - Tours, Excursions & Activities')</title>

  <meta name="author" content="Morocco Quest Team" /> {{-- Changed author --}}

  {{-- Dynamic Description (define in each view or use this default) --}}
  <meta name="description"
    content="@yield('description', 'Explore unforgettable Morocco tours, day trips, Sahara desert excursions, Atlas Mountains activities, and car rentals with Morocco Quest. Plan your adventure today!')" />

  {{-- Keywords Meta Tag (Note: Largely ignored by Google, focus on content quality) --}}
  <meta name="keywords"
    content="@yield('keywords', 'Morocco tours, Morocco excursions, Morocco activities, car rental Morocco, Sahara tours, Marrakech trips, Fes tours, desert trips, Atlas mountains, Morocco travel')" />

  <meta name="robots" content="INDEX,FOLLOW" />

  {{-- Mobile Specific Metas --}}
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

  {{-- 5. Canonical Tag --}}
  <link rel="canonical" href="{{ url()->current() }}" />

  <!-- =======================
     🌟 APPLE TOUCH ICONS
======================= -->
  <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('assets/img/favicons/apple-icon-57x57.png') }}">
  <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('assets/img/favicons/apple-icon-60x60.png') }}">
  <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('assets/img/favicons/apple-icon-72x72.png') }}">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/favicons/apple-icon-76x76.png') }}">
  <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('assets/img/favicons/apple-icon-114x114.png') }}">
  <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('assets/img/favicons/apple-icon-120x120.png') }}">
  <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('assets/img/favicons/apple-icon-144x144.png') }}">
  <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('assets/img/favicons/apple-icon-152x152.png') }}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/favicons/apple-icon-180x180.png') }}">

  <!-- =======================
     🌟 STANDARD FAVICONS
======================= -->
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/img/favicons/favicon-16x16.png') }}">
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/img/favicons/favicon-32x32.png') }}">
  <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('assets/img/favicons/favicon-96x96.png') }}">
  <link rel="icon" type="image/svg+xml" href="{{ asset('assets/img/favicons/favicon.svg') }}">
  <link rel="shortcut icon" href="{{ asset('assets/img/favicons/favicon.ico') }}">

  <!-- =======================
     🌟 ANDROID & WINDOWS ICONS
======================= -->
  <link rel="icon" type="image/png" sizes="36x36" href="{{ asset('assets/img/favicons/android-icon-36x36.png') }}">
  <link rel="icon" type="image/png" sizes="48x48" href="{{ asset('assets/img/favicons/android-icon-48x48.png') }}">
  <link rel="icon" type="image/png" sizes="72x72" href="{{ asset('assets/img/favicons/android-icon-72x72.png') }}">
  <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('assets/img/favicons/android-icon-96x96.png') }}">
  <link rel="icon" type="image/png" sizes="144x144" href="{{ asset('assets/img/favicons/android-icon-144x144.png') }}">
  <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets/img/favicons/android-icon-192x192.png') }}">

  <!-- =======================
     🌟 MANIFEST & BROWSER CONFIG
======================= -->
  <link rel="manifest" href="{{ asset('assets/img/favicons/site.webmanifest') }}">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="{{ asset('assets/img/favicons/ms-icon-144x144.png') }}">
  <meta name="theme-color" content="#ffffff">
  <meta name="apple-mobile-web-app-title" content="MoroccoQuest">
  <meta name="application-name" content="MoroccoQuest">
  <meta name="msapplication-config" content="{{ asset('assets/img/favicons/browserconfig.xml') }}">


  <!-- Browser Configuration -->
  <meta name="msapplication-config" content="{{ asset('assets/img/favicons/browserconfig.xml') }}">


  {{-- 10. Sitemap Link --}}
  <link rel="sitemap" type="application/xml" title="Sitemap" href="{{ url('/sitemap.xml') }}" />

  {{-- 12. Social Sharing Meta Tags (Open Graph & Twitter Card) --}}
  {{-- Replace placeholder image and potentially description --}}
  <meta property="og:url" content="{{ url()->current() }}" />
  <meta property="og:type" content="website" /> {{-- Use 'article' for blog posts etc. --}}
  <meta property="og:title" content="@yield('title', 'Morocco Quest - Tours, Excursions & Activities')" />
  <meta property="og:description"
    content="@yield('description', 'Explore unforgettable Morocco tours, day trips, Sahara desert excursions, Atlas Mountains activities, and car rentals with Morocco Quest. Plan your adventure today!')" />
  <meta property="og:image" content="{{ asset('assets/img/morocco-quest-social-share.webp') }}" /> {{-- !! IMPORTANT:
  Create & replace with your actual share image URL (e.g., 1200x630px) !! --}}
  <meta property="og:site_name" content="Morocco Quest" />
  {{-- Optional: Add locale if needed e.g.,
  <meta property="og:locale" content="{{ str_replace('_', '-', app()->getLocale()) }}" /> --}}

  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:site" content="@YourTwitterHandle" /> {{-- Optional: Replace with your Twitter handle --}}
  <meta name="twitter:title" content="@yield('title', 'Morocco Quest - Tours, Excursions & Activities')" />
  <meta name="twitter:description"
    content="@yield('description', 'Explore unforgettable Morocco tours, day trips, Sahara desert excursions, Atlas Mountains activities, and car rentals with Morocco Quest. Plan your adventure today!')" />
  <meta name="twitter:image" content="{{ asset('assets/img/morocco-quest-social-share.webp') }}" /> {{-- !! IMPORTANT:
  Use the same image as og:image !! --}}


  {{-- Google Fonts --}}
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Amatic+SC:wght@400;700&display=swap" rel="stylesheet">
  <link
    href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=Bricolage+Grotesque:opsz,wght@12..96,200..800&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap"
    rel="stylesheet" />

  {{-- All CSS File --}}
  <link rel="stylesheet" href="{{ asset('assets/css/plugins.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />
  <link rel="stylesheet" href="{{ asset('assets/css/new_style.css') }}">

  {{-- Stack for page-specific styles if needed --}}
  @stack('styles')
</head>

<body class="vs-body">
  <!--[if lte IE 9]>
      <p class="browserupgrade">
        You are using an <strong>outdated</strong> browser. Please
        <a href="https://browsehappy.com/">upgrade your browser</a> to improve
        your experience and security.
      </p>
    <![endif]-->

  {{-- Preloader --}}
  <div class="preloader">
    <button class="vs-btn preloaderCls">Cancel Preloader</button>
    <div class="preloader-inner">
      <img src="{{ asset('assets/img/logo-white.bg.webp') }}" alt="Morocco Quest Logo Preloader" style="max-height: 500px; max-width: 700px;" /> {{-- Improved alt text
      --}}
      <span class="loader"></span>
    </div>
  </div>

  {{-- Include Header Partial --}}
  @include('partials.header')

  {{-- Main Content Area - Yielded from specific views --}}
  @yield('content')

  {{-- Include Footer Partial --}}
  @include('partials.footer')

  {{-- All Js File --}}
  <script src="{{ asset('assets/js/vendor/jquery-3.6.0.min.js') }}"></script>
  <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
  <script src="{{ asset('assets/js/moment.min.js') }}"></script>
  <script src="{{ asset('assets/js/daterangepicker.min.js') }}"></script>
  <script src="{{ asset('assets/js/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/js/wow.min.js') }}"></script>
  <script src="{{ asset('assets/js/jquery.magnific-popup.min.js') }}"></script>
  <script src="{{ asset('assets/js/imagesloaded.pkgd.min.js') }}"></script>
  <script src="{{ asset('assets/js/gsap.min.js') }}"></script>
  <script src="{{ asset('assets/js/ScrollTrigger.min.js') }}"></script>
  <script src="{{ asset('assets/js/ScrollToPlugin.min.js') }}"></script>
  <script src="{{ asset('assets/js/SplitText.min.js') }}"></script>

  {{-- Main Js File --}}
  <script src="{{ asset('assets/js/main.js') }}"></script>

  {{-- Stack for page-specific scripts if needed --}}
  @stack('scripts')
</body>

</html>