<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ComplaintsController;


Route::get('/complaint/branches', [ComplaintsController::class, 'getBranchesDetails'])->name('branches.details');
Route::post('/complaint/register', [ComplaintsController::class, 'register'])->name('complaints.register');
Route::get('/track-complaint/{trackingID}', [ComplaintsController::class, 'trackComplaint'])->name('complaint.trackComplaint');
Route::get('/track-cnic/{cnic}', [ComplaintsController::class, 'trackCnic'])->name('complaint.trackCnic');
Route::get('/complaint/figures', [ComplaintsController::class, 'figures'])->name('complaint.figures');
Route::post('/login', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'login']);
Route::post('/logout', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'logout']);
Route::group( ['middleware' => ['auth:sanctum'], 'as' => 'admin.', 'prefix' => 'admin'],  function () {
    //Users
    Route::resource('users', \App\Http\Controllers\API\UserController::class)->names('users');
    Route::put('user/status/{id}', [App\Http\Controllers\API\UserController::class, 'status'])->name('users.status');
});
