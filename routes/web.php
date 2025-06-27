<?php

use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Livewire\TaxpayerLogin;

    Route::view('/', 'welcome');

    // Route::view('dashboard', 'dashboard')
    //     ->middleware(['auth', 'verified'])
   //     ->name('dashboard');

    Route::middleware('guest:taxpayer')->group(function () {
        Volt::route('/taxpayer/login', 'taxpayerlogin')->name('taxpayer.login');
    });

    Route::view('profile', 'profile')->middleware(['auth'])->name('profile');

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

    Volt::route('/add/earning', 'add-earning')->name('add.earning')->middleware(['auth']);
    Volt::route('/assessment', 'assessment')->name('assessment')->middleware(['auth:taxpayer']);
    Volt::route('/taxpayer/validation', 'taxpayer-validation')->name('taxpayer-validation')->middleware(['guest']);

    // Volt::route('/taxpayer/dashboard', 'taxpayer.dashboard')
    // ->middleware('auth:taxpayer')
    // ->name('taxpayer.dashboard');
        Volt::route('/assessments', 'getassessments')->name('get-assessment')->middleware(['auth']);

    Volt::route('/view/assessment', 'view-assessments')->name('view-assessment')->middleware(['auth:taxpayer']);
    Volt::route('/dashboard/tax-payer', 'dashboard-user')->name('user.dashboard')->middleware(['auth:taxpayer']);


    // Route::get('/taxpayer', function () {
    //     return view('livewire.taxpayer');
    // })->middleware(['auth']);

    // Route::get('/dashboard', function () {
    //     return view('livewire.dashboard');
    // })->middleware(['auth']);

require __DIR__.'/auth.php';
