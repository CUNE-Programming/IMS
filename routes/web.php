<?php

use App\Http\Controllers\Admin\AdminCoordinatorsController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\AdminSportsController;
use App\Http\Controllers\Admin\AdminUsersController;
use App\Http\Controllers\Admin\AdminVariantsController;
use App\Http\Controllers\Handlers\ApproveTeamHandler;
use App\Http\Controllers\Handlers\DenyTeamHandler;
use App\Http\Controllers\Handlers\GetPlayersForSelectHandler;
use App\Http\Controllers\Handlers\PostponeGameHandler;
use App\Http\Controllers\Handlers\SeasonICalHandler;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\SeasonFreeAgentsController;
use App\Http\Controllers\SeasonGamesController;
use App\Http\Controllers\SeasonsController;
use App\Http\Controllers\SeasonTeamsController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'index')->name('index');

Route::resource('contact-us', ContactUsController::class)->only(['create', 'store'])->names('contact-us');
Route::resource('register', RegistrationController::class)->only(['create', 'store'])->names('registration');
Route::get('/login', [SessionController::class, 'create'])->name('sessions.create')->middleware('guest');
Route::post('/login', [SessionController::class, 'store'])->name('sessions.store')->middleware('guest');
Route::get('/login/{user}', [SessionController::class, 'show'])->name('sessions.show')->middleware('signed');
Route::get('invitations/{team}/{email}', [InvitationController::class, 'show'])->name('invitations.show')->middleware('signed');
Route::post('invitations/{team}/update', [InvitationController::class, 'update'])->name('invitations.update')->middleware('guest');

// Auth routes

Route::resource('seasons.teams', SeasonTeamsController::class)->middleware('auth');
Route::resource('seasons.free-agents', SeasonFreeAgentsController::class)->only(['store'])->middleware('auth');
Route::get('seasons/{season}/ical', SeasonICalHandler::class)->name('seasons.ical')->middleware('auth');
Route::resource('seasons', SeasonsController::class)->except(['edit', 'update', 'destroy'])->middleware('auth');
Route::get('/api/players', GetPlayersForSelectHandler::class)->name('api.players')->middleware('auth');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit')->middleware('auth');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth');
Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy')->middleware('auth');
Route::delete('/logout', [SessionController::class, 'destroy'])->name('sessions.destroy')->middleware('auth');
Route::post('seasons/{season}/teams/{team}/approve', ApproveTeamHandler::class)->name('seasons.teams.approve')->middleware(['auth', 'coordinator']);
Route::post('seasons/{season}/teams/{team}/deny', DenyTeamHandler::class)->name('seasons.teams.deny')->middleware(['auth', 'coordinator']);
Route::resource('seasons.games', SeasonGamesController::class)->middleware('auth');
Route::post('seasons/{season}/games/{game}/postpone', PostponeGameHandler::class)->name('seasons.games.postpone')->middleware(['auth', 'coordinator']);

// Admin routes

Route::get('admin/login', [AdminLoginController::class, 'create'])->name('admin.login.create')->middleware('guest');
Route::post('admin/login', [AdminLoginController::class, 'store'])->name('admin.login.store')->middleware('guest');
Route::get('admin/login/{user}', [AdminLoginController::class, 'show'])->name('admin.login.show')->middleware('signed');
Route::delete('admin/logout', [AdminLoginController::class, 'destroy'])->name('admin.login.destroy')->middleware('auth');
Route::resource('admin/coordinators', AdminCoordinatorsController::class)->except('show')->names('admin.coordinators')->middleware('admin');
Route::resource('admin/sports', AdminSportsController::class)->except('show')->names('admin.sports')->middleware('admin');
Route::resource('admin/variants', AdminVariantsController::class)->except('show')->names('admin.variants')->middleware('admin');
Route::post('admin/users', [AdminUsersController::class, 'store'])->name('admin.users.store')->middleware('admin');
