<?php

use Illuminate\Support\Facades\Route;

//Route::group( ['middleware' => ['auth:sanctum'], 'as' => 'admin.', 'prefix' => 'admin'],  function () {
//
//    //Users
//    Route::resource('users', \App\Http\Controllers\API\UserController::class)->names('users');
//    Route::put('user/status/{id}', [App\Http\Controllers\API\UserController::class, 'status'])->name('users.status');
//});

    //Roles
//    Route::resource('roles', \App\Http\Controllers\Admin\RoleController::class)->names('roles');

//    //Chat
//    Route::get('chat/{userID}', [ChatController::class, 'index'])->name('chat');
//    Route::post('chat/sendMessage', [ChatController::class, 'sendMessage'])->name('chat.send');
//    Route::get('chat/messages/{contact}', [ChatController::class, 'messages'])->name('chat.messages'); // fetch messages
//    Route::get('chat/getMessages/{receiverId}', [ChatController::class, 'getMessages'])->name('chat.getMessages');
//    Route::post('/chat/clearMessages/{receiverId}', [\App\Http\Controllers\Admin\ChatController::class, 'clearMessages'])
//        ->name('chat.clearMessages');
//
//    //Complaints
//    Route::get('/all-user-complaints', [\App\Http\Controllers\Admin\ComplaintController::class, 'allUserComplaints'])->name('complaints.allUser');
//    Route::get('/all-complaints', [\App\Http\Controllers\Admin\ComplaintController::class, 'allComplaints'])->name('complaints.all');
//    Route::get('new-complaints', [\App\Http\Controllers\Admin\ComplaintController::class, 'newComplaints'])->name('complaints.new');
//    Route::get('progress-complaints', [\App\Http\Controllers\Admin\ComplaintController::class, 'progressComplaints'])->name('complaints.progress');
//    Route::get('resolved-complaints', [\App\Http\Controllers\Admin\ComplaintController::class, 'resolvedComplaints'])->name('complaints.resolved');
//    Route::get('dropped-complaints', [\App\Http\Controllers\Admin\ComplaintController::class, 'droppedComplaints'])->name('complaints.dropped');
//    Route::delete('/complaint/{complaint}', [\App\Http\Controllers\Admin\ComplaintController::class, 'destroy'])->name('complaint.destroy');
//    Route::post('/complaint/update-status', [\App\Http\Controllers\Admin\ComplaintController::class, 'updateStatus'])->name('complaint.status');
//    Route::post('/complaint/update-department', [\App\Http\Controllers\Admin\ComplaintController::class, 'departmentUpdate'])->name('complaint.department');
//    Route::get('/complaint/{complaint}', [\App\Http\Controllers\Admin\ComplaintController::class, 'show'])->name('complaint.show');



require __DIR__.'/auth.php';
