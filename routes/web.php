<?php

use App\Livewire\AppointmentBookingDemo;
use App\Livewire\ColorPickerDemo;
use App\Livewire\EditorDemo;
use App\Livewire\LightboxDemo;
use App\Livewire\RangeSliderDemo;
use App\Livewire\SidebarDemo;
use App\Livewire\SliderDemo;
use App\Livewire\UserProfileDemo;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/sidebar', SidebarDemo::class)->name('sidebar.demo');
Route::get('/lightbox', LightboxDemo::class)->name('lightbox.demo');
Route::get('/slider', SliderDemo::class)->name('slider.demo');
Route::get('/editor', EditorDemo::class)->name('editor.demo');
Route::get('/appointment-booking', AppointmentBookingDemo::class)->name('appointment-booking.demo');
Route::get('/profile-demo', UserProfileDemo::class)->name('profile.demo');
Route::get('/color-picker', ColorPickerDemo::class)->name('color-picker.demo');
Route::get('/range-slider', RangeSliderDemo::class)->name('range-slider.demo');
