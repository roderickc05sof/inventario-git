<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Teams\TeamInvitationController;
use App\Http\Middleware\EnsureTeamMembership;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VistaController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ComponentController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\AssetStatusController;
use App\Http\Controllers\ManufacturerController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\AssignmentController;

Route::redirect('/', '/login');

Route::prefix('{current_team}')
    ->middleware(['auth', 'verified', EnsureTeamMembership::class])
    ->group(function () {
        Route::get('dashboard', DashboardController::class)->name('dashboard');
    });

Route::resource('users', UserController::class);

// Rutas de Activos
Route::get('assets', [AssetController::class, 'index'])->name('assets.index');
Route::get('assets/create',[AssetController::class, 'create'])->name('assets.create');
Route::post('/assets',[AssetController::class,'store'])->name('assets.store');
Route::get('/assets/{asset}/edit', [AssetController::class, 'edit'])->name('assets.edit');
Route::put('/assets/{asset}', [AssetController::class, 'update'])->name('assets.update');
Route::delete('/assets/{asset}', [AssetController::class, 'destroy'])->name('assets.destroy');

// Rutas de Componentes
Route::get('/components', [ComponentController::class, 'index'])->name('components.index');
Route::get('/components/create', [ComponentController::class, 'create'])->name('components.create');
Route::post('/components', [ComponentController::class, 'store'])->name('components.store');
Route::get('/components/{component}/edit', [ComponentController::class, 'edit'])->name('components.edit');
Route::put('/components/{component}', [ComponentController::class, 'update'])->name('components.update');
Route::delete('/components/{component}', [ComponentController::class, 'destroy'])->name('components.destroy');

// Rutas de Asignaciones
Route::get('/assignments', [AssignmentController::class, 'index'])->name('assignments.index');
Route::get('/assignments/create', [AssignmentController::class, 'create'])->name('assignments.create');
Route::post('/assignments', [AssignmentController::class, 'store'])->name('assignments.store');
Route::get('/assignments/{assignment}/edit', [AssignmentController::class, 'edit'])->name('assignments.edit');
Route::put('/assignments/{assignment}', [AssignmentController::class, 'update'])->name('assignments.update');
Route::delete('/assignments/{assignment}', [AssignmentController::class, 'destroy'])->name('assignments.destroy');

// Rutas de Vistas y Permisos
Route::resource('vistas', VistaController::class);
Route::get('/vista', [VistaController::class, 'index'])->name('vista.index');

Route::get('/permisos', [PermisoController::class,'index'])->name('permisos.index');
Route::post('/permisos', [PermisoController::class,'update'])->name('permisos.update');
Route::get('/permisos/{role}', [PermisoController::class,'getPermissions']);

// Catálogos
Route::middleware(['auth'])->group(function () {
    Route::resource('locations', LocationController::class)->except(['create', 'show', 'edit']);
    Route::resource('categories', CategoriesController::class)->except(['create', 'show', 'edit']);
    Route::resource('manufacturers', ManufacturerController::class)->except(['create', 'show', 'edit']);
    Route::resource('asset-statuses', AssetStatusController::class)->except(['create', 'show', 'edit'])->parameters([
        'asset-statuses' => 'assetStatus'
    ]);
});

Route::middleware(['auth'])->group(function () {
    Route::get('invitations/{invitation}/accept', [TeamInvitationController::class, 'accept'])->name('invitations.accept');
    Route::delete('invitations/{invitation}', [TeamInvitationController::class, 'decline'])->name('invitations.decline');
});

require __DIR__.'/settings.php';

Route::middleware(['auth'])->group(function () {
    Route::resource('locations', LocationController::class)->except(['create', 'show', 'edit']);
    Route::resource('categories', CategoriesController::class)->except(['create', 'show', 'edit']);
    Route::resource('manufacturers', ManufacturerController::class)->except(['create', 'show', 'edit']);
    Route::resource('asset-statuses', AssetStatusController::class)->except(['create', 'show', 'edit'])->parameters([
        'asset-statuses' => 'assetStatus'
    ]);
});

Route::middleware(['auth'])->group(function () {
    Route::get('invitations/{invitation}/accept', [TeamInvitationController::class, 'accept'])->name('invitations.accept');
    Route::delete('invitations/{invitation}', [TeamInvitationController::class, 'decline'])->name('invitations.decline');
});

require __DIR__.'/settings.php';