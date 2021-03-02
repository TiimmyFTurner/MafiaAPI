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
// use Illuminate\Http\Request;
// use App\Http\Controllers\Api\v1\AuthController as AuthController1;
// use App\Http\Controllers\Api\v1\CommentController as CommentController1;
// use App\Http\Controllers\Api\v1\Event as EventController1;
// use App\Http\Controllers\Api\v1\Connection as ConnectionController1;
// use App\Http\Controllers\Api\v1\User as UserController1;

// Route::group(['prefix' => 'v1'], function () {
//     Route::post('register', [AuthController1::class, 'register']);
//     Route::post('login', [AuthController1::class, 'login']);
//     Route::middleware('auth:sanctum')->group(function () {
//         Route::apiResources([
//             'event' => EventController1::class,
//             'connection' => ConnectionController1::class,
//             'user' => UserController1::class,
//             'comment' => CommentController1::class
//         ]);
//     });
// });

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
