<?php

use App\Http\Controllers\api\UsersController;
use Illuminate\Support\Facades\Route;

Route::middleware(['fileExists','userExists'])->group(function () {

    Route::post('register', [UsersController::class, 'createUser']);
    Route::post('login', [UsersController::class, 'loginUser']);
    Route::post('search', [UsersController::class, 'searchItems']);

});




