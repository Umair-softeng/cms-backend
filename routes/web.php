<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ComplaintsController;

Route::get('/complaint/branches', [ComplaintsController::class, 'getBranchesDetails']);
Route::post('/complaint/register', [ComplaintsController::class, 'register']);
Route::get('/track-complaint/{trackingID}', [ComplaintsController::class, 'trackComplaint']);
Route::get('/track-cnic/{cnic}', [ComplaintsController::class, 'trackCnic']);
Route::get('/complaint/figures', [ComplaintsController::class, 'figures']);
Route::post('/login', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth:sanctum');
Route::middleware('auth:sanctum')->prefix('admin')->group(function () {
    Route::get('/me', function () {
        return response()->json([
            'success' => auth()->check(),
        ]);
    });
    Route::resource('/users', \App\Http\Controllers\API\UserController::class);
    Route::put('user/status/{id}', [\App\Http\Controllers\API\UserController::class, 'status']);
    Route::get('user-card', [\App\Http\Controllers\API\UserController::class, 'cardData']);

    Route::resource('roles', \App\Http\Controllers\API\RoleController::class);
    Route::get('role-card', [\App\Http\Controllers\API\RoleController::class, 'roleCardData']);
    Route::get('get-modules', [\App\Http\Controllers\API\RoleController::class, 'getModules']);

    Route::get('/complaints', [App\Http\Controllers\API\ComplaintsController::class, 'getComplaints']);
    Route::post('/complaint/update-status', [\App\Http\Controllers\API\ComplaintsController::class, 'updateStatus'])->name('complaint.status');
    Route::post('/complaint/update-branch', [\App\Http\Controllers\API\ComplaintsController::class, 'updateBranch'])->name('complaint.branch');
    Route::delete('/complaint/{complaintID}', [\App\Http\Controllers\API\ComplaintsController::class, 'destroy']);

    Route::get('/dashboard/resolvedComparison', [\App\Http\Controllers\API\DashboardController::class, 'resolvedComparison']);


});
//require __DIR__.'/auth.php';
