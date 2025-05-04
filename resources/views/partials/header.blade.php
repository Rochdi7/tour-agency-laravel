{{-- resources/views/partials/header.blade.php --}}

<!--================= Mobile Menu =================-->
<div class="vs-menu-wrapper">
  <div class="vs-menu-area text-center">
    <div class="mobile-logo">
      <a href="{{ url('/') }}"> {{-- Use url helper for home --}}
        <img src="{{ asset('assets/img/logo-bg.png') }}" alt="Morocco Quest" class="logo" />
      </a>
      <button class="vs-menu-toggle"><i class="fal fa-times"></i></button>
    </div>
    <div class="vs-mobile-menu">
      <ul>
        {{-- Note: Update hrefs to actual Laravel routes or URLs later --}}
        <li class="menu-item-has-children">
          <a href="#">Multi-Day Tours</a> {{-- Example: Update href --}}
          <ul class="sub-menu">
            <li><a href="#">Garden Tours</a></li> {{-- Example: Update href --}}
            <li><a href="#">Art Tours</a></li> {{-- Example: Update href --}}
            <li><a href="#">Classical Tours</a></li> {{-- Example: Update href --}}
          </ul>
        </li>
        <li class="menu-item-has-children">
          <a href="#">One-Day Tours</a> {{-- Example: Update href --}}
          <ul class="sub-menu">
             <li><a href="#">City Tours</a></li> {{-- Example: Update href --}}
             <li><a href="#">Day Trips</a></li> {{-- Example: Update href --}}
             <li><a href="#">Local Experiences</a></li> {{-- Example: Update href --}}
             <li><a href="#">Outdoor Activities</a></li> {{-- Example: Update href --}}
          </ul>
        </li>
        
        <li>
          <a href="{{ url('/blog') }}">Blog</a> {{-- Use url helper --}}
        </li>
        {{-- CHANGE: InfoHub dropdown containing About, FAQ, Terms, Privacy --}}
        <li class="menu-item-has-children">
            <a href="#">Info Hub</a> {{-- Consider linking to a relevant page or just # --}}
            <ul class="sub-menu">
                <li><a href="{{ url('/about') }}">About Us</a></li> {{-- Use url helper --}}
                <li><a href="{{ url('/faq') }}">FAQ</a></li> {{-- Use url helper --}}
                <li><a href="{{ url('/terms-conditions') }}">Terms & Conditions</a></li> {{-- Use url helper --}}
                <li><a href="{{ url('/privacy-policy') }}">Privacy Policy</a></li> {{-- Use url helper --}}
            </ul>
        </li>
        <li>
          <a href="{{ url('/contact') }}">Contact</a> {{-- Use url helper --}}
        </li>
      </ul>
    </div>
  </div>
</div>

<!-- ================= Popup Search Box ================= -->
<div class="popup-search-box">
  <button class="searchClose">
    <i class="fal fa-times"></i>
  </button>
  {{-- Make sure the 'search' route is defined in web.php --}}
  <form action="{{ route('search') }}" method="GET">
    <input
      type="text"
      class="border-theme"
      placeholder="What are you looking for"
      name="query" {{-- Use 'query' or 'search' as the input name --}}
    />
    <button type="submit">
      <i class="fal fa-search"></i>
    </button>
  </form>
</div>

<!--================= Header Area =================-->
{{-- This includes the top bar and main navigation --}}
<header class="vs-header layout1">
  <!-- Main Menu Area -->
  <div class="sticky-wrapper position-relative">
    <div class="header-top-wrap">
      <div class="container custom-container">
        <div class="row">
          <div class="col-lg-12">
            <div class="header-top">
              <div
                class="row g-3 justify-content-between align-items-center"
              >
                <div class="col-md-6 d-none d-md-block">
                  <div class="contact-info">
                    <ul class="custom-ul">
                      <li>
                        <i class="fa-solid fa-phone-volume"></i>
                        <a href="tel:+212654069718">+212654069718</a> {{-- Keep specific number --}}
                      </li>
                      <li>
                        {{-- SVG Divider --}}
                        <svg xmlns="http://www.w3.org/2000/svg" width="4" height="22" viewBox="0 0 4 22" fill="none"> <line x1="0.75" y1="2.774e-08" x2="0.749999" y2="21.6114" stroke="white" stroke-opacity="0.3" stroke-width="1.5"/> <line x1="3.5" y1="3.92926" x2="3.5" y2="17.682" stroke="white" stroke-opacity="0.3"/> </svg>
                      </li>
                      <li>
                        <i class="fa-solid fa-envelope"></i>
                        <a href="mailto:contact@morocco-quest.com"> contact@morocco-quest.com </a>
                      </li>
                    </ul>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="social-share">
                    <span class="info-share">Follow on:</span>
                    {{-- SVG Divider --}}
                    <svg xmlns="http://www.w3.org/2000/svg" width="4" height="22" viewBox="0 0 4 22" fill="none"> <line x1="0.75" y1="2.774e-08" x2="0.749999" y2="21.6114" stroke="white" stroke-opacity="0.3" stroke-width="1.5"/> <line x1="3.5" y1="3.92941" x2="3.5" y2="17.6821" stroke="white" stroke-opacity="0.3"/> </svg>
                    <ul class="custom-ul">
                      {{-- Add actual social links --}}
                      <li> <a href="https://x.com/" target="_blank" aria-label="Twitter"> <i class="fa-brands fa-x-twitter"></i> </a> </li>
                      <li> <a href="https://www.facebook.com/" target="_blank" aria-label="Facebook"> <i class="fab fa-facebook-f"></i> </a> </li>
                      <li> <a href="https://www.linkedin.com/" target="_blank" aria-label="LinkedIn"> <i class="fab fa-linkedin-in"></i> </a> </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="container custom-container">
      <div class="row justify-content-between align-items-center">
        <div class="col-xl-3 col-lg-auto">
          <div
            class="header-logo d-flex justify-content-between align-items-center"
          >
            <a href="{{ url('/') }}"
              ><img src="{{ asset('assets/img/logo-bg.png') }}" alt="Morocco Quest" class="logo"
            /></a>
            <div class="d-flex align-items-center gap-3">
              {{-- Search Toggle for Mobile --}}
              <button class="wc-link2 searchBoxTggler d-lg-none" aria-label="Open Search">
                 <svg xmlns="http://www.w3.org/2000/svg" width="21" height="20" viewBox="0 0 21 20" fill="none" aria-hidden="true"> <path d="M20.4174 16.6954L17.2213 13.4773C19.3155 10.0703 18.8936 5.54217 15.9593 2.58766C12.5328 -0.862552 6.9769 -0.862552 3.55037 2.58766C0.123835 6.03787 0.123835 11.6322 3.55037 15.0824C6.5354 18.088 11.1341 18.4736 14.5333 16.2469L17.7019 19.4335C18.4521 20.1888 19.6711 20.1888 20.4213 19.4335C21.1675 18.6781 21.1675 17.4507 20.4174 16.6954ZM5.711 12.9029C3.48395 10.6604 3.48395 7.00959 5.711 4.76715C7.93805 2.52471 11.5638 2.52471 13.7909 4.76715C16.018 7.00959 16.018 10.6604 13.7909 12.9029C11.5638 15.1453 7.93805 15.1453 5.711 12.9029Z" fill="#F6F5F5"/> </svg>
              </button>
              {{-- Mobile Menu Toggle --}}
              <button class="vs-menu-toggle d-inline-block d-lg-none" aria-label="Open Mobile Menu">
                <i class="fal fa-bars"></i>
              </button>
            </div>
          </div>
        </div>
        <div
          class="col-xl-9 col-lg-auto d-none d-lg-flex justify-content-end gap-md-4 gap-xl-5"
        >
        {{-- Desktop Navigation --}}
        <nav class="main-menu menu-style1 d-none d-lg-block">
          <ul class="d-flex justify-content-center align-items-center">
            {{-- Note: Update hrefs to actual Laravel routes or URLs later --}}
             <li class="menu-item-has-children">
                <a href="#">Multi-Day Tours</a> {{-- Example: Update href --}}
                <ul class="sub-menu">
                   <li><a href="#">Garden Tours</a></li> {{-- Example: Update href --}}
                   <li><a href="#">Art Tours</a></li> {{-- Example: Update href --}}
                   <li><a href="#">Classical Tours</a></li> {{-- Example: Update href --}}
                </ul>
             </li>
             <li class="menu-item-has-children">
                <a href="#">One-Day Tours</a> {{-- Example: Update href --}}
                <ul class="sub-menu">
                   <li><a href="#">City Tours</a></li> {{-- Example: Update href --}}
                   <li><a href="#">Day Trips</a></li> {{-- Example: Update href --}}
                   <li><a href="#">Local Experiences</a></li> {{-- Example: Update href --}}
                   <li><a href="#">Outdoor Activities</a></li> {{-- Example: Update href --}}
                </ul>
             </li>
             <li>
                <a href="{{ url('/blog') }}">Blog</a> {{-- Use url helper --}}
             </li>
             {{-- CHANGE: InfoHub dropdown containing About, FAQ, Terms, Privacy --}}
             <li class="menu-item-has-children">
                <a href="#">Info Hub</a> {{-- Consider linking to a relevant page or just # --}}
                <ul class="sub-menu">
                    <li><a href="{{ url('/about') }}">About Us</a></li> {{-- Use url helper --}}
                    <li><a href="{{ url('/faq') }}">FAQ</a></li> {{-- Use url helper --}}
                    <li><a href="{{ url('/terms-conditions') }}">Terms & Conditions</a></li> {{-- Use url helper --}}
                    <li><a href="{{ url('/privacy-policy') }}">Privacy Policy</a></li> {{-- Use url helper --}}
                </ul>
             </li>
             <li>
                <a href="{{ url('/contact') }}">Contact</a> {{-- Use url helper --}}
             </li>
          </ul>
        </nav>
        {{-- Header Buttons (Search Toggle, Plan Button) --}}
          <div class="header-wc style2">
            <button class="wc-link2 searchBoxTggler" aria-label="Open Search">
              <svg xmlns="http://www.w3.org/2000/svg" width="21" height="20" viewBox="0 0 21 20" fill="none" aria-hidden="true"> <path d="M20.4174 16.6954L17.2213 13.4773C19.3155 10.0703 18.8936 5.54217 15.9593 2.58766C12.5328 -0.862552 6.9769 -0.862552 3.55037 2.58766C0.123835 6.03787 0.123835 11.6322 3.55037 15.0824C6.5354 18.088 11.1341 18.4736 14.5333 16.2469L17.7019 19.4335C18.4521 20.1888 19.6711 20.1888 20.4213 19.4335C21.1675 18.6781 21.1675 17.4507 20.4174 16.6954ZM5.711 12.9029C3.48395 10.6604 3.48395 7.00959 5.711 4.76715C7.93805 2.52471 11.5638 2.52471 13.7909 4.76715C16.018 7.00959 16.018 10.6604 13.7909 12.9029C11.5638 15.1453 7.93805 15.1453 5.711 12.9029Z" fill="#F6F5F5"/> </svg>
            </button>
            {{-- SVG Divider --}}
            <svg xmlns="http://www.w3.org/2000/svg" width="6" height="39" viewBox="0 0 6 39" fill="none" aria-hidden="true"> <rect x="5" width="1" height="39" fill="#D9D9D9" fill-opacity="0.7"/> <rect y="9" width="1" height="20" fill="#D9D9D9" fill-opacity="0.7"/> </svg>
            {{-- Update href to planning/contact page fragment --}}
            <a href="{{ url('/contact') }}#plan" class="vs-btn style8">
              <span>let’s plan</span>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>
<!--================= Header Area end =================-->

{{-- Removed the Sticky Navbar clone section (id="navbars") assuming the main header handles sticky behavior via JS --}}