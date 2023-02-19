<?php

use App\Http\Controllers\api\FavoritesController;
use App\Http\Controllers\api\UsersController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => ['fileExists', 'userExists','validateToken']
], function () {

    Route::prefix('users')->group(function () {
        Route::post('insert', [UsersController::class, 'insert']);
        Route::post('login', [UsersController::class, 'login'])->withoutMiddleware(['userExists']);
    });

    Route::prefix('items')->group(function () {
    Route::post('search', [FavoritesController::class, 'searchItems'])->withoutMiddleware('userExists');
    Route::post('insert',[FavoritesController::class,'insert'])->withoutMiddleware('userExists')->middleware('checkAdmin');
    });
});




