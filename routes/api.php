<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ComplaintsController;


Route::get('/complaint/branches', [ComplaintsController::class, 'getBranchesDetails'])->name('branches.details');
Route::post('/complaint/register', [ComplaintsController::class, 'register'])->name('complaints.register');
Route::get('/track-complaint/{trackingID}', [ComplaintsController::class, 'trackComplaint'])->name('complaint.trackComplaint');
Route::get('/track-cnic/{cnic}', [ComplaintsController::class, 'trackCnic'])->name('complaint.trackCnic');
