<?php

use App\Http\Controllers\API\AlbumController;
use App\Http\Controllers\API\ArtistController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/signup', [AuthController::class, 'signUp']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/dashboard', DashboardController::class);

    Route::controller(AlbumController::class)->group(function () {
        Route::get('/albums', 'index');
        Route::post('/albums', 'store');
        Route::get('/albums/{album}', 'show');
        Route::put('/albums/{album}', 'update');
        Route::delete('/albums/{album}', 'destroy');
    });

    Route::controller(ArtistController::class)->group(function () {
        Route::get('/artists', 'index');
        Route::post('/artists', 'store');
        Route::get('/artists/{artist}', 'show');
        Route::put('/artists/{artist}', 'update');
        Route::delete('/artists/{artist}', 'destroy');
    });
});
