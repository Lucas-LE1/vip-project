<?php

use App\Http\Controllers\api\UsersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::middleware(\App\Http\Middleware\filesExists::class)->group(function () {

Route::prefix('register')->group(function () {
    Route::post('user', [UsersController::class, 'createUser']);
});


});




