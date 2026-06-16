<?php

use App\Http\Controllers\Admin\TournamentApprovalController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MatchResultController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TournamentController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/tournaments', [TournamentController::class, 'index'])->name('tournaments.index');
Route::get('/tournaments/{tournament}', [TournamentController::class, 'show'])->name('tournaments.show');
Route::get('/teams', [TeamController::class, 'index'])->name('teams.index');
Route::get('/teams/{team}', [TeamController::class, 'show'])->name('teams.show');

Route::middleware('auth')->group(function (): void {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/teams/create', [TeamController::class, 'create'])->name('teams.create');
    Route::post('/teams', [TeamController::class, 'store'])->name('teams.store');
    Route::post('/tournaments/{tournament}/register', [TournamentController::class, 'register'])->name('tournaments.register');
});

Route::middleware(['auth', 'admin'])->group(function (): void {
    Route::get('/tournaments/create', [TournamentController::class, 'create'])->name('tournaments.create');
    Route::post('/tournaments', [TournamentController::class, 'store'])->name('tournaments.store');
    Route::get('/admin/tournaments', [TournamentApprovalController::class, 'index'])->name('admin.tournaments.index');
    Route::post('/admin/registrations/{registration}/approve', [TournamentApprovalController::class, 'approve'])->name('admin.registrations.approve');
    Route::post('/admin/registrations/{registration}/reject', [TournamentApprovalController::class, 'reject'])->name('admin.registrations.reject');
    Route::post('/admin/tournaments/{tournament}/demo-bracket', [TournamentApprovalController::class, 'generateDemoBracket'])->name('admin.tournaments.demo-bracket');
    Route::get('/matches/{match}/edit', [MatchResultController::class, 'edit'])->name('matches.edit');
    Route::put('/matches/{match}', [MatchResultController::class, 'update'])->name('matches.update');
});
