<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;


Route::view('/', 'welcome');

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

    Volt::route('/bars', 'bars')->name('bars')->middleware(['auth']);
    Volt::route('/hotels', 'hotels')->name('hotels')->middleware(['auth']);
    Volt::route('/motels', 'motels')->name('motels')->middleware(['auth']);
    Volt::route('/event/centers', 'event-centers')->name('event-centers')->middleware(['auth']);
    Volt::route('/online/drinks', 'online-drinks')->name('online-drinks')->middleware(['auth']);
    Volt::route('/restaurants', 'restaurants')->name('restaurants')->middleware(['auth']);
    Volt::route('/guest/houses', 'guest-houses')->name('guest-houses')->middleware(['auth']);
    Volt::route('/generate/tax', 'generatetax')->name('generate-tax')->middleware(['auth']);
    Volt::route('/dashboard', 'dashboard')->name('dashboard')->middleware(['auth']);
    Volt::route('/dashboard/manager', 'dashboard-manager')->name('manager.dashboard')->middleware(['auth']);
    Volt::route('/dashboard/tax-payer', 'dashboard-user')->name('user.dashboard')->middleware(['auth']);

    Volt::route('/add/earning', 'add-earning')->name('add.earning')->middleware(['auth']);
    Volt::route('/assessment', 'assessment')->name('assessment')->middleware(['auth']);
    Volt::route('/taxpayer/validation', 'taxpayer-validation')->name('taxpayer-validation')->middleware(['guest']);


    // Route::get('/taxpayer', function () {
    //     return view('livewire.taxpayer');
    // })->middleware(['auth']);

    // Route::get('/dashboard', function () {
    //     return view('livewire.dashboard');
    // })->middleware(['auth']);

require __DIR__.'/auth.php';
