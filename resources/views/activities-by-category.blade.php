@extends('layouts.app2')

@section('title', 'Activities in ' . $category->name)

@section('content')
<main>
    <section class="vs-breadcrumb" data-bg-src="{{ asset('assets/img/bg/breadcrumb-bg.png') }}">
        <img src="{{ asset('assets/img/icons/cloud.png') }}" alt="vs-breadcrumb-icon" class="vs-breadcrumb-icon-1 animate-parachute" />
        <img src="{{ asset('assets/img/icons/ballon-sclation.png') }}" alt="vs-breadcrumb-icon" class="vs-breadcrumb-icon-2 animate-parachute" />
        <div class="container">
            <div class="row text-center">
                <div class="col-12">
                    <div class="breadcrumb-content">
                        <h1 class="breadcrumb-title">{{ $category->name }} Activities</h1>
                         @if($category->description)
                            <p class="text-white">{{ $category->description }}</p>
                         @endif
                    </div>
                    <div class="breadcrumb-menu">
                        <ul class="custom-ul">
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li><a href="{{ route('activity-categories.index') }}">Activity Categories</a></li>
                            <li>{{ $category->name }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="vs-tour-package space">
        <div class="container">
            @if($activities->count() > 0)
                <div class="row gy-4">
                    @foreach ($activities as $activity)
                        <div class="col-md-6 col-lg-4">
                            <div class="tour-package-box bg-white-color h-100">
                                <div class="tour-package-thumb">
                                @php
                                    $firstImage = optional($activity->images->first())->image;
                                    $imageUrl = $firstImage
                                        ? asset(Str::startsWith($firstImage, 'storage/') ? $firstImage : 'storage/' . $firstImage)
                                        : asset('assets/img/tour-packages/tour-package-1-3.png');
                                @endphp
                                    <a href="{{ route('activities.show', $activity->slug) }}">
                                        <img src="{{ $imageUrl }}" alt="{{ $activity->title }}" class="w-100" />
                                    </a>
                                     @if(isset($activity->discount_percentage) && $activity->discount_percentage > 0)
                                         <span class="tour-package-offer">{{ $activity->discount_percentage }}% OFF</span>
                                     @endif
                                </div>
                                <div class="tour-package-content">
                                    @if($activity->departure)
                                        <div class="tour-package-location">
                                            <i class="fas fa-map-marker-alt"></i> {{ $activity->departure }}
                                        </div>
                                    @endif
                                    <h5 class="tour-package-title line-clamp-2">
                                        <a href="{{ route('activities.show', $activity->slug) }}">{{ $activity->title }}</a>
                                    </h5>
                                    <div class="row g-2 justify-content-between align-items-center mt-auto pt-3">
                                        <div class="col-auto">
                                            <div class="tour-package-info">
                                                @if($activity->duration_days)
                                                    <span class="info-item">
                                                        <i class="fas fa-clock"></i> {{ $activity->duration_days }} {{ Str::plural('Day', $activity->duration_days) }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                             @if(isset($activity->price_adult))
                                                <div class="tour-package-price">
                                                    From <span class="price">${{ number_format($activity->price_adult) }}</span>
                                                </div>
                                             @endif
                                        </div>
                                    </div>
                                     <a href="{{ route('activities.show', $activity->slug) }}" class="vs-btn style7 w-100 mt-3">View Details</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="row">
                    <div class="col-12 d-flex justify-content-center mt-5">
                        {{ $activities->links() }}
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-12 text-center">
                        <p>There are currently no activities listed under the category "{{ $category->name }}".</p>
                        <a href="{{ route('activity-categories.index') }}" class="vs-btn mt-3">View Other Categories</a>
                    </div>
                </div>
            @endif
        </div>
    </section>
</main>
@endsection

@push('styles')
<style>
    .tour-package-box {
        display: flex;
        flex-direction: column;
    }
    .tour-package-content {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    .tour-package-content > .row {
        margin-top: auto;
    }
    .line-clamp-2 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
     .line-clamp-3 {
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
    }
    .tour-package-thumb {
        position: relative;
    }
    .tour-package-offer {
        position: absolute;
        top: 15px;
        left: 15px;
        background-color: var(--theme-color);
        color: white;
        padding: 5px 10px;
        font-size: 0.8em;
        font-weight: bold;
        border-radius: 3px;
        z-index: 2;
    }
    .tour-package-info .info-item {
        margin-right: 10px;
        font-size: 0.9em;
        color: #666;
    }
    .tour-package-info .info-item i {
        margin-right: 4px;
        color: var(--theme-color);
    }
    .tour-package-price {
        font-size: 0.9em;
        color: #666;
    }
     .tour-package-price .price {
        font-size: 1.3em;
        font-weight: bold;
        color: var(--title-color);
    }
</style>
@endpush