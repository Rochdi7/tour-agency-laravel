@extends('layouts.app2')
@section('content')
    <main>
        <!-- Hero Section -->
        <section class="vs-breadcrumb" data-bg-src="{{ asset('assets/img/moroccan-traditional-dinner-event.webp') }}">
            <img src="{{ asset('assets/img/icons/cloud.png') }}" alt="Decorative cloud icon"
                class="vs-breadcrumb-icon-1 animate-parachute" loading="lazy" />
            <img src="{{ asset('assets/img/icons/ballon-sclation.png') }}" alt="Decorative hot air balloon icon"
                class="vs-breadcrumb-icon-2 animate-parachute" loading="lazy" />
            <div class="container">
                <div class="row text-center">
                    <div class="col-12">
                        <div class="breadcrumb-content">
                            <h1 class="breadcrumb-title">Our Cookie Policy</h1>
                            <figcaption class="image-caption" style="color: white; font-size: medium; ">
                                Learn how we use cookies to improve your experience and ensure better services.
                            </figcaption>

                            <p class="visually-hidden">
                                This image represents a traditional Moroccan dinner event in a beautifully decorated outdoor
                                setting with lanterns and cultural ambiance. Our Cookie Policy explains how we use cookies
                                to improve your navigation experience and ensure better service delivery.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Cookie Policy Section -->
        <section class="terms-conditions">
            <div class="container my-5">
                <div class="row">
                    <div class="text-center">
                        <h2>COOCKIE POLICY</h2>
                        <p style="text-align: center;">
                            In our cookie policy, we explain the nature and types of cookies as well as how we use them and
                            how you can control them from your side.
                        </p>
                    </div>
                    <div class="col-12" style="margin-top: 20px;">


                        <h2>What are cookies and why do we use them?</h2>
                        <p>
                            A cookie is a small text (a code) that our site will send to your device (PC, tablet,
                            smartphone…etc.) while you are browsing it and your internet browser will store this code for
                            later use. This cookie helps us know your preferences when navigating our site and enables the
                            website to recognize your browser to ensure you have a better browsing experience.
                            
                            Nowadays, cookies are widely used to manage websites and make them work properly and
                            efficiently. Please rest assured that a cookie will not give us access to your computer or any
                            of your personal information. We use cookies for analytical and marketing purposes as well.
                        
                        </p>
                        <h2 style="margin-top: 20px;">What cookies do we use?</h2>
                        <p>
                            Like the majority of websites, we use cookies set by trusted third parties we work with (such as
                            Google and Facebook). Please note that all third-party cookies on our website are subject to the
                            cookie policies of these third parties respectively. For more information about these cookies,
                            please refer to the cookie policy pages of these third parties:
                        </p>
                        <ul style="margin-top: 6px; list-style-type: disc; padding-left: 20px;">
                            <li class="cookie-list"><a href="https://policies.google.com/technologies/cookies" target="_blank">Google Cookie
                                    Policy</a></li>
                            <li class="cookie-list"><a href="https://www.facebook.com/policies/cookies/" target="_blank">Facebook Cookie
                                    Policy</a></li>
                        </ul>


                        <p>We mainly use four types of cookies on our website:</p>

                        <h6>Necessary Cookies</h6>
                        <p>
                            A set of essential cookies that we need to ensure our website functions properly on your device.
                            Some of these cookies will be deleted when you finish browsing our website. You can also set
                            your internet navigator to block these cookies or to inform you before using them.
                        </p>

                        <h6>Performance Cookies</h6>
                        <p>
                            A set of cookies that help us collect statistical information such as how many people visit our
                            website, what pages they are looking at, and how much time they spend on a given page. These
                            statistics help us improve our website's performance continuously. As an example, we use Google
                            Analytics to track visitors’ movements on our website.
                        </p>

                        <h6>Functional Cookies</h6>
                        <p>
                            A set of cookies that help you to better use some functions on our website and to optimize your
                            browsing experience. They are used with functionalities like live chat, Web Whatsapp, etc.
                        </p>

                        <h6>Marketing Cookies</h6>
                        <p>
                            A set of cookies used by Google Ads and Facebook to display some of our relevant marketing
                            campaigns based on your browsing preferences. These cookies help identify your real needs and
                            propose the best and adequate tours for you.
                        </p>

                        <h6>How can you control cookies?</h6>
                        <p>
                            You are free to accept or decline the use of our cookies on your device. You can totally block
                            them by setting your internet browser to do so. You can always browse our website even if you
                            block the cookies.
                        </p>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <style>
        h2 {
            font-size: 30px;
        }
        .cookie-list {
            color: #bb5e2a;
            text-decoration: underline;
        }

        h6 {
            margin-top: 15px;
            margin-bottom: 6px;
        }
        p{
            text-align: justify;
        }
    </style>
@endsection