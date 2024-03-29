<?php

use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MovieController;
use Illuminate\Http\Request;
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

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);

Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::get('/movies', [MovieController::class, 'list']);
    Route::post('/verify', [MovieController::class, 'verifyRequirement']);
    Route::post('/create-history', [MovieController::class, 'CreateHistory']);
    Route::post('/list-history', [MovieController::class, 'ListHistory']);
});

