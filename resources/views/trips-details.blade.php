@extends('layouts.app2')

@section('title', $trip->title ?? 'Trip Details')

@section('content')
    <section class="vs-breadcrumb" data-bg-src="{{ asset('assets/img/bg/breadcrumb-bg.png') }}">
        <img src="{{ asset('assets/img/icons/cloud.png') }}" alt="vs-breadcrumb-icon"
            class="vs-breadcrumb-icon-1 animate-parachute" />
        <img src="{{ asset('assets/img/icons/ballon-sclation.png') }}" alt="vs-breadcrumb-icon"
            class="vs-breadcrumb-icon-2 animate-parachute" />
        <div class="container">
            <div class="row text-center">
                <div class="col-12">
                    <div class="breadcrumb-content">
                        <h1 class="breadcrumb-title">{{ $trip->title ?? 'Trip Details' }}</h1>
                    </div>
                    <div class="breadcrumb-menu">
                        <ul class="custom-ul">
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li>Trip details</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="vs-destination-details space bg-theme-07">
        <div class="container">
            <div class="row gx-3 gx-xl-5 gy-5">
                <div class="col-lg-8">
                    <div class="vs-destination-single">
                        <div class="row align-items-center gy-3 mb-4">
                            <div class="col-8 col-sm-10">
                                <h2 class="destination-single-title">
                                    {{ $trip->title ?? 'Trip Title' }}
                                </h2>
                            </div>
                            <div class="col-4 col-sm-2 d-flex justify-content-end">
                                @if($trip->duration_days)
                                    <div class="destination-single-meta">
                                        <h3>{{ $trip->duration_days }}</h3>
                                        <span>{{ Str::plural('day', $trip->duration_days) }}</span>
                                    </div>
                                @elseif($trip->duration)
                                    <div class="destination-single-meta">
                                        <h3>{{ preg_replace('/[^0-9]/', '', $trip->duration) ?: '?' }}</h3>
                                        <span>{{ trim(preg_replace('/[0-9]+/', '', $trip->duration)) ?: 'days' }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="destination-single-info">
                            <figure class="destination-single-img d-block">
                                @if($trip->images && $trip->images->isNotEmpty())
                                    @php $image = $trip->images->first(); @endphp
                                    <img src="{{ asset('storage/' . $image->image_path) }}"
                                         alt="{{ $image->caption ?? 'Trip Image' }}" />
                                @endif
                            </figure>
                            <div class="destination-single-px">
                                <div class="destination-info-tabs">
                                    <ul class="custom-ul">
                                        <li class="current"><a href="#current">Overview</a></li>
                                        <li class=""><a href="#itinerary">Itinerary</a></li>
                                        <li class=""><a href="#cost">Cost</a></li>
                                        <li class=""><a href="#faq">FAQs</a></li>
                                        <li class=""><a href="#map">Map</a></li>
                                        <li class=""><a href="#review">Send Request</a></li>
                                    </ul>
                                </div>
                                <div id="current" class="destination-overview tab-content">
                                    <h4 class="title">Overview</h4>
                                    @if($trip->overview)
                                        {!! $trip->overview !!}
                                    @else
                                        <p>Details about the trip overview will be provided here.</p>
                                    @endif
                                </div>
                                <div id="itinerary" class="destination-ltinerary tab-content">
                                    <div class="d-flex justify-content-between align-items-center gap-2">
                                        <h4 class="title">Itinerary</h4>
                                        <a href="#" class="expand-btn">Expand all</a>
                                    </div>
                                    @if(isset($trip->itineraryDays) && $trip->itineraryDays->count() > 0)
                                        <div class="d-flex gap-2 gap-xl-4 mt-3">
                                            <div class="progress-area">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="37" height="37"
                                                    viewBox="0 0 37 37" fill="none">
                                                    <circle cx="18.5" cy="18.5" r="18.5" fill="#F7921E" />
                                                    <path
                                                        d="M23.4463 11.5947C22.6394 10.934 21.6959 10.4606 20.6839 10.2087C19.6719 9.95679 18.6167 9.93261 17.5942 10.1379C16.2795 10.4074 15.07 11.0492 14.1098 11.9867C13.1496 12.9243 12.4791 14.1181 12.1782 15.4259C11.8773 16.7338 11.9587 18.1006 12.4127 19.3635C12.8667 20.6264 13.6742 21.7322 14.7389 22.5491C15.9546 23.4388 16.9896 24.552 17.7886 25.829L18.3331 26.7344C18.4022 26.8494 18.5 26.9445 18.6168 27.0106C18.7336 27.0766 18.8655 27.1114 18.9997 27.1114C19.1338 27.1114 19.2658 27.0766 19.3826 27.0106C19.4994 26.9445 19.5971 26.8494 19.6662 26.7344L20.1881 25.8648C20.8839 24.6416 21.8327 23.581 22.9711 22.7536C23.8637 22.1395 24.6013 21.3264 25.1259 20.3784C25.6504 19.4304 25.9475 18.3734 25.9937 17.291C26.0398 16.2085 25.8338 15.1301 25.3918 14.1409C24.9499 13.1517 24.2841 12.2787 23.4471 11.5908L23.4463 11.5947ZM18.9989 20.1123C18.3836 20.1123 17.782 19.9298 17.2704 19.5879C16.7588 19.2461 16.36 18.7602 16.1245 18.1917C15.8891 17.6232 15.8275 16.9977 15.9475 16.3942C16.0675 15.7907 16.3639 15.2363 16.799 14.8012C17.2341 14.3661 17.7884 14.0698 18.3919 13.9497C18.9954 13.8297 19.621 13.8913 20.1895 14.1268C20.758 14.3623 21.2439 14.761 21.5857 15.2726C21.9276 15.7843 22.11 16.3858 22.11 17.0011C22.11 17.8262 21.7823 18.6176 21.1988 19.201C20.6153 19.7845 19.824 20.1123 18.9989 20.1123Z"
                                                        fill="white" />
                                                </svg>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="37" height="37"
                                                    viewBox="0 0 37 37" fill="none">
                                                    <circle cx="18.5" cy="18.5" r="18.5" fill="#F7921E" />
                                                    <path
                                                        d="M28.7986 16.489C28.611 16.3202 28.3423 16.2765 28.1173 16.3827C26.936 16.9202 26.2734 16.314 25.1984 15.1952C24.3796 14.3389 23.392 13.3138 21.967 13.4388C21.917 13.2576 21.7794 13.1076 21.5857 13.0388C21.2607 12.92 20.9044 13.0826 20.7856 13.4076L20.5356 14.0951L19.0012 18.3107L17.4667 14.0951L17.2167 13.4076C17.0979 13.0826 16.7354 12.92 16.4167 13.0388C16.2229 13.1076 16.0916 13.2576 16.0354 13.4388C14.6103 13.3076 13.6228 14.3389 12.7977 15.1952C11.7289 16.314 11.0664 16.9202 9.88507 16.3827C9.65381 16.2765 9.38505 16.3202 9.19751 16.489C9.01627 16.664 8.95378 16.9265 9.03504 17.164L10.7664 21.9205C10.8226 22.0768 10.9414 22.2018 11.0976 22.2706C11.5851 22.4956 12.0289 22.5893 12.4352 22.5893C13.729 22.5893 14.6541 21.6268 15.4354 20.8142C16.4354 19.7766 17.073 19.1766 18.1167 19.5391L18.3364 20.1435L16.7479 24.5081C16.6292 24.8332 16.7917 25.1894 17.1167 25.3082C17.4799 25.4292 17.8146 25.2311 17.9167 24.9394L18.9998 21.9688L20.0794 24.9394C20.2014 25.2649 20.562 25.4236 20.8794 25.3082C21.2044 25.1894 21.3732 24.8332 21.2544 24.5081L19.6662 20.1407L19.8856 19.5391C20.9294 19.1829 21.5732 19.7766 22.567 20.8142C23.342 21.6268 24.2671 22.5893 25.5671 22.5893C25.9734 22.5893 26.4172 22.4956 26.9047 22.2706C27.0547 22.2018 27.1735 22.0768 27.2297 21.9205L28.9611 17.164C29.0486 16.9265 28.9861 16.664 28.7986 16.489Z"
                                                        fill="white" />
                                                </svg>
                                            </div>
                                            <div class="accordion-style2 accordion flex-grow-1"
                                                id="tripItineraryAccordion">
                                                @foreach($trip->itineraryDays as $day)
                                                    <div class="accordion-item">
                                                        <h6 class="accordion-header">
                                                            <button
                                                                class="accordion-button {{ $loop->first ? '' : 'collapsed' }}"
                                                                type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#collapseItinDay{{ $day->id }}"
                                                                aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                                                                aria-controls="collapseItinDay{{ $day->id }}">
                                                                Day {{ sprintf('%02d', $day->day_number) }} :
                                                                {{ $day->title ?? 'Itinerary Details' }}
                                                            </button>
                                                        </h6>
                                                        <div id="collapseItinDay{{ $day->id }}"
                                                            class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                                                            data-bs-parent="#tripItineraryAccordion">
                                                            <div class="accordion-body">
                                                                {!! $day->description !!}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @else
                                        <p class="mt-3">The detailed day-by-day itinerary is not available for this trip
                                            yet.</p>
                                    @endif
                                </div>
                                <div id="cost" class="destination-cost tab-content">
                                    <h4 class="title">Cost</h4>
                                    <div class="includes">
                                        <h5 class="sub-title">The Cost Includes</h5>
                                        @if(is_string($trip->includes) && !empty(trim($trip->includes)))
                                        @php
                                            $includeItems = array_filter(array_map('trim', explode("\n", $trip->includes)));
                                        @endphp
                                            <ul class="custom-ul">
                                                @foreach($includeItems as $item)
                                                    <li>
                                                        <i class="fa-solid fa-circle-check text-success me-2"></i>
                                                        {{ $item }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p>Details about what the cost includes are not available yet.</p>
                                        @endif
                                    </div>
                                    <div class="excludes mt-4">
                                        <h5 class="sub-title">The Cost Excludes</h5>
                                        @if(is_string($trip->excludes) && !empty(trim($trip->excludes)))
                                        @php
                                            $excludeItems = array_filter(array_map('trim', explode("\n", $trip->excludes)));
                                        @endphp
                                            <ul class="custom-ul">
                                                @foreach($excludeItems as $item)
                                                    <li>
                                                        <i class="fa-solid fa-circle-xmark text-danger me-2"></i>
                                                        {{ $item }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <p>Details about what the cost excludes are not available yet.</p>
                                        @endif
                                    </div>
                                </div>
                                <div id="faq" class="destination-faq tab-content">
                                    <div class="d-flex justify-content-between align-items-center gap-2">
                                        <h4 class="title">FAQs</h4>
                                        <a href="./faq.html" class="expand-btn">Expand all</a>
                                    </div>
                                    <div class="accordion-style2 accordion" id="accordionExampleTwo">
                                        <div class="accordion-item">
                                            <h6 class="accordion-header">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                How fit do I need to be to do this trek?
                                                </button>
                                            </h6>
                                            <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExampleTwo">
                                                <div class="accordion-body">
                                                Travel is movement of people between relatively distant geograp location, andca involve travels byfo, bicycle, autmobile, train, boat, bus, airplane, or other means, without luggage, and can be one way or round trip. Travel can also include successive.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h6 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                How long do we walk every day when doing Annapurna Base Camp trekking?
                                                </button>
                                            </h6>
                                            <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExampleTwo">
                                                <div class="accordion-body">
                                                Travel is movement of people between relatively distant geograp location, andca involve travels byfo, bicycle, autmobile, train, boat, bus, airplane, or other means, without luggage, and can be one way or round trip. Travel can also include successive.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h6 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                What about battery charging and hot shower facilities?
                                                </button>
                                            </h6>
                                            <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExampleTwo">
                                                <div class="accordion-body">
                                                Travel is movement of people between relatively distant geograp location, andca involve travels byfo, bicycle, autmobile, train, boat, bus, airplane, or other means, without luggage, and can be one way or round trip. Travel can also include successive.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h6 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                                Are there ATMs on the way to Annapurna Base Camp?
                                                </button>
                                            </h6>
                                            <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionExampleTwo">
                                                <div class="accordion-body">
                                                Travel is movement of people between relatively distant geograp location, andca involve travels byfo, bicycle, autmobile, train, boat, bus, airplane, or other means, without luggage, and can be one way or round trip. Travel can also include successive.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h6 class="accordion-header">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                                What about internet access?
                                                </button>
                                            </h6>
                                            <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#accordionExampleTwo">
                                                <div class="accordion-body">
                                                Travel is movement of people between relatively distant geograp location, andca involve travels byfo, bicycle, autmobile, train, boat, bus, airplane, or other means, without luggage, and can be one way or round trip. Travel can also include successive.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="map" class="destination-map tab-content">
                                    <h4 class="title">Trip Map</h4>
                                    @if($trip->map_embed_code)
                                        {!! $trip->map_embed_code !!}
                                    @else
                                        <p>Map data is currently unavailable for this trip.</p>
                                    @endif
                                </div>
                                <div id="review" class="destination-request tab-content">
                                    <h4 class="title">Send Request</h4>
                                    <h5 class="sub-title"> You can send your enquiry via the form below. </h5>
                                    <p class="short-info">Regarding Trip:
                                        <strong>{{ $trip->title ?? 'Selected Trip' }}</strong>
                                    </p>
                                    <div class="row">
                                        <div class="col-12">
                                            <form action="{{ route('trip.inquiry', $trip->slug) }}" method="post" class="form-style2">
                                                @csrf
                                                <input type="hidden" name="trip_title" value="{{ $trip->title ?? 'N/A' }}">
                                                <div class="row">
                                                    <div class="col-12 form-group">
                                                        <label for="inquiry_name">Your Name <span>*</span></label>
                                                        <input id="inquiry_name" name="name" type="text"
                                                            class="form-control @error('name') is-invalid @enderror"
                                                            placeholder="Enter Your Name *" required
                                                            autocomplete="off" value="{{ old('name') }}" />
                                                        @error('name') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                                    </div>
                                                    <div class="col-12 form-group">
                                                        <label for="inquiry_email">Your Email <span>*</span></label>
                                                        <input id="inquiry_email" name="email" type="email"
                                                            class="form-control @error('email') is-invalid @enderror"
                                                            placeholder="Enter Your Email *" required
                                                            value="{{ old('email') }}" />
                                                        @error('email') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label for="inquiry_country">Country <span>*</span></label>
                                                        <input id="inquiry_country" name="country" type="text"
                                                            class="form-control @error('country') is-invalid @enderror"
                                                            placeholder="Enter Your Country *" required
                                                            value="{{ old('country') }}" />
                                                        @error('country') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label for="inquiry_phone">Contact Number <span>*</span></label>
                                                        <input id="inquiry_phone" name="phone" type="tel"
                                                            class="form-control @error('phone') is-invalid @enderror"
                                                            placeholder="Enter Your Number *" required
                                                            value="{{ old('phone') }}" />
                                                        @error('phone') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label for="inquiry_adult">No. of Adult</label>
                                                        <input id="inquiry_adult" name="adults" type="number"
                                                            class="form-control @error('adults') is-invalid @enderror"
                                                            placeholder="Number Of Adults *" required min="1"
                                                            value="{{ old('adults', 1) }}" />
                                                        @error('adults') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                                    </div>
                                                    <div class="col-md-6 form-group">
                                                        <label for="inquiry_children">No. of Child</label>
                                                        <input id="inquiry_children" name="children" type="number"
                                                            class="form-control @error('children') is-invalid @enderror"
                                                            placeholder="Number Of Children" required min="0"
                                                            value="{{ old('children', 0) }}" />
                                                        @error('children') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                                    </div>
                                                    <div class="col-12 form-group">
                                                        <label for="inquiry_message">Your Message <span>*</span></label>
                                                        <textarea id="inquiry_message" name="message"
                                                            class="form-control @error('message') is-invalid @enderror"
                                                            placeholder="Enter Your Message *"
                                                            required>{{ old('message') }}</textarea>
                                                        @error('message') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                                    </div>
                                                    <div class="col-12 form-group mb-0">
                                                        <button class="vs-btn" type="submit">Send Request</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="sidebar-area trips-sidebar">
                        <div class="widget widget_trip-Availability accordion" id="accordionTripAvailability">
                            <div class="accordion-item">
                                <h6 class="accordion-header">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapsePrice" aria-expanded="true"
                                        aria-controls="collapsePrice">
                                        $ USD Pricing
                                    </button>
                                </h6>
                                <div id="collapsePrice" class="accordion-collapse collapse show"
                                    data-bs-parent="#accordionTripAvailability">
                                    <div class="accordion-body">
                                        <div class="header">
                                            @if($trip->offer_percentage) <span class="offer">{{ $trip->offer_percentage }}% off</span> @endif
                                            <div class="package-wrapper d-flex justify-content-between gap-2">
                                                @if(isset($trip->price_adult))
                                                    <div class="adult-price">
                                                        <div class="title"> from
                                                            @if($trip->old_price_adult)<del>${{ number_format($trip->old_price_adult) }}</del>@endif
                                                        </div>
                                                        <h5 class="price">
                                                            ${{ number_format($trip->price_adult) }}<span>/Adult</span>
                                                        </h5>
                                                    </div>
                                                @endif
                                                @if(isset($trip->price_child))
                                                    <div class="child-price">
                                                        <div class="title">from
                                                            @if($trip->old_price_child)<del>${{ number_format($trip->old_price_child) }}</del>@endif
                                                        </div>
                                                        <h5 class="price">
                                                            ${{ number_format($trip->price_child) }}<span>/Child</span>
                                                        </h5>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="body">
                                            <ul class="custom-ul">
                                                <li><i class="fa-solid fa-badge-check"></i> Best Price Guaranteed
                                                </li>
                                                <li><i class="fa-solid fa-badge-check"></i> No Booking Fees</li>
                                                <li><i class="fa-solid fa-badge-check"></i> Professional Local Guide
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="footer">
                                            <button class="vs-btn style9 w-100"> Check Availability </button>
                                            <p> Need help with booking? <a href="{{ route('contact.show') }}">Send Us A
                                                    Message</a> </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="widget widget_trip">
                                @if($trip->transportation)
                                    <div class="trip-info-box">
                                        <div class="header">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                viewBox="0 0 18 18" fill="none">
                                                <path
                                                    d="M1.87499 8.25002V6.00002C2.08199 6.00002 2.25 5.83201 2.25 5.62501C2.25 5.41801 2.08199 5.25 1.87499 5.25C0.840762 5.25 0 6.0915 0 7.12502V7.87501C0 8.49527 0.504738 9.00001 1.125 9.00001H1.87499C2.08199 9.00001 2.25 8.832 2.25 8.625C2.25 8.418 2.08199 8.25002 1.87499 8.25002Z"
                                                    fill="currentColor" />
                                                <path
                                                    d="M16.125 5.25C15.918 5.25 15.75 5.41801 15.75 5.62501C15.75 5.83201 15.918 6.00002 16.125 6.00002V8.25002C15.918 8.25002 15.75 8.41804 15.75 8.62504C15.75 8.83204 15.918 9.00001 16.125 9.00001H16.875C17.4953 9.00001 18 8.49527 18 7.87501V7.12502C18 6.0915 17.1592 5.25 16.125 5.25Z"
                                                    fill="currentColor" />
                                                <path
                                                    d="M6.37503 15.75C6.16803 15.75 6.00002 15.918 6.00002 16.125H3.75002C3.75002 15.918 3.58201 15.75 3.37501 15.75C3.16801 15.75 3 15.918 3 16.125V16.875C3 17.4953 3.50474 18 4.125 18H5.62505C6.24531 18 6.75005 17.4953 6.75005 16.875V16.125C6.75005 15.918 6.58203 15.75 6.37503 15.75Z"
                                                    fill="currentColor" />
                                                <path
                                                    d="M14.625 15.75C14.418 15.75 14.25 15.918 14.25 16.125H12C12 15.918 11.832 15.75 11.625 15.75C11.418 15.75 11.25 15.918 11.25 16.125V16.875C11.25 17.4953 11.7547 18 12.375 18H13.875C14.4953 18 15 17.4953 15 16.875V16.125C15 15.918 14.832 15.75 14.625 15.75Z"
                                                    fill="currentColor" />
                                                <path
                                                    d="M14.625 0H3.37499C2.34073 0 1.5 0.8415 1.5 1.87499V14.625C1.5 15.6585 2.34076 16.5 3.37499 16.5H14.625C15.6593 16.5 16.5 15.6585 16.5 14.625V1.87499C16.5 0.8415 15.6593 0 14.625 0ZM4.875 1.50001H13.125C13.7453 1.50001 14.25 2.00475 14.25 2.62501C14.25 3.24527 13.7453 3.75001 13.125 3.75001H4.875C4.25474 3.75001 3.75 3.24527 3.75 2.62501C3.75 2.00475 4.25474 1.50001 4.875 1.50001ZM4.875 14.25C4.25474 14.25 3.75 13.7453 3.75 13.125C3.75 12.5047 4.25474 12 4.875 12C5.49526 12 6 12.5047 6 13.125C6 13.7453 5.49523 14.25 4.875 14.25ZM13.125 14.25C12.5047 14.25 12 13.7453 12 13.125C12 12.5047 12.5047 12 13.125 12C13.7452 12 14.25 12.5047 14.25 13.125C14.25 13.7453 13.7452 14.25 13.125 14.25ZM15 9.37501C15 9.99527 14.4953 10.5 13.875 10.5H4.12498C3.50471 10.5 2.99998 9.99527 2.99998 9.37501V5.625C2.99998 5.00474 3.50471 4.5 4.12498 4.5H13.875C14.4952 4.5 15 5.00474 15 5.625V9.37501H15Z"
                                                    fill="currentColor" />
                                            </svg>
                                            <span>Transportation</span>
                                        </div>
                                        <h6 class="info-title">{{ $trip->transportation }}</h6>
                                    </div>
                                @endif
                                @if($trip->accommodation)
                                    <div class="trip-info-box">
                                        <div class="header">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="13"
                                                viewBox="0 0 19 13" fill="none">
                                                <path
                                                    d="M1.98604 7.5611V1.69518C1.98604 1.28913 1.65687 0.959961 1.25085 0.959961C0.844794 0.959961 0.515625 1.28913 0.515625 1.69518V11.2997C0.515625 11.7057 0.844794 12.0349 1.25085 12.0349C1.65687 12.0349 1.98604 11.7057 1.98604 11.2997V9.92231L17.0453 9.8869V11.2643C17.0453 11.6703 17.3744 11.9995 17.7804 11.9995C18.1865 11.9995 18.5156 11.6703 18.5156 11.2643V9.8869V7.96374V7.52569L1.98604 7.5611Z"
                                                    fill="currentColor" />
                                                <path
                                                    d="M18.5164 6.93125H7.33984V4.16252C7.33984 3.35908 7.99116 2.70776 8.7946 2.70776H15.5795C17.2015 2.70776 18.5164 4.02264 18.5164 5.64464V6.93125Z"
                                                    fill="currentColor" />
                                                <path
                                                    d="M4.72262 6.61468C5.71391 6.61468 6.51751 5.81108 6.51751 4.81979C6.51751 3.8285 5.71391 3.0249 4.72262 3.0249C3.73133 3.0249 2.92773 3.8285 2.92773 4.81979C2.92773 5.81108 3.73133 6.61468 4.72262 6.61468Z"
                                                    fill="currentColor" />
                                            </svg>
                                            <span>Accomodation</span>
                                        </div>
                                        <h6 class="info-title">{{ $trip->accommodation }}</h6>
                                    </div>
                                @endif
                                @if($trip->altitude)
                                    <div class="trip-info-box">
                                        <div class="header">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="12"
                                                viewBox="0 0 19 12" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M12.9653 5.18974L10.3742 10.3719L7.04492 2.88093L8.58721 0.586893C8.94166 0.0596826 9.52145 0.0672983 9.87077 0.586893L12.9653 5.18974Z"
                                                    fill="currentColor" />
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M5.13764 2.96876C5.4814 2.42341 6.03475 2.41709 6.38249 2.96876L11.1659 10.5575C11.5096 11.1028 11.2703 11.5449 10.6323 11.5449H0.887847C0.249391 11.5449 0.00650534 11.1092 0.354243 10.5575L5.13764 2.96876Z"
                                                    fill="currentColor" />
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M13.1973 5.33565C13.5566 4.80106 14.1353 4.79517 14.4986 5.33565L18.0219 10.5769C18.3812 11.1115 18.1538 11.5449 17.5278 11.5449H10.1681C9.53585 11.5449 9.31066 11.1174 9.67398 10.5769L13.1973 5.33565Z"
                                                    fill="currentColor" />
                                            </svg>
                                            <span>Maximum Altitude</span>
                                        </div>
                                        <h6 class="info-title">{{ $trip->altitude }}</h6>
                                    </div>
                                @endif
                                @if($trip->departure)
                                    <div class="trip-info-box">
                                        <div class="header">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="15"
                                                viewBox="0 0 18 15" fill="none">
                                                <path
                                                    d="M0.0848736 7.75932C0.0509162 7.72204 0.0260837 7.67738 0.0123343 7.62886C-0.00141505 7.58035 -0.00370535 7.5293 0.00564414 7.47975C0.0149936 7.4302 0.0357273 7.38349 0.0662099 7.34332C0.0966925 7.30315 0.136091 7.27062 0.181297 7.24827L1.66622 6.53795C1.7117 6.51674 1.76145 6.50629 1.81161 6.5074C1.86177 6.50852 1.91101 6.52117 1.9555 6.54438L3.9579 7.59861C4.00354 7.62211 4.05403 7.63463 4.10537 7.63519C4.1567 7.63575 4.20745 7.62432 4.2536 7.60183L7.40665 6.03333C7.45418 6.00971 7.49522 5.97483 7.52622 5.93175C7.55721 5.88866 7.57722 5.83866 7.5845 5.78608C7.59179 5.73351 7.58613 5.67995 7.56802 5.63006C7.54991 5.58016 7.51989 5.53545 7.48058 5.49979L3.389 1.8164C3.34949 1.7798 3.31978 1.73389 3.30258 1.68286C3.28537 1.63184 3.28121 1.57731 3.29048 1.52427C3.29975 1.47122 3.32215 1.42134 3.35564 1.37917C3.38914 1.337 3.43265 1.30389 3.48223 1.28285L4.25681 0.964656C4.59637 0.823693 4.96249 0.758159 5.32987 0.772585C5.69724 0.787011 6.0571 0.881052 6.38456 1.04821L11.2507 3.51667C11.3701 3.57666 11.502 3.60737 11.6356 3.60625C11.7692 3.60514 11.9006 3.57223 12.0189 3.51024L12.9671 3.00884C14.1467 2.29209 16.1427 2.34994 17.3094 2.82242C17.5058 2.89703 17.6758 3.02792 17.7982 3.19868C17.9206 3.36945 17.9899 3.57252 17.9974 3.78248C18.005 3.99244 17.9504 4.19996 17.8406 4.37908C17.7308 4.55819 17.5706 4.70094 17.3801 4.78947L5.5971 10.4303C4.97137 10.7289 4.26421 10.8114 3.58653 10.6648C2.90885 10.5182 2.299 10.1509 1.85264 9.6203L0.0848736 7.75932Z"
                                                    fill="currentColor" />
                                                <path
                                                    d="M17.6777 12.5997H0.321413C0.143901 12.5997 0 12.7436 0 12.9211V14.2068C0 14.3843 0.143901 14.5282 0.321413 14.5282H17.6777C17.8552 14.5282 17.9991 14.3843 17.9991 14.2068V12.9211C17.9991 12.7436 17.8552 12.5997 17.6777 12.5997Z"
                                                    fill="currentColor" />
                                            </svg>
                                            <span>Departure from</span>
                                        </div>
                                        <h6 class="info-title">{{ $trip->departure }}</h6>
                                    </div>
                                @endif
                                @if($trip->best_season)
                                    <div class="trip-info-box">
                                        <div class="header">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="20"
                                                viewBox="0 0 19 20" fill="none">
                                                <path d="M6.96484 0H8.08164V1.58782H6.96484V0Z" fill="currentColor" />
                                                <path
                                                    d="M3.41406 1.24939L4.3812 0.690994L5.17511 2.06604L4.20797 2.62444L3.41406 1.24939Z"
                                                    fill="currentColor" />
                                                <path
                                                    d="M0.966797 4.10559L1.52519 3.13845L2.90024 3.93236L2.34185 4.8995L0.966797 4.10559Z"
                                                    fill="currentColor" />
                                                <path d="M0.277344 6.68616H1.8652V7.80295H0.277344V6.68616Z"
                                                    fill="currentColor" />
                                                <path
                                                    d="M0.966797 10.3835L2.34185 9.58964L2.90024 10.5568L1.52519 11.3507L0.966797 10.3835Z"
                                                    fill="currentColor" />
                                                <path
                                                    d="M12.1426 3.93359L13.5176 3.13969L14.076 4.10683L12.701 4.90074L12.1426 3.93359Z"
                                                    fill="currentColor" />
                                                <path
                                                    d="M9.87109 2.06726L10.665 0.692179L11.6322 1.25057L10.8382 2.62566L9.87109 2.06726Z"
                                                    fill="currentColor" />
                                                <path
                                                    d="M7.75691 8.62386C7.82868 8.62386 7.90068 8.62576 7.9726 8.62952C8.32715 7.93696 8.84761 7.34383 9.49553 6.89808C10.2383 6.387 11.1024 6.10438 12.0033 6.0756C11.7773 5.20804 11.3019 4.42003 10.6267 3.8096C9.77462 3.03934 8.67231 2.61511 7.5228 2.61511C4.9697 2.61511 2.89258 4.69223 2.89258 7.24537C2.89258 8.49915 3.39111 9.6767 4.27453 10.5442C5.01109 9.37248 6.31011 8.62386 7.75691 8.62386Z"
                                                    fill="currentColor" />
                                                <path
                                                    d="M6.51367 18.6225L7.53989 19.0631L8.48924 16.8518H7.27387L6.51367 18.6225Z"
                                                    fill="currentColor" />
                                                <path
                                                    d="M9.29102 18.6225L10.3172 19.0631L11.2666 16.8518H10.0512L9.29102 18.6225Z"
                                                    fill="currentColor" />
                                                <path
                                                    d="M12.0625 18.6225L13.0887 19.0631L14.0381 16.8518H12.8227L12.0625 18.6225Z"
                                                    fill="currentColor" />
                                                <path
                                                    d="M18.2781 13.3663C18.2781 12.1789 17.3912 11.1694 16.2151 11.0181L15.7629 10.9599L15.7295 10.5051C15.6634 9.60563 15.2624 8.77001 14.6003 8.15216C13.9351 7.53134 13.0673 7.18945 12.1568 7.18945C10.6867 7.18945 9.3818 8.0706 8.83245 9.43435L8.6665 9.84634L8.22775 9.77732C8.07277 9.75294 7.9146 9.74058 7.75769 9.74058C6.37771 9.74058 5.18166 10.6745 4.84915 12.0117L4.74585 12.4272L4.31778 12.4353C3.42532 12.4521 2.69922 13.192 2.69922 14.0846C2.69922 14.9946 3.43954 15.7349 4.3495 15.7349H15.9096C17.2156 15.735 18.2781 14.6724 18.2781 13.3663Z"
                                                    fill="currentColor" />
                                            </svg>
                                            <span>Best Season</span>
                                        </div>
                                        <h6 class="info-title">{{ $trip->best_season }}</h6>
                                    </div>
                                @endif
                                @if($trip->min_age)
                                    <div class="trip-info-box">
                                        <div class="header">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="20"
                                                viewBox="0 0 18 20" fill="none">
                                                <path d="M6.6875 0H7.80429V1.58782H6.6875V0Z" fill="currentColor" />
                                                <path
                                                    d="M3.13672 1.24939L4.10386 0.690994L4.89777 2.06604L3.93063 2.62444L3.13672 1.24939Z"
                                                    fill="currentColor" />
                                                <path
                                                    d="M0.689453 4.10559L1.24785 3.13845L2.6229 3.93236L2.0645 4.8995L0.689453 4.10559Z"
                                                    fill="currentColor" />
                                                <path d="M0 6.68616H1.58785V7.80295H0V6.68616Z" fill="currentColor" />
                                                <path
                                                    d="M0.689453 10.3835L2.0645 9.58964L2.6229 10.5568L1.24785 11.3507L0.689453 10.3835Z"
                                                    fill="currentColor" />
                                                <path
                                                    d="M11.8652 3.93359L13.2403 3.13969L13.7987 4.10683L12.4236 4.90074L11.8652 3.93359Z"
                                                    fill="currentColor" />
                                                <path
                                                    d="M9.59375 2.06726L10.3877 0.692179L11.3548 1.25057L10.5609 2.62566L9.59375 2.06726Z"
                                                    fill="currentColor" />
                                                <path
                                                    d="M7.47957 8.62386C7.55134 8.62386 7.62334 8.62576 7.69526 8.62952C8.0498 7.93696 8.57026 7.34383 9.21819 6.89808C9.961 6.387 10.8251 6.10438 11.7259 6.0756C11.4999 5.20804 11.0246 4.42003 10.3493 3.8096C9.49728 3.03934 8.39497 2.61511 7.24545 2.61511C4.69235 2.61511 2.61523 4.69223 2.61523 7.24537C2.61523 8.49915 3.11377 9.6767 3.99719 10.5442C4.73375 9.37248 6.03277 8.62386 7.47957 8.62386Z"
                                                    fill="currentColor" />
                                                <path
                                                    d="M6.23633 18.6225L7.26255 19.0631L8.21189 16.8518H6.99653L6.23633 18.6225Z"
                                                    fill="currentColor" />
                                                <path
                                                    d="M9.01367 18.6225L10.0399 19.0631L10.9892 16.8518H9.77387L9.01367 18.6225Z"
                                                    fill="currentColor" />
                                                <path
                                                    d="M11.7852 18.6225L12.8114 19.0631L13.7607 16.8518H12.5454L11.7852 18.6225Z"
                                                    fill="currentColor" />
                                                <path
                                                    d="M18.0008 13.3663C18.0008 12.1789 17.1139 11.1694 15.9378 11.0181L15.4855 10.9599L15.4522 10.5051C15.386 9.60563 14.985 8.77001 14.323 8.15216C13.6578 7.53134 12.79 7.18945 11.8795 7.18945C10.4093 7.18945 9.10446 8.0706 8.55511 9.43435L8.38915 9.84634L7.9504 9.77732C7.79543 9.75294 7.63725 9.74058 7.48035 9.74058C6.10036 9.74058 4.90432 10.6745 4.57181 12.0117L4.46851 12.4272L4.04044 12.4353C3.14798 12.4521 2.42188 13.192 2.42188 14.0846C2.42188 14.9946 3.1622 15.7349 4.07216 15.7349H15.6322C16.9382 15.735 18.0008 14.6724 18.0008 13.3663Z"
                                                    fill="currentColor" />
                                            </svg>
                                            <span>Minimum Age</span>
                                        </div>
                                        <h6 class="info-title">{{ $trip->min_age }}</h6>
                                    </div>
                                @endif
                                @if($trip->max_age)
                                    <div class="trip-info-box">
                                        <div class="header">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="16"
                                                viewBox="0 0 18 16" fill="none">
                                                <path
                                                    d="M10.8622 2.94795C11.6945 3.46977 12.2781 4.35282 12.3844 5.37782C12.7238 5.53642 13.1005 5.62762 13.4999 5.62762C14.958 5.62762 16.1398 4.44581 16.1398 2.98793C16.1398 1.52983 14.958 0.348022 13.4999 0.348022C12.0557 0.348472 10.8842 1.50916 10.8622 2.94795ZM9.13276 8.35312C10.5909 8.35312 11.7727 7.17109 11.7727 5.7132C11.7727 4.25532 10.5906 3.07352 9.13276 3.07352C7.67488 3.07352 6.4924 4.25555 6.4924 5.71343C6.4924 7.17131 7.67488 8.35312 9.13276 8.35312ZM10.2526 8.53305H8.0125C6.14871 8.53305 4.63242 10.0496 4.63242 11.9134V14.6528L4.63939 14.6957L4.82808 14.7548C6.60674 15.3105 8.152 15.4958 9.42389 15.4958C11.9081 15.4958 13.348 14.7876 13.4368 14.7424L13.6131 14.6532H13.632V11.9134C13.6326 10.0496 12.1164 8.53305 10.2526 8.53305ZM14.6201 5.80778H12.3974C12.3733 6.69711 11.9937 7.49793 11.3933 8.07389C13.0499 8.56652 14.2621 10.1028 14.2621 11.9174V12.7616C16.4568 12.6812 17.7215 12.0591 17.8048 12.0174L17.9811 11.928H18V9.18763C18 7.32406 16.4837 5.80778 14.6201 5.80778ZM4.50056 5.62807C5.017 5.62807 5.49749 5.47734 5.90453 5.22058C6.03392 4.37663 6.48634 3.63915 7.13261 3.13687C7.13531 3.08745 7.14002 3.03848 7.14002 2.98861C7.14002 1.5305 5.95799 0.348696 4.50056 0.348696C3.04223 0.348696 1.86065 1.5305 1.86065 2.98861C1.86065 4.44604 3.04223 5.62807 4.50056 5.62807ZM6.87136 8.07389C6.27383 7.50085 5.89555 6.70429 5.86791 5.82035C5.78547 5.81429 5.70393 5.80778 5.61992 5.80778H3.38008C1.51629 5.80778 0 7.32406 0 9.18763V11.9275L0.00696368 11.9697L0.195657 12.0293C1.62254 12.4747 2.89599 12.68 4.0021 12.7447V11.9174C4.00255 10.1028 5.21423 8.56697 6.87136 8.07389Z"
                                                    fill="currentColor" />
                                            </svg>
                                            <span>Maximum Age</span>
                                        </div>
                                        <h6 class="info-title">{{ $trip->max_age }}</h6>
                                    </div>
                                @endif
                                @if($trip->tour_type)
                                    <div class="trip-info-box">
                                        <div class="header">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                                viewBox="0 0 18 18" fill="none">
                                                <path
                                                    d="M1.87499 8.25002V6.00002C2.08199 6.00002 2.25 5.83201 2.25 5.62501C2.25 5.41801 2.08199 5.25 1.87499 5.25C0.840762 5.25 0 6.0915 0 7.12502V7.87501C0 8.49527 0.504738 9.00001 1.125 9.00001H1.87499C2.08199 9.00001 2.25 8.832 2.25 8.625C2.25 8.418 2.08199 8.25002 1.87499 8.25002Z"
                                                    fill="currentColor" />
                                                <path
                                                    d="M16.125 5.25C15.918 5.25 15.75 5.41801 15.75 5.62501C15.75 5.83201 15.918 6.00002 16.125 6.00002V8.25002C15.918 8.25002 15.75 8.41804 15.75 8.62504C15.75 8.83204 15.918 9.00001 16.125 9.00001H16.875C17.4953 9.00001 18 8.49527 18 7.87501V7.12502C18 6.0915 17.1592 5.25 16.125 5.25Z"
                                                    fill="currentColor" />
                                                <path
                                                    d="M6.37503 15.75C6.16803 15.75 6.00002 15.918 6.00002 16.125H3.75002C3.75002 15.918 3.58201 15.75 3.37501 15.75C3.16801 15.75 3 15.918 3 16.125V16.875C3 17.4953 3.50474 18 4.125 18H5.62505C6.24531 18 6.75005 17.4953 6.75005 16.875V16.125C6.75005 15.918 6.58203 15.75 6.37503 15.75Z"
                                                    fill="currentColor" />
                                                <path
                                                    d="M14.625 15.75C14.418 15.75 14.25 15.918 14.25 16.125H12C12 15.918 11.832 15.75 11.625 15.75C11.418 15.75 11.25 15.918 11.25 16.125V16.875C11.25 17.4953 11.7547 18 12.375 18H13.875C14.4953 18 15 17.4953 15 16.875V16.125C15 15.918 14.832 15.75 14.625 15.75Z"
                                                    fill="currentColor" />
                                                <path
                                                    d="M14.625 0H3.37499C2.34073 0 1.5 0.8415 1.5 1.87499V14.625C1.5 15.6585 2.34076 16.5 3.37499 16.5H14.625C15.6593 16.5 16.5 15.6585 16.5 14.625V1.87499C16.5 0.8415 15.6593 0 14.625 0ZM4.875 1.50001H13.125C13.7453 1.50001 14.25 2.00475 14.25 2.62501C14.25 3.24527 13.7453 3.75001 13.125 3.75001H4.875C4.25474 3.75001 3.75 3.24527 3.75 2.62501C3.75 2.00475 4.25474 1.50001 4.875 1.50001ZM4.875 14.25C4.25474 14.25 3.75 13.7453 3.75 13.125C3.75 12.5047 4.25474 12 4.875 12C5.49526 12 6 12.5047 6 13.125C6 13.7453 5.49523 14.25 4.875 14.25ZM13.125 14.25C12.5047 14.25 12 13.7453 12 13.125C12 12.5047 12.5047 12 13.125 12C13.7452 12 14.25 12.5047 14.25 13.125C14.25 13.7453 13.7452 14.25 13.125 14.25ZM15 9.37501C15 9.99527 14.4953 10.5 13.875 10.5H4.12498C3.50471 10.5 2.99998 9.99527 2.99998 9.37501V5.625C2.99998 5.00474 3.50471 4.5 4.12498 4.5H13.875C14.4952 4.5 15 5.00474 15 5.625V9.37501H15Z"
                                                    fill="currentColor" />
                                            </svg>
                                            <span>Trip type</span>
                                        </div>
                                        <h6 class="info-title">{{ $trip->tour_type }}</h6>
                                    </div>
                                @endif
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if(isset($relatedTours) && $relatedTours->count() > 0)
        <section class="vs-tour-package style-3 space-bottom bg-theme-07">
            <div class="container">
                <div class="row">
                    <div class="col-lg-auto mx-auto">
                        <div class="title-area text-center">
                            <span class="sec-subtitle text-capitalize">Related trips</span>
                            <h2 class="sec-title">You Might Also Be Interested In</h2>
                        </div>
                    </div>
                </div>
                <div class="row g-4">
                    @foreach($relatedTours as $relatedTour)
                        <div class="col-md-6 col-xl-4">
                            <div class="tour-package-box style-3 bg-white-color">
                                <div class="tour-package-thumb">
                                    @if($relatedTour->images && $relatedTour->images->isNotEmpty())
                                        <img src="{{ asset('storage/' . $relatedTour->images->first()->image) }}"
                                            alt="{{ $relatedTour->title ?? 'Related Trip'}}" class="w-100" />
                                    @elseif($relatedTour->featured_image)
                                        <img src="{{ asset($relatedTour->featured_image) }}"
                                            alt="{{ $relatedTour->title ?? 'Related Trip'}}" class="w-100" />
                                    @else
                                        <img src="{{ asset('assets/img/tour-packages/tour-package-3-1.png') }}"
                                            alt="Related Trip Placeholder" class="w-100" />
                                    @endif
                                </div>
                                <div class="tour-package-content">
                                    @isset($relatedTour->departure)
                                        <div class="location"><i
                                                class="fa-sharp fa-light fa-location-dot"></i><span>{{ $relatedTour->departure }}</span>
                                        </div>
                                    @endisset
                                    <h5 class="title line-clamp-2">
                                        <a href="{{ route('trips.show', $relatedTour->slug) }}">{{ $relatedTour->title }}</a>
                                    </h5>
                                    <div class="tour-package-footer">
                                        @if($relatedTour->duration_days)
                                            <div class="tour-duration"><i class="fa-regular fa-clock"></i>
                                                <span>{{ $relatedTour->duration_days }}
                                                    {{ Str::plural('Day', $relatedTour->duration_days) }}</span>
                                            </div>
                                        @endif
                                        <div class="pricing-info fw-medium"> From
                                            @if($relatedTour->old_price_adult) <del
                                                class="text-theme-color fw-semibold">${{ number_format($relatedTour->old_price_adult) }}</del>
                                            @endif
                                            <h5 class="new-price">${{ number_format($relatedTour->price_adult ?? 0) }}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection