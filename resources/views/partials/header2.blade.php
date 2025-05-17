{{-- resources/views/partials/header2.blade.php --}}

<!--================= Mobile Menu =================-->
<div class="vs-menu-wrapper">
  <div class="vs-menu-area text-center">
    <div class="mobile-logo">
      {{-- Use url() for home link like header1, but keep header2's logo asset --}}
      <a href="{{ url('/') }}">
        <img src="{{ asset('assets/img/logo-bg-wide-white.webp') }}" alt="Morocco Quest" class="logo" /> {{-- Kept header2 logo,
        updated alt text --}}
      </a>
      <button class="vs-menu-toggle"><i class="fal fa-times"></i></button>
    </div>
    <div class="vs-mobile-menu">
      {{-- *** START: Mobile Menu Items from header.blade.php *** --}}
      <ul>
        <li class="menu-item-has-children">
          <a href="#">Multi-Day Tours</a> {{-- Example: Update href later --}}
          <ul class="sub-menu">
            <li><a href="#">Garden Tours</a></li> {{-- Example: Update href later --}}
            <li><a href="#">Art Tours</a></li> {{-- Example: Update href later --}}
            <li><a href="#">Classical Tours</a></li> {{-- Example: Update href later --}}
          </ul>
        </li>
        <li class="menu-item-has-children">
          <a href="#">One-Day Tours</a> {{-- Example: Update href later --}}
          <ul class="sub-menu">
            <li><a href="#">City Tours</a></li> {{-- Example: Update href later --}}
            <li><a href="#">Day Trips</a></li> {{-- Example: Update href later --}}
            <li><a href="#">Local Experiences</a></li> {{-- Example: Update href later --}}
            <li><a href="#">Outdoor Activities</a></li> {{-- Example: Update href later --}}
          </ul>
        </li>
        <li>
          <a href="{{ url('/blog') }}">Blog</a>
        </li>
        <li class="menu-item-has-children">
          <a href="#">Info Hub</a> {{-- Consider linking to a relevant page or just # --}}
          <ul class="sub-menu">
            <li><a href="{{ url('/about') }}">About Us</a></li>
            <li><a href="{{ url('/faq') }}">FAQ</a></li>
            <li><a href="{{ url('/terms-and-conditions') }}">Terms & Conditions</a></li>
            <li><a href="{{ url('/privacy-policy') }}">Privacy Policy</a></li>
          </ul>
        </li>
        <li>
          <a href="{{ url('/contact') }}">Contact</a>
        </li>
      </ul>
      {{-- *** END: Mobile Menu Items from header.blade.php *** --}}
    </div>
  </div>
</div>

<!-- ================= Popup Search Box ================= -->
<div class="popup-search-box">
  <button class="searchClose"><i class="fal fa-times"></i></button>
  {{-- Use route('search') and name="query" like header.blade.php --}}
  <form action="{{ route('search') }}" method="GET">
    <input type="text" name="query" {{-- Use name="query" --}} class="border-theme"
      placeholder="What are you looking for" required {{-- Kept required from header2 --}} />
    <button type="submit"><i class="fal fa-search"></i></button>
  </form>
</div>

{{-- This 'sticky navbar' might be integrated with the header below in some theme JS logic. --}}
{{-- Kept structurally, but menu items updated. --}}
<!-- ================= Sticky Navbar ================= -->
<div id="navbars" class="header-sticky navbars"> {{-- Kept structure from header2 --}}
  <div class="container custom-container">
    <div class="row justify-content-between align-items-center">
      <div class="col-auto col-lg-2">
        <button class="vs-menu-toggle d-inline-block d-lg-none">
          <i class="fal fa-bars"></i>
        </button>
        <div class="logo d-none d-lg-block">
          {{-- Use url() for home link, keep header2 logo, update alt --}}
          <a href="{{ url('/') }}">
            <img src="{{ asset('assets/img/logo-bg-wide-white.webp') }}" alt="Morocco Quest" class="logo" />
          </a>
        </div>
      </div>
      <div class="col-xl-auto col-lg-auto col-sm-3 d-none d-sm-block">
        <nav class="main-menu d-none d-lg-block"> {{-- Kept class from header2 --}}
          {{-- *** START: Sticky Desktop Menu Items from header.blade.php *** --}}
          <ul>
            <li class="menu-item-has-children">
              <a href="{{ route('tours.multi_day') }}">Multi-Day Tours</a>
              <ul class="sub-menu">
                <li><a href="{{ route('tours.type', 'Garden Tours') }}">Garden Tours</a></li>
                <li><a href="{{ route('tours.type', 'Art Tours') }}">Art Tours</a></li>
                <li><a href="{{ route('tours.type', 'Classical Tours') }}">Classical Tours</a></li>
              </ul>
            </li>
            <li class="menu-item-has-children">
              <a href="{{ route('tours.one_day') }}">One-Day Tours</a>
              <ul class="sub-menu">
                <li><a href="{{ route('tours.type', 'City Tours') }}">City Tours</a></li>
                <li><a href="{{ route('tours.type', 'Day Trips') }}">Day Trips</a></li>
                <li><a href="{{ route('tours.type', 'Local Experiences') }}">Local Experiences</a></li>
                <li><a href="{{ route('tours.type', 'Outdoor Activities') }}">Outdoor Activities</a></li>
              </ul>
            </li>
            <li>
              <a href="{{ url('/blog') }}">Blog</a>
            </li>
            <li class="menu-item-has-children">
              <a href="#">Info Hub</a> {{-- Consider linking to a relevant page or just # --}}
              <ul class="sub-menu">
                <li><a href="{{ url('/about') }}">About Us</a></li>
                <li><a href="{{ url('/faq') }}">FAQ</a></li>
                <li><a href="{{ url('/terms-and-conditions') }}">Terms & Conditions</a></li>
                <li><a href="{{ url('/privacy-policy') }}">Privacy Policy</a></li>
              </ul>
            </li>
            <li>
              <a href="{{ url('/contact') }}">Contact</a>
            </li>
          </ul>
          {{-- *** END: Sticky Desktop Menu Items from header.blade.php *** --}}
        </nav>
        <div class="logo d-lg-none">
          {{-- Mobile logo inside sticky bar - use url(), keep header2 logo, update alt --}}
          <a href="{{ url('/') }}">
            <img src="{{ asset('assets/img/logo-bg-wide-white.webp') }}" alt="Morocco Quest" class="logo" />
          </a>
        </div>
      </div>
      <div class="col-xl-3 col-md-auto col-auto">
        <div class="header-wc style2"> {{-- Kept classes from header2 --}}
          <button class="wc-link2 searchBoxTggler text-title-color">
            {{-- Kept SVG Icon from header2 --}}
            <svg xmlns="http://www.w3.org/2000/svg" width="21" height="20" viewBox="0 0 21 20" fill="none"
              aria-hidden="true">
              <path
                d="M20.4174 16.6954L17.2213 13.4773C19.3155 10.0703 18.8936 5.54217 15.9593 2.58766C12.5328 -0.862552 6.9769 -0.862552 3.55037 2.58766C0.123835 6.03787 0.123835 11.6322 3.55037 15.0824C6.5354 18.088 11.1341 18.4736 14.5333 16.2469L17.7019 19.4335C18.4521 20.1888 19.6711 20.1888 20.4213 19.4335C21.1675 18.6781 21.1675 17.4507 20.4174 16.6954ZM5.711 12.9029C3.48395 10.6604 3.48395 7.00959 5.711 4.76715C7.93805 2.52471 11.5638 2.52471 13.7909 4.76715C16.018 7.00959 16.018 10.6604 13.7909 12.9029C11.5638 15.1453 7.93805 15.1453 5.711 12.9029Z"
                fill="#F6F5F5"></path> {{-- Note: Fill color might need adjustment based on theme CSS --}}
            </svg>
          </button>
          {{-- Kept SVG Divider from header2 --}}
          <svg xmlns="http://www.w3.org/2000/svg" width="6" height="39" viewBox="0 0 6 39" fill="none"
            aria-hidden="true">
            <rect x="5" width="1" height="39" fill="#D9D9D9" fill-opacity="0.7"></rect>
            <rect y="9" width="1" height="20" fill="#D9D9D9" fill-opacity="0.7"></rect>
          </svg>
          <div class="logo d-none d-sm-block">
            {{-- Use 'let's plan' link from header1, keep button style from header2 (style10 then style8 was used, stick
            with style8 like header1) --}}
            <a href="{{ url('/contact') }}#plan" class="vs-btn style8"> {{-- Kept style8, updated link --}}
              <span>let’s plan</span>
            </a>
          </div>
          <div class="logo d-sm-none">
            {{-- Mobile logo in sticky bar's button area --}}
            <a href="{{ url('/') }}">
              <img src="{{ asset('assets/img/logo-bg-wide-white.webp') }}" alt="Morocco Quest" class="logo" />
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!--================= Header Area =================-->
<header class="vs-header layout2"> {{-- Kept layout2 class --}}
  <!-- Main Menu Area -->
  <div class="sticky-wrapper position-relative">
    <div class="header-top-wrap"> {{-- Kept structure from header2 --}}
      <div class="container custom-container">
        <div class="row">
          <div class="col-lg-12">
            <div class="header-top">
              <div class="row g-3 justify-content-between align-items-center">
                <div class="col-md-6 d-none d-md-block">
                  <div class="contact-info">
                    {{-- *** START: Top Bar Contact Info from header.blade.php *** --}}
                    <ul class="custom-ul">
                      <li>
                        <i class="fa-solid fa-phone-volume"></i>
                        <a href="tel:+212654069718">+212654069718</a> {{-- Updated Phone --}}
                      </li>
                      <li>
                        {{-- SVG Divider (kept from header2, identical to header1's) --}}
                        <svg xmlns="http://www.w3.org/2000/svg" width="4" height="22" viewBox="0 0 4 22" fill="none"
                          aria-hidden="true">
                          <line x1="0.75" y1="2.774e-08" x2="0.749999" y2="21.6114" stroke="white" stroke-opacity="0.3"
                            stroke-width="1.5" />
                          <line x1="3.5" y1="3.92926" x2="3.5" y2="17.682" stroke="white" stroke-opacity="0.3" />
                        </svg>
                      </li>
                      <li>
                        <i class="fa-solid fa-envelope"></i>
                        <a href="mailto:contact@morocco-quest.com"> contact@morocco-quest.com </a> {{-- Updated Email
                        --}}
                      </li>
                    </ul>
                    {{-- *** END: Top Bar Contact Info from header.blade.php *** --}}
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="social-share">
                    <span class="info-share">Follow on:</span>
                    {{-- SVG Divider (kept from header2, identical to header1's) --}}
                    <svg xmlns="http://www.w3.org/2000/svg" width="4" height="22" viewBox="0 0 4 22" fill="none"
                      aria-hidden="true">
                      <line x1="0.75" y1="2.774e-08" x2="0.749999" y2="21.6114" stroke="white" stroke-opacity="0.3"
                        stroke-width="1.5" />
                      <line x1="3.5" y1="3.92941" x2="3.5" y2="17.6821" stroke="white" stroke-opacity="0.3" />
                    </svg>
                    {{-- *** START: Top Bar Social Links from header.blade.php *** --}}
                    <ul class="custom-ul">
                      <li> <a href="https://x.com/mounirakajia" target="_blank" aria-label="Twitter"> <i
                            class="fa-brands fa-x-twitter"></i> </a> </li>
                      <li> <a href="https://www.facebook.com/p/Colored-Morocco-100070928444096/" target="_blank"
                          aria-label="Facebook"> <i class="fab fa-facebook-f"></i> </a> </li>
                      <li> <a href="https://www.instagram.com/colored.morocco/" target="_blank" aria-label="LinkedIn">
                          <i class="fa-brands fa-instagram"></i> </a> </li>
                    </ul>
                    {{-- *** END: Top Bar Social Links from header.blade.php *** --}}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="header-bottom"> {{-- Kept structure from header2 --}}
      <div class="container custom-container">
        <div class="row justify-content-between align-items-center">
          <div class="col-xl-3 col-lg-auto">
            <div class="header-logo d-flex justify-content-between align-items-center">
              {{-- Use url() for home link, keep header2 logo, update alt --}}
              <a href="{{ url('/') }}">
                <img src="{{ asset('assets/img/logo-bg-wide.webp') }}" alt="Morocco Quest" class="logo" /> {{-- Kept header2
                V2 logo, updated alt text --}}
              </a>
              <div class="d-flex align-items-center gap-3">
                <button class="wc-link2 searchBoxTggler d-lg-none">
                  {{-- Kept header2 Mobile Search Icon --}}
                  <svg xmlns="http://www.w3.org/2000/svg" width="21" height="20" viewBox="0 0 21 20" fill="none"
                    aria-hidden="true">
                    <path
                      d="M20.4174 16.6954L17.2213 13.4773C19.3155 10.0703 18.8936 5.54217 15.9593 2.58766C12.5328 -0.862552 6.9769 -0.862552 3.55037 2.58766C0.123835 6.03787 0.123835 11.6322 3.55037 15.0824C6.5354 18.088 11.1341 18.4736 14.5333 16.2469L17.7019 19.4335C18.4521 20.1888 19.6711 20.1888 20.4213 19.4335C21.1675 18.6781 21.1675 17.4507 20.4174 16.6954ZM5.711 12.9029C3.48395 10.6604 3.48395 7.00959 5.711 4.76715C7.93805 2.52471 11.5638 2.52471 13.7909 4.76715C16.018 7.00959 16.018 10.6604 13.7909 12.9029C11.5638 15.1453 7.93805 15.1453 5.711 12.9029Z"
                      fill="#141414"></path> {{-- Note: Fill color might need adjustment based on theme CSS --}}
                  </svg>
                </button>
                <button class="vs-menu-toggle style2 d-inline-block d-lg-none"> {{-- Kept header2 style2 class --}}
                  <i class="fal fa-bars"></i>
                </button>
              </div>
            </div>
          </div>
          <div class="col-xl-9 col-lg-auto d-none d-lg-flex justify-content-end gap-md-4 gap-xl-5">
            <nav class="main-menu menu-style1 v2 d-none d-lg-block"> {{-- Kept menu-style1 v2 classes --}}
              {{-- *** START: Main Desktop Menu Items from header.blade.php *** --}}
              <ul class="d-flex justify-content-center align-items-center">
                <li class="menu-item-has-children">
                  <a href="{{ route('tours.multi_day') }}">Multi-Day Tours</a>
                  <ul class="sub-menu">
                    <li><a href="{{ route('tours.type', 'Garden Tours') }}">Garden Tours</a></li>
                    <li><a href="{{ route('tours.type', 'Art Tours') }}">Art Tours</a></li>
                    <li><a href="{{ route('tours.type', 'Classical Tours') }}">Classical Tours</a></li>
                  </ul>
                </li>
                <li class="menu-item-has-children">
                  <a href="{{ route('tours.one_day') }}">One-Day Tours</a>
                  <ul class="sub-menu">
                    <li><a href="{{ route('tours.type', 'City Tours') }}">City Tours</a></li>
                    <li><a href="{{ route('tours.type', 'Day Trips') }}">Day Trips</a></li>
                    <li><a href="{{ route('tours.type', 'Local Experiences') }}">Local Experiences</a></li>
                    <li><a href="{{ route('tours.type', 'Outdoor Activities') }}">Outdoor Activities</a></li>
                  </ul>
                </li>
                <li>
                  <a href="{{ url('/blog') }}">Blog</a>
                </li>
                <li class="menu-item-has-children">
                  <a href="#">Info Hub</a> {{-- Consider linking to a relevant page or just # --}}
                  <ul class="sub-menu">
                    <li><a href="{{ url('/about') }}">About Us</a></li>
                    <li><a href="{{ url('/faq') }}">FAQ</a></li>
                    <li><a href="{{ url('/terms-and-conditions') }}">Terms & Conditions</a></li>
                    <li><a href="{{ url('/privacy-policy') }}">Privacy Policy</a></li>
                  </ul>
                </li>
                <li>
                  <a href="{{ url('/contact') }}">Contact</a>
                </li>
              </ul>
              {{-- *** END: Main Desktop Menu Items from header.blade.php *** --}}
            </nav>
            <div class="header-wc style2"> {{-- Kept style2 class --}}
              <button class="wc-link2 searchBoxTggler">
                {{-- Kept header2 Search Icon --}}
                <svg xmlns="http://www.w3.org/2000/svg" width="21" height="20" viewBox="0 0 21 20" fill="none"
                  class="text-title-color" aria-hidden="true"> {{-- Kept text-title-color class --}}
                  <path
                    d="M20.4174 16.6954L17.2213 13.4773C19.3155 10.0703 18.8936 5.54217 15.9593 2.58766C12.5328 -0.862552 6.9769 -0.862552 3.55037 2.58766C0.123835 6.03787 0.123835 11.6322 3.55037 15.0824C6.5354 18.088 11.1341 18.4736 14.5333 16.2469L17.7019 19.4335C18.4521 20.1888 19.6711 20.1888 20.4213 19.4335C21.1675 18.6781 21.1675 17.4507 20.4174 16.6954ZM5.711 12.9029C3.48395 10.6604 3.48395 7.00959 5.711 4.76715C7.93805 2.52471 11.5638 2.52471 13.7909 4.76715C16.018 7.00959 16.018 10.6604 13.7909 12.9029C11.5638 15.1453 7.93805 15.1453 5.711 12.9029Z"
                    fill="currentColor" />
                </svg>
              </button>
              {{-- Kept header2 Divider SVG --}}
              <svg xmlns="http://www.w3.org/2000/svg" width="6" height="39" viewBox="0 0 6 39" fill="none"
                aria-hidden="true">
                <rect x="5" width="1" height="39" fill="#9A9696" fill-opacity="0.7" />
                <rect y="9" width="1" height="20" fill="#9A9696" fill-opacity="0.7" />
              </svg>
              {{-- Use 'let's plan' link from header1, keep button style from header2 (style8) --}}
              <a href="{{ url('/contact') }}#plan" class="vs-btn style8"> {{-- Kept style8, updated link --}}
                <span>let’s plan</span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>
<!--================= Header Area end =================-->

{{-- Reminder: Tags like <main> and the Preloader usually belong in your main layout file (e.g., layouts/app.blade.php)
  --}}