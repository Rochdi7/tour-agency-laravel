{{-- resources/views/partials/footer.blade.php --}}

<!-- ================= Footer Start ================= -->
<footer
    class="vs-footer-style1"
    data-bg-src="{{ asset('assets/img/footer/footer-style1-bg.png') }}"
>
    <div class="footer-top space-top">
        <div class="container">
            <div class="row gx-4">
                <div class="col-12">
                    <div
                        class="footer-cta bg-third-theme-color fade-anim"
                        data-bg-src="{{ asset('assets/img/footer/footer-cta-bg.png') }}"
                    >
                        <div class="row g-4 align-items-center">
                            <div class="col-lg-8">
                                <div class="cta-contact-items">
                                    <div class="contact-item">
                                        <span class="icon">
                                            <i class="fa-light fa-location-dot"></i>
                                        </span>
                                        <div class="info">
                                            <h5 class="info-title text-white-color">Location</h5>
                                            <p>Your Morocco Quest Address, City, Postal Code, Country</p>
                                        </div>
                                    </div>
                                    <div class="contact-item">
                                        <span class="icon">
                                            <i class="fa-sharp fa-light fa-phone-rotary"></i>
                                        </span>
                                        <div class="info">
                                            <h5 class="info-title text-white-color">Contact Us</h5>
                                            <p>
                                                <a href="mailto:contact@morocco-quest.com" aria-label="Email Morocco Quest at contact@morocco-quest.com">contact@morocco-quest.com</a>
                                                <a href="tel:+212654069718" aria-label="Call Morocco Quest at +212654069718">+212654069718</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 d-flex justify-content-center justify-content-lg-end btn-trigger btn-bounce">
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
                            <img src="{{ asset('assets/img/logo-bg.png') }}" alt="Morocco Quest Homepage Logo" />
                        </a>
                        <div class="social-media">
                            <ul class="custom-ul">
                                {{-- Keep external social links --}}
                                <li> <a href="https://www.facebook.com/YourFacebookPage" target="_blank" rel="noopener noreferrer" aria-label="Follow Morocco Quest on Facebook"><i class="fa-brands fa-facebook-f"></i></a> </li>
                                <li> <a href="https://x.com/YourTwitterHandle" target="_blank" rel="noopener noreferrer" aria-label="Follow Morocco Quest on X (Twitter)"><i class="fa-brands fa-x-twitter"></i></a> </li>
                                <li> <a href="https://www.instagram.com/YourInstagramHandle" target="_blank" rel="noopener noreferrer" aria-label="Follow Morocco Quest on Instagram"><i class="fa-brands fa-instagram"></i></a> </li>
                                <li> <a href="https://www.youtube.com/YourYoutubeChannel" target="_blank" rel="noopener noreferrer" aria-label="Follow Morocco Quest on YouTube"><i class="fa-brands fa-youtube"></i></a> </li>
                            </ul>
                        </div>

                        <p class="mt-4 mb-3 text-color-5">
                            Stay connected for future updates & offers.
                        </p>
                        <div class="newsletter">
                             {{-- Keep newsletter form action pointing to route, or change to '#' if route not ready --}}
                            <form action="#" method="POST" class="w100">
                                @csrf
                                <input
                                    type="email"
                                    name="email"
                                    class="form-control"
                                    placeholder="Enter Email Address"
                                    required
                                    aria-label="Newsletter Email Input"
                                />
                                <button type="submit" class="text-uppercase text-color-5" aria-label="Subscribe to Newsletter">
                                    <i class="fa-solid fa-angles-right"></i>
                                    <span>Subscribe now</span>
                                </button>
                            </form>
                        </div>
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
                                         {{-- Reverted internal links to # --}}
                                        <li> <a href="#"> <i class="fa-solid fa-angles-right"></i> Help Center </a> </li>
                                        <li> <a href="#"> <i class="fa-solid fa-angles-right"></i> About Us </a> </li>
                                        <li> <a href="#"> <i class="fa-solid fa-angles-right"></i> Contact Us </a> </li>
                                        <li> <a href="#"> <i class="fa-solid fa-angles-right"></i> Become A Guide </a> </li>
                                        <li> <a href="#"> <i class="fa-solid fa-angles-right"></i> Blog </a> </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="footer-links">
                                    <ul class="custom-ul">
                                        {{-- Reverted internal links to # --}}
                                        <li> <a href="#"> <i class="fa-solid fa-angles-right"></i> Guide of the Year </a> </li>
                                        <li> <a href="#"> <i class="fa-solid fa-angles-right"></i> Guide Registration </a> </li>
                                        <li> <a href="#"> <i class="fa-solid fa-angles-right"></i> Creators / Affiliates </a> </li>
                                        <li> <a href="#"> <i class="fa-solid fa-angles-right"></i> Travel Agents </a> </li>
                                        <li> <a href="#"> <i class="fa-solid fa-angles-right"></i> FAQ </a> </li>
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
                             {{-- Keep external Instagram links --}}
                            <a href="https://www.instagram.com/YourInstagramHandle" target="_blank" rel="noopener noreferrer" aria-label="View Instagram Post 1"> <img src="{{ asset('assets/img/instagram-post/instagram-1.png') }}" alt="Morocco Quest Instagram Post 1" class="w-100" loading="lazy"/> </a>
                            <a href="https://www.instagram.com/YourInstagramHandle" target="_blank" rel="noopener noreferrer" aria-label="View Instagram Post 2"> <img src="{{ asset('assets/img/instagram-post/instagram-2.png') }}" alt="Morocco Quest Instagram Post 2" class="w-100" loading="lazy"/> </a>
                            <a href="https://www.instagram.com/YourInstagramHandle" target="_blank" rel="noopener noreferrer" aria-label="View Instagram Post 3"> <img src="{{ asset('assets/img/instagram-post/instagram-3.png') }}" alt="Morocco Quest Instagram Post 3" class="w-100" loading="lazy"/> </a>
                            <a href="https://www.instagram.com/YourInstagramHandle" target="_blank" rel="noopener noreferrer" aria-label="View Instagram Post 4"> <img src="{{ asset('assets/img/instagram-post/instagram-4.png') }}" alt="Morocco Quest Instagram Post 4" class="w-100" loading="lazy"/> </a>
                            <a href="https://www.instagram.com/YourInstagramHandle" target="_blank" rel="noopener noreferrer" aria-label="View Instagram Post 5"> <img src="{{ asset('assets/img/instagram-post/instagram-5.png') }}" alt="Morocco Quest Instagram Post 5" class="w-100" loading="lazy"/> </a>
                            <a href="https://www.instagram.com/YourInstagramHandle" target="_blank" rel="noopener noreferrer" aria-label="View Instagram Post 6"> <img src="{{ asset('assets/img/instagram-post/instagram-6.png') }}" alt="Morocco Quest Instagram Post 6" class="w-100" loading="lazy"/> </a>
                        </div>
                    </div>
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
                    </p>
                </div>
                <div class="col-md-6 order-1 order-md-2">
                    <div class="footer-menu">
                        <ul class="custom-ul justify-content-center justify-content-md-end">
                             {{-- Reverted internal links to # --}}
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Terms</a></li>
                            <li><a href="#">FAQ</a></li>
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