<?php

use App\Http\Controllers\api\FavoritesController;
use App\Http\Controllers\api\UsersController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => ['fileExists', 'userExists']
], function () {

    Route::post('register', [UsersController::class, 'register']);
    Route::post('login', [UsersController::class, 'login'])->withoutMiddleware(['userExists']);
    Route::post('search', [FavoritesController::class, 'searchItems'])->withoutMiddleware('userExists');

});




