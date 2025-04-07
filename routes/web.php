<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RoutingController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';
Route::get('/register', [RegisteredUserController::class, 'create'])
    ->middleware('guest')
    ->name('register');

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest');

Route::middleware(['auth'])->group(function () {
    // Rutas para la página principal y el calendario
    Route::get('/', function () {
        return redirect('/calendario');
    });
    Route::get('/calendario', [EventController::class, 'index'])->name('calendario');

    // Rutas para la manipulación de eventos
    Route::post('/events/create', [EventController::class, 'store'])->name('events.store');
    Route::post('/events/update', [EventController::class, 'update'])->name('events.update');
    Route::get('/events/delete/{id}', [EventController::class, 'destroy'])->name('events.delete');

    // Ruta para verificar disponibilidad
    Route::get('/check-disponibilidad', [EventController::class, 'checkDisponibilidad'])->name('check-disponibilidad');
});
