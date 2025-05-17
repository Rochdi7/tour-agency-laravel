{{-- resources/views/partials/footer.blade.php --}}

<!-- ================= Footer Start ================= -->
<footer class="vs-footer-style1" data-bg-src="{{ asset('assets/img/footer/footer-style1-bg.png') }}">
    <div class="footer-top space-top">
        <div class="container">
            <div class="row gx-4">
                <div class="col-12">
                    <div class="footer-cta bg-third-theme-color fade-anim"
                        data-bg-src="{{ asset('assets/img/footer/footer-cta-bg.png') }}">
                        <div class="row g-4 align-items-center">
                            <div class="col-lg-8">
                                <div class="cta-contact-items">
                                    <div class="contact-item">
                                        <span class="icon">
                                            <i class="fa-light fa-location-dot"></i>
                                        </span>
                                        <div class="info">
                                            <h5 class="info-title text-white-color">Location</h5>
                                            <p>Khalid Ibn Al Walid Street, Gueliz, Marrakech, 40000, Morocco</p>
                                        </div>
                                    </div>
                                    <div class="contact-item">
                                        <span class="icon">
                                            <i class="fa-sharp fa-light fa-phone-rotary"></i>
                                        </span>
                                        <div class="info">
                                            <h5 class="info-title text-white-color">Contact Us</h5>
                                            <p>
                                                <a href="mailto:contact@morocco-quest.com"
                                                    aria-label="Email Morocco Quest at contact@morocco-quest.com">contact@morocco-quest.com</a>
                                                <a href="tel:+212654069718"
                                                    aria-label="Call Morocco Quest at +212654069718">+212654069718</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="col-lg-4 d-flex justify-content-center justify-content-lg-end btn-trigger btn-bounce">
                                {{-- Link to contact page fragment (or just # if contact page isn't ready) --}}
                                <a href="{{ url('/contact') ?? '#' }}#booking" class="vs-btn style6">
                                    <span>Book Your Tour Now</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-center space-extra">
        <div class="container">
            <div class="row gx-4 gy-4 gx-xl-2 justify-content-between">
                <div class="col-md-6 col-lg-4 col-xl-4">
                    <div class="footer-widgets">
                        <a href="{{ url('/') }}" class="logo">
                            <img src="{{ asset('assets/img/logo-bg-wide-white.webp') }}"
                                alt="Morocco Quest Homepage Logo" style="width: auto; height: 120px;" />
                        </a>
                        <div class="social-media">
                            <ul class="custom-ul">
                                {{-- Keep external social links --}}
                                <li> <a href="https://www.facebook.com/p/Colored-Morocco-100070928444096/p/Colored-Morocco-100070928444096/"
                                        target="_blank" rel="noopener noreferrer"
                                        aria-label="Follow Morocco Quest on Facebook"><i
                                            class="fa-brands fa-facebook-f"></i></a> </li>
                                <li> <a href="https://x.com/mounirakajiamounirakajia" target="_blank"
                                        rel="noopener noreferrer" aria-label="Follow Morocco Quest on X (Twitter)"><i
                                            class="fa-brands fa-x-twitter"></i></a> </li>
                                <li> <a href="https://www.instagram.com/colored.morocco/" target="_blank"
                                        rel="noopener noreferrer" aria-label="Follow Morocco Quest on Instagram"><i
                                            class="fa-brands fa-instagram"></i></a> </li>
                                <li> <a href="https://www.youtube.com/@coloredmoroccotourstravel6209" target="_blank"
                                        rel="noopener noreferrer" aria-label="Follow Morocco Quest on YouTube"><i
                                            class="fa-brands fa-youtube"></i></a> </li>
                            </ul>
                        </div>

                        <p class="mt-4 mb-3 text-color-5">
                            Stay connected for future updates & offers.
                        </p>
                        <div class="newsletter">
                            <!-- Newsletter Subscription Form -->
                            <form action="{{ route('newsletter.subscribe') }}" method="POST" class="w100">
                                @csrf
                                <input type="email" name="email" class="form-control" placeholder="Enter Email Address"
                                    required aria-label="Newsletter Email Input" />
                                <button type="submit" class="text-uppercase text-color-5"
                                    aria-label="Subscribe to Newsletter">
                                    <i class="fa-solid fa-angles-right"></i>
                                    <span>Subscribe now</span>
                                </button>
                            </form>
                        </div>

                        <!-- Toastify CSS -->
                        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

                        <!-- Toastify JS -->
                        <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

                        <script>
                            // Success Message
                            @if(session('success'))
                                Toastify({
                                    text: "{{ session('success') }}",
                                    duration: 4000,
                                    gravity: "top",
                                    position: "right",
                                    backgroundColor: "#4caf50",  // Green for success
                                    stopOnFocus: true,
                                }).showToast();
                            @endif

                            // Error Message
                            @if($errors->any())
                                Toastify({
                                    text: "{{ $errors->first() }}",
                                    duration: 4000,
                                    gravity: "top",
                                    position: "right",
                                    backgroundColor: "#f44336",  // Red for errors
                                    stopOnFocus: true,
                                }).showToast();
                            @endif
                        </script>


                    </div>
                </div>
                <div class="col-lg-5 col-xl-4 order-md-3 order-lg-2">
                    <div class="footer-widgets">
                        <h5 class="widgets-title text-white-color text-capitalize">
                            Useful Links
                        </h5>
                        <div class="row gx-xl-2 g-2">
                            <div class="col-md-6">
                                <div class="footer-links">
                                    <ul class="custom-ul">
                                        <li>
                                            <a href="https://www.acces-maroc.ma" target="_blank">
                                                <i class="fa-solid fa-angles-right"></i> Morocco e-Visa
                                            </a>
                                        </li>
                                        <li> <a href="https://visaguide.world/africa/morocco-visa/" target="_blank">
                                                <i class="fa-solid fa-angles-right"></i> Visa Requirements
                                            </a></li>
                                        <li> <a href="https://www.xe.com/currencyconverter/" target="_blank">
                                                <i class="fa-solid fa-angles-right"></i> Currency Converter
                                            </a></li>
                                        <li> <a href="https://www.accuweather.com/en/ma/morocco-weather"
                                                target="_blank">
                                                <i class="fa-solid fa-angles-right"></i> Weather Forecast
                                            </a></li>
                                        <li> <a href="https://www.thebrokebackpacker.com/what-to-pack-for-morocco/"
                                                target="_blank">
                                                <i class="fa-solid fa-angles-right"></i> Packing Guide
                                            </a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="footer-links">
                                    <ul class="custom-ul">
                                        <li> <a href="https://www.travelinsurance.com/" target="_blank">
                                                <i class="fa-solid fa-angles-right"></i> Travel Insurance
                                            </a></li>
                                        <li> <a href="https://www.iatatravelcentre.com/world.php" target="_blank">
                                                <i class="fa-solid fa-angles-right"></i> COVID-19 Info
                                            </a></li>
                                        <li> <a href="https://www.who.int/countries/mar/" target="_blank">
                                                <i class="fa-solid fa-angles-right"></i> Travel Health
                                            </a></li>
                                        <li> <a href="https://www.intrepidtravel.com/adventures/morocco-travel-tips/"
                                                target="_blank">
                                                <i class="fa-solid fa-angles-right"></i> Travel Tips
                                            </a></li>
                                        <li> <a href="https://www.power-plugs-sockets.com/morocco/" target="_blank">
                                                <i class="fa-solid fa-angles-right"></i> Electrical Plugs
                                            </a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-6 col-lg-3 col-xl-3 order-md-2 order-lg-3">
                    <div class="footer-widgets">
                        <h5 class="widgets-title text-white-color text-capitalize">
                            Instagram Feed
                        </h5>
                        <div class="instagram">
                            {{-- Instagram links redirecting to the profile --}}
                            <a href="https://www.instagram.com/colored.morocco/" target="_blank"
                                rel="noopener noreferrer" aria-label="View Morocco Desert Camp" class="instagram-post">
                                <img src="{{ asset('assets/img/Desert-Camp-Morocco-Sunset-View-Lanterns-Palm-Trees.webp') }}"
                                    alt="Desert Camp Morocco Sunset View Lanterns Palm Trees" class="w-100 instagram-1"
                                    loading="lazy" />
                            </a>

                            <a href="https://www.instagram.com/colored.morocco/" target="_blank"
                                rel="noopener noreferrer" aria-label="View Luxury Dinner Setup Morocco"
                                class="instagram-post">
                                <img src="{{ asset('assets/img/Luxury-Dinner-Setup-Wedding-Morocco-Outdoor-Event.webp') }}"
                                    alt="Luxury Dinner Setup Wedding Morocco Outdoor Event" class="w-100 instagram-2"
                                    loading="lazy" />
                            </a>

                            <a href="https://www.instagram.com/colored.morocco/" target="_blank"
                                rel="noopener noreferrer" aria-label="View Moroccan Gate Fes Tourists"
                                class="instagram-post">
                                <img src="{{ asset('assets/img/Moroccan-Gate-Fes-Tourists-Decorative-Architecture.webp') }}"
                                    alt="Moroccan Gate Fes Tourists Decorative Architecture" class="w-100 instagram-3"
                                    loading="lazy" />
                            </a>

                            <a href="https://www.instagram.com/colored.morocco/" target="_blank"
                                rel="noopener noreferrer" aria-label="View Moroccan Palace Restaurant"
                                class="instagram-post">
                                <img src="{{ asset('assets/img/Moroccan-Palace-Restaurant-Elegant-Dining-Setup.webp') }}"
                                    alt="Moroccan Palace Restaurant Elegant Dining Setup" class="w-100 instagram-4"
                                    loading="lazy" />
                            </a>

                            <a href="https://www.instagram.com/colored.morocco/" target="_blank"
                                rel="noopener noreferrer" aria-label="View Moroccan Riad Pool Night View"
                                class="instagram-post">
                                <img src="{{ asset('assets/img/Moroccan-Riad-Pool-Night-View-Arch-Design.webp') }}"
                                    alt="Moroccan Riad Pool Night View Arch Design" class="w-100 instagram-5"
                                    loading="lazy" />
                            </a>

                            <a href="https://www.instagram.com/colored.morocco/" target="_blank"
                                rel="noopener noreferrer" aria-label="View Traditional Moroccan Dining Event"
                                class="instagram-post">
                                <img src="{{ asset('assets/img/Traditional-Moroccan-Dining-Event-Outdoor-Lanterns.webp') }}"
                                    alt="Traditional Moroccan Dining Event Outdoor Lanterns" class="w-100 instagram-6"
                                    loading="lazy" />
                            </a>
                        </div>
                    </div>
                    <style>
                        .instagram a::before {
                            position: absolute;
                            content: "";
                            left: 5px;
                            top: 5px;
                            right: 5px;
                            bottom: 5px;
                            opacity: 0;
                            border-radius: 10px;
                            background: rgba(12, 66, 73, 0.4);
                            /* Color #0c4249 with transparency */
                            z-index: 2;
                            transition: all 0.3s;
                        }

                        .instagram a:hover::before {
                            opacity: 1;
                        }
                    </style>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom bg-third-theme-color">
        <div class="container">
            <div class="row">
                <div class="col-md-6 order-2 order-md-1">
                    <p class="footer-copyright text-center text-md-start">
                        Copyright © {{ date('Y') }}
                        <a href="{{ url('/') }}" class="text-theme-color">Morocco Quest</a>.
                        All Rights Reserved.
                        <br />
                        Developed by
                        <a href="https://www.facebook.com/CodeSommet/" target="_blank"
                            class="text-theme-color">
                            Code Sommet
                        </a>
                    </p>
                </div>
                <div class="col-md-6 order-1 order-md-2">
                    <div class="footer-menu">
                        <ul class="custom-ul justify-content-center justify-content-md-end">
                            <li><a href="{{ route('privacy.policy') }}">Privacy Policy</a></li>
                            <li><a href="{{ route('terms.conditions') }}">Terms</a></li>
                            <li><a href="{{ route('cookie.policy') }}">Cookie Policy</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

</footer>
<!-- ================= Footer End ================= -->

<!-- Scroll To Top Button -->
<a href="#" class="scrollToTop scroll-btn" aria-label="Scroll back to top of page"><i class="far fa-arrow-up"></i></a>