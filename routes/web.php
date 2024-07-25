<?php

use App\Http\Controllers\Admin\AdminCoordinatorsController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\AdminSportsController;
use App\Http\Controllers\Admin\AdminUsersController;
use App\Http\Controllers\Admin\AdminVariantsController;
use Illuminate\Support\Facades\Route;

Route::get('admin/login', [AdminLoginController::class, 'create'])->name('admin.login.create')->middleware('guest');
Route::post('admin/login', [AdminLoginController::class, 'store'])->name('admin.login.store')->middleware('guest');
Route::get('admin/login/{user}', [AdminLoginController::class, 'show'])->name('admin.login.show')->middleware('signed');
Route::delete('admin/logout', [AdminLoginController::class, 'destroy'])->name('admin.login.destroy')->middleware('auth');
Route::get('admin/coordinators', [AdminCoordinatorsController::class, 'index'])->name('admin.coordinators.index')->middleware('admin');
Route::get('admin/coordinators/create', [AdminCoordinatorsController::class, 'create'])->name('admin.coordinators.create')->middleware('admin');
Route::post('admin/coordinators', [AdminCoordinatorsController::class, 'store'])->name('admin.coordinators.store')->middleware('admin');
Route::delete('admin/coordinators/', [AdminCoordinatorsController::class, 'destroy'])->name('admin.coordinators.destroy')->middleware('admin');
Route::get('admin/sports', [AdminSportsController::class, 'index'])->name('admin.sports.index')->middleware('admin');
Route::get('admin/sports/create', [AdminSportsController::class, 'create'])->name('admin.sports.create')->middleware('admin');
Route::post('admin/sports', [AdminSportsController::class, 'store'])->name('admin.sports.store')->middleware('admin');
Route::get('admin/sport/{sport}/edit', [AdminSportsController::class, 'edit'])->name('admin.sports.edit')->middleware('admin');
Route::patch('admin/sport/{sport}', [AdminSportsController::class, 'update'])->name('admin.sports.update')->middleware('admin');
Route::put('admin/sport/{sport}', [AdminSportsController::class, 'update'])->name('admin.sports.update')->middleware('admin');
Route::delete('admin/sport/{sport}', [AdminSportsController::class, 'destroy'])->name('admin.sports.destroy')->middleware('admin');
Route::get('admin/variants', [AdminVariantsController::class, 'index'])->name('admin.variants.index')->middleware('admin');
Route::get('admin/variants/create', [AdminVariantsController::class, 'create'])->name('admin.variants.create')->middleware('admin');
Route::post('admin/variants', [AdminVariantsController::class, 'store'])->name('admin.variants.store')->middleware('admin');
Route::get('admin/variant/{variant}/edit', [AdminVariantsController::class, 'edit'])->name('admin.variants.edit')->middleware('admin');
Route::patch('admin/variant/{variant}', [AdminVariantsController::class, 'update'])->name('admin.variants.update')->middleware('admin');
Route::put('admin/variant/{variant}', [AdminVariantsController::class, 'update'])->name('admin.variants.update')->middleware('admin');
Route::post('admin/users', [AdminUsersController::class, 'store'])->name('admin.users.store')->middleware('admin');
