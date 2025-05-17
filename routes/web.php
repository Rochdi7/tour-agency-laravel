<?php

use Illuminate\Support\Facades\Route;

// --- Import Controllers ---
use App\Http\Controllers\HomepageController; // <-- Added
use App\Http\Controllers\TourController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SearchBarController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\TourInquiryController;
use App\Http\Controllers\ActivityInquiryController;
use App\Http\Controllers\NewsletterController;

Route::get('/', [HomepageController::class, 'index'])->name('home');

// --- Search ---
Route::get('/search-bar', [SearchBarController::class, 'index'])->name('search.bar');
Route::get('/search', [SearchController::class, 'index'])->name('search');

// --- Blog ---
Route::controller(BlogController::class)->prefix('blog')->name('blog.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/search', 'search')->name('search'); // Keep if specific search logic needed that index doesn't handle
    Route::get('/{slug}', 'show')->name('show'); // Detail page uses slug
    
});
// Blog related routes outside the main controller group
Route::get('/category/{category:slug}', [CategoryController::class, 'show'])->name('category.show'); // Uses category slug binding
Route::get('/tag/{tag:slug}', [TagController::class, 'show'])->name('tag.show'); // Uses tag slug binding
Route::post('comments/reply/{id}', [BlogController::class, 'replyToComment'])->name('comments.reply');
Route::post('/comments/{id}', [CommentController::class, 'store'])->name('comments.store');

// --- Tours ---
Route::get('/destinations', [TourController::class, 'listPlaces'])->name('destinations.index');
Route::controller(TourController::class)->prefix('tours')->name('tours.')->group(function () {
    Route::get('/', 'index')->name('index'); // List page (might also handle search results)
    // Route::get('/search', 'search')->name('search'); // This might be redundant if index handles search filtering
    Route::get('/{slug}', 'show')->name('show'); // Detail page uses slug
});
// Tour inquiry route
Route::post('/tours/{tour}/inquiry', [TourInquiryController::class, 'store'])->name('tour.inquiry.submit'); // Uses tour model binding (ID default)
Route::get('/tours/place/{slug}', [TourController::class, 'byPlace'])->name('tours.byPlace');

// --- Activities ---
Route::get('/activity-categories', [ActivityController::class, 'listCategories'])->name('activity-categories.index');
Route::controller(ActivityController::class)->prefix('activities')->name('activities.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/category/{category_slug}', 'showByCategory')->name('byCategory'); // Uses category slug parameter
    Route::get('/{slug}', 'show')->name('show'); // Detail page uses slug
});
// Activity inquiry route
Route::post('/activities/{activity}/inquiry', [ActivityInquiryController::class, 'store'])->name('activity.inquiry.submit'); // Uses activity model binding (ID default)

// --- Trips ---
Route::controller(TripController::class)->prefix('trips')->name('trips.')->group(function () {
    Route::get('/', 'index')->name('index'); // Renamed from 'trips' for consistency
    Route::get('/{slug}', 'show')->name('show'); // Detail page uses slug
});
// Trip inquiry route (using trip model binding, assuming 'slug' is the key or default ID)
Route::post('/trips/{trip}/inquire', [InquiryController::class, 'storeTripInquiry'])->name('trip.inquiry');

// --- Contact ---
Route::controller(ContactController::class)->prefix('contact')->name('contact.')->group(function () {
    Route::get('/', 'index')->name('show');
    Route::post('/', 'store')->name('submit'); // Changed name from 'submit' to 'store' for convention
});

// --- Static Pages ---
Route::view('/faq', 'faq')->name('faq'); // Use Route::view for simple static views
Route::view('/about', 'about')->name('about'); // Use Route::view

// ==================================
// ADMIN ROUTES (Requires Auth)
// ==================================
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {

    // Group routes by resource/controller where applicable
    Route::controller(TourController::class)->prefix('tours')->name('tours.')->group(function () {
        Route::get('/create', 'create')->name('create');
        Route::post('/', 'store')->name('store');
        Route::get('/{tour:slug}/edit', 'edit')->name('edit'); // Explicit slug binding
        Route::put('/{tour:slug}', 'update')->name('update'); // Explicit slug binding
        Route::delete('/{tour:slug}', 'destroy')->name('destroy'); // Explicit slug binding
    });

});

Route::get('/terms-and-conditions', function () {
    return view('terms-and-conditions')->render();
})->name('terms.conditions');

Route::get('/cookie-policy', function () {
    return view('cookie-policy');
})->name('cookie.policy');
Route::get('/privacy-policy', function () {
    return view('privacy-policy');
})->name('privacy.policy');

Route::get('/category/{category:slug}', [CategoryController::class, 'show'])->name('category.show'); // Uses category slug binding
Route::get('/tag/{tag:slug}', [TagController::class, 'show'])->name('tag.show');

Route::get('/tours/type/multi-day', [TourController::class, 'showMultiDay'])->name('tours.multi_day');
Route::get('/tours/type/one-day', [TourController::class, 'showOneDay'])->name('tours.one_day');

// Route for Specific Type (Garden Tours, Art Tours, etc.)
Route::get('/tours/type/{type}', [TourController::class, 'showByType'])->name('tours.type');
Route::post('/newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

Route::get('/sitemap.xml', [App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');
