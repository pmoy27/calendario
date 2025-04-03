<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\RoutingController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth.php';

Route::group(['prefix' => '/', 'middleware' => 'auth'], function () {
    Route::get('', [RoutingController::class, 'index'])->name('root');
    Route::get('/check-disponibilidad', [EventController::class, 'checkDisponibilidad'])->name('check-disponibilidad');
    Route::post('/events/create', [EventController::class, 'store'])->name('events.store');


    Route::get('{first}/{second}/{third}', [RoutingController::class, 'thirdLevel'])->name('third');
    Route::get('{first}/{second}', [RoutingController::class, 'secondLevel'])->name('second');
    Route::get('{any}', [RoutingController::class, 'root'])
        ->where('any', '(?!check-disponibilidad|events)[A-Za-z0-9\-\_\/]+')
        ->name('any');
});
