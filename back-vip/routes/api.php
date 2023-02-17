<?php

use App\Http\Controllers\api\UsersController;
use Illuminate\Support\Facades\Route;

Route::middleware(['fileExists','userExists','userToken'])->group(function () {

    Route::post('register', [UsersController::class, 'addUser'])->withoutMiddleware('userToken');
    Route::post('login', [UsersController::class, 'loginUser'])->withoutMiddleware(['userExists','userToken']);
    Route::post('search', [UsersController::class, 'searchItems'])->withoutMiddleware('userExists')->middleware('checkAdmin');

});




