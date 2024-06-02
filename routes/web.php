<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DistrictController;
use App\Http\Controllers\Admin\TypeController;
use App\Http\Controllers\Admin\PlaceController;
use App\Http\Controllers\Admin\AboutController;
use App\Http\Controllers\Admin\GuideController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\PackageController;
use App\Http\Controllers\Admin\BookingController;

use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\BookingController as UserBookingController;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('welcome');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/place/details/{id}', [HomeController::class, 'placeDetails'])->name('place.details');
Route::get('/package/details/{id}', [HomeController::class, 'packageDetails'])->name('package.details');
Route::get('/place-list', [HomeController::class, 'allPlace'])->name('all.place');
Route::get('/package-list', [HomeController::class, 'allPackage'])->name('all.package');
Route::get('/district/{id}', [HomeController::class, 'districtWisePlace'])->name('district.wise.place');
Route::get('/placetype/{id}', [HomeController::class, 'placetypeWisePlace'])->name('placetype.wise.place');

// Auth Routes
Auth::routes(['verify' => true]);
Route::group([
    'as' => 'admin.',
    'prefix' => 'admin',
    'middleware' => ['auth', 'admin', 'verified']
], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('profile-info', [DashboardController::class, 'showProfile'])->name('profile.show');
    Route::get('profile-info/edit/{id}', [DashboardController::class, 'editProfile'])->name('profile.edit');
    Route::post('profile-info/update', [DashboardController::class, 'updateProfile'])->name('profile.update');

    Route::resource('district', DistrictController::class);
    Route::resource('type', TypeController::class);
    Route::resource('place', PlaceController::class);
    Route::resource('about', AboutController::class);
    Route::resource('guide', GuideController::class);
    Route::resource('users', UsersController::class);
    Route::resource('package', PackageController::class);
    Route::get('list', [UsersController::class, 'adminList'])->name('list');

    Route::get('booking-request/list', [BookingController::class, 'pendingBookingList'])->name('pending.booking');
    Route::post('booking-request/approve/{id}', [BookingController::class, 'bookingApprove'])->name('booking.approve');
    Route::post('booking-request/remove/{id}', [BookingController::class, 'bookingRemoveByAdmin'])->name('booking.remove');
    Route::get('running/packages', [BookingController::class, 'runningPackage'])->name('package.running');
    Route::post('running/package/complete/{id}', [BookingController::class, 'runningPackageComplete'])->name('package.running.complete');
    Route::get('tour-history/list', [BookingController::class, 'tourHistory'])->name('tour.history');
});

Route::group([
    'as' => 'user.',
    'prefix' => 'user',
    'middleware' => ['auth', 'user', 'verified']
], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('profile-info', [DashboardController::class, 'showProfile'])->name('profile.show');
    Route::get('profile-info/edit/{id}', [DashboardController::class, 'editProfile'])->name('profile.edit');
    Route::post('profile-info/update', [DashboardController::class, 'updateProfile'])->name('profile.update');

    Route::get('districts', [DashboardController::class, 'getDistrict'])->name('district');
    Route::get('placetypes', [DashboardController::class, 'getPlaceType'])->name('placetype');

    Route::get('places', [DashboardController::class, 'getPlaces'])->name('place');
    Route::get('places/{id}', [DashboardController::class, 'getPlaceDetails'])->name('place.show');

    Route::get('guides', [DashboardController::class, 'getGuides'])->name('guide');
    Route::get('guide/{id}', [DashboardController::class, 'getGuideDetails'])->name('guide.show');

    Route::get('packages', [DashboardController::class, 'getPackage'])->name('package');
    Route::get('packages/{id}', [DashboardController::class, 'getPackageDetails'])->name('package.show');

    Route::get('tour-history/list', [BookingController::class, 'tourHistory'])->name('tour.history');
    Route::get('booking-request/list', [BookingController::class, 'pendingBookingList'])->name('pending.booking');
    Route::post('booking-request/cancel/{id}', [BookingController::class, 'cancelBookingRequest'])->name('booking.cancel');
});
// View Composer
View::composer('layouts.frontend.inc.footer', function ($view) {
    $placetypes = App\Placetype::all();
    $view->with('placetypes', $placetypes);
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
