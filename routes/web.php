<?php

use App\Http\Controllers\Admin\AdminCoordinatorsController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\AdminSportsController;
use App\Http\Controllers\Admin\AdminUsersController;
use App\Http\Controllers\Admin\AdminVariantsController;
use App\Http\Controllers\Coordinator\CoordinatorLoginController;
use App\Http\Controllers\Coordinator\CoordinatorSeasonGamesController;
use App\Http\Controllers\Coordinator\CoordinatorSeasonsController;
use Illuminate\Support\Facades\Route;

Route::get('admin/login', [AdminLoginController::class, 'create'])->name('admin.login.create')->middleware('guest');
Route::post('admin/login', [AdminLoginController::class, 'store'])->name('admin.login.store')->middleware('guest');
Route::get('admin/login/{user}', [AdminLoginController::class, 'show'])->name('admin.login.show')->middleware('signed');
Route::delete('admin/logout', [AdminLoginController::class, 'destroy'])->name('admin.login.destroy')->middleware('auth');
Route::resource('admin/coordinators', AdminCoordinatorsController::class)->except('show')->names('admin.coordinators')->middleware('admin');
Route::resource('admin/sports', AdminSportsController::class)->except('show')->names('admin.sports')->middleware('admin');
Route::resource('admin/variants', AdminVariantsController::class)->except('show')->names('admin.variants')->middleware('admin');
Route::post('admin/users', [AdminUsersController::class, 'store'])->name('admin.users.store')->middleware('admin');

Route::get('coordinator/login', [CoordinatorLoginController::class, 'create'])->name('coordinator.login.create')->middleware('guest');
Route::post('coordinator/login', [CoordinatorLoginController::class, 'store'])->name('coordinator.login.store')->middleware('guest');
Route::get('coordinator/login/{user}', [CoordinatorLoginController::class, 'show'])->name('coordinator.login.show')->middleware('signed');
Route::delete('coordinator/logout', [CoordinatorLoginController::class, 'destroy'])->name('coordinator.login.destroy')->middleware('auth');
Route::resource('coordinator/seasons', CoordinatorSeasonsController::class)->names('coordinator.seasons')->except(['destroy'])->middleware('coordinator');
Route::resource('coordinator/seasons.games', CoordinatorSeasonGamesController::class)->names('coordinator.seasons.games')->except(['destroy'])->middleware('coordinator');
