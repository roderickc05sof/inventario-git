<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Teams\TeamInvitationController;
use App\Http\Middleware\EnsureTeamMembership;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AssetController;

Route::inertia('/', 'Welcome')->name('home');

// 2. Grupo protegido por equipo y autenticación (¡Aquí adentro deben ir tus activos!)
Route::prefix('{current_team}')
    ->middleware(['auth', 'verified', EnsureTeamMembership::class])
    ->group(function () {
        
        Route::get('dashboard', DashboardController::class)->name('dashboard');
        
        // Rutas de Activos protegidas dentro del contexto del equipo
    });
     Route::get('assets', [AssetController::class, 'index'])->name('assets.index');
     Route::get('assets/create',[AssetController::class, 'create'])->name('assets.create');
     Route::post('/assets',[AssetController::class,'store'])->name('assets.store');
   Route::get('/assets/{asset}/edit', [AssetController::class, 'edit'])
    ->name('assets.edit');
    Route::put('/assets/{asset}', [AssetController::class, 'update'])
    ->name('assets.update');
    Route::delete('/assets/{asset}', [AssetController::class, 'destroy'])
    ->name('assets.destroy');

 //    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');

// 3. Otras rutas protegidas de invitaciones
Route::middleware(['auth'])->group(function () {
    Route::get('invitations/{invitation}/accept', [TeamInvitationController::class, 'accept'])->name('invitations.accept');
    Route::delete('invitations/{invitation}', [TeamInvitationController::class, 'decline'])->name('invitations.decline');
});

require __DIR__.'/settings.php';