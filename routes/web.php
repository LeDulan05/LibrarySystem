<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::group(['prefix' => 'admin'], function () {
    Route::get('/dashboard', function () {return view('admin.overviewPage');})->name('admin.dashboard');
});
