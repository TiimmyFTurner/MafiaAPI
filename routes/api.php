<?php



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
use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\CommentController;
use App\Http\Controllers\Api\v1\Event as EventController;
use App\Http\Controllers\Api\v1\Connection as ConnectionController;
use App\Http\Controllers\Api\v1\User as UserController;
use Illuminate\Routing\RouteGroup;
use Illuminate\Support\Facades\Auth;




Route::group(['prefix' => 'v1'], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResources([
            'event' => EventController::class,
            'connection' => ConnectionController::class,
            'user' => UserController::class,
            'comment' => CommentController::class
        ]);
    });
});
