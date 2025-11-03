<?php

use App\Livewire\EditorDemo;
use App\Livewire\LightboxDemo;
use App\Livewire\SidebarDemo;
use App\Livewire\SliderDemo;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/sidebar', SidebarDemo::class)->name('sidebar.demo');
Route::get('/lightbox', LightboxDemo::class)->name('lightbox.demo');
Route::get('/slider', SliderDemo::class)->name('slider.demo');
Route::get('/editor', EditorDemo::class)->name('editor.demo');
