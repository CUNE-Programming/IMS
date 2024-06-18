<?php

use App\Http\Controllers\SeasonsController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('seasons', SeasonsController::class);
