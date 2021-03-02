<?php

namespace App\Http\Controllers\Api\v2;

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


Route::prefix('v2')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::get('', [AuthController::class, 'index'])->middleware('auth:sanctum');
        Route::post('signup', [AuthController::class, 'signup']);
        Route::post('login', [AuthController::class, 'login']);
    });
    Route::middleware('auth:sanctum')->group(function () {
        Route::prefix('users')->group(function () {
            Route::get('{id}', [UserController::class, 'show']);
            Route::put('{id}', [UserController::class, 'update']);
            Route::delete('{id}', [UserController::class, 'destroy']);
            Route::get('{id}/connections', [UserController::class, 'connections']);
            Route::get('{id}/events', [UserController::class, 'events']);
        });
        Route::prefix('events')->group(function () {
            Route::get('', [EventController::class, 'index']);
            Route::post('', [EventController::class, 'store']);
            Route::get('{id}', [EventController::class, 'show']);
            Route::put('{id}', [EventController::class, 'update']);
            Route::delete('{id}', [EventController::class, 'destroy']);
            Route::get('{id}/connections', [EventController::class, 'connections']);
            Route::get('{id}/comments', [EventController::class, 'comments']);
        });
        Route::prefix('connections')->group(function () {
            Route::post('', [ConnectionController::class, 'store']);
            Route::delete('{id}', [ConnectionController::class, 'destroy']);
        });
        Route::prefix('comments')->group(function () {
            Route::post('', [CommentController::class, 'store']);
            Route::delete('{id}', [CommentController::class, 'destroy']);
        });
    });
});
