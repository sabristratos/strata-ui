<?php

use App\Livewire\SidebarDemo;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/sidebar', SidebarDemo::class)->name('sidebar.demo');
