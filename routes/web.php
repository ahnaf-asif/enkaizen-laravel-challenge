<?php

use Illuminate\Support\Facades\Route;

// all routes will end up showing the home view and we'll handle actual routes using vue-router

Route::get('/{any}', function () {
    return view('home');
})->where('any', '.*');

