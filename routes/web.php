<?php

use Illuminate\Support\Facades\Route;

Route::post('/login', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'login'])->middleware('guest');

require __DIR__.'/auth.php';
