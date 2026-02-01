<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ComplaintsController;

Route::get('/complaint/branches', [ComplaintsController::class, 'getBranchesDetails']);
Route::post('/complaint/register', [ComplaintsController::class, 'register']);
Route::get('/track-complaint/{trackingID}', [ComplaintsController::class, 'trackComplaint']);
Route::get('/track-cnic/{cnic}', [ComplaintsController::class, 'trackCnic']);
Route::get('/complaint/figures', [ComplaintsController::class, 'figures']);
//Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);

Route::middleware('auth:sanctum')->prefix('admin')->group(function () {
    Route::resource('users', \App\Http\Controllers\API\UserController::class);
    Route::put('user/status/{id}', [\App\Http\Controllers\API\UserController::class, 'status']);
});
