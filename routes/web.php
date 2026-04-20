<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ComplaintsController;

Route::prefix('complaint')->group(function () {
    Route::get('/branches', [ComplaintsController::class, 'getBranchesDetails'])->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);
    Route::post('/register', [ComplaintsController::class, 'register'])->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);
    Route::get('/figures', [ComplaintsController::class, 'figures'])->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);
    Route::post('/feedback',[ComplaintsController::class, 'feedback'])->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);
    Route::get('/feedback-data',[ComplaintsController::class, 'feedbackData'])->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);
    Route::post('/update-remarks-user-staff', [\App\Http\Controllers\API\ComplaintsController::class, 'updateUserStaff'])->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

});

Route::get('/track-complaint/{trackingID}', [ComplaintsController::class, 'trackComplaint'])->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);
Route::get('/track-cnic/{cnic}', [ComplaintsController::class, 'trackCnic'])->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

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
    Route::get('/loggedUser', [\App\Http\Controllers\API\UserController::class, 'loggedUser']);
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
    Route::get('/dashboard/priorityComparison', [\App\Http\Controllers\API\DashboardController::class, 'priorityComplaints']);
    Route::get('/dashboard/statusComparison', [\App\Http\Controllers\API\DashboardController::class, 'statusComplaints']);
    Route::get('/dashboard/allStatusComparison', [\App\Http\Controllers\API\DashboardController::class, 'allStatusComplaints']);

    Route::get('/reports/{reportType}', [\App\Http\Controllers\API\HomeController::class, 'reports']);
});
//require __DIR__.'/auth.php';
