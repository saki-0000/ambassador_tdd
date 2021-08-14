<?php

use App\Http\Controllers\AmbassadorController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
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

if (!function_exists('common')) {
    function common(String $scope)
    {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/login', [AuthController::class, 'login']);
        Route::middleware(['auth:sanctum', $scope])->group(function () {
            Route::get('/user', [AuthController::class, 'user']);
            Route::get('/logout', [AuthController::class, 'logout']);
            Route::post('/users/info', [AuthController::class, 'updateInfo']);
            Route::post('/users/password', [AuthController::class, 'updatePassword']);
        });
    }
}

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('admin')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::middleware(['auth:sanctum', 'scope.admin'])->group(function () {
        Route::get('/user', [AuthController::class, 'user']);
        Route::get('/logout', [AuthController::class, 'logout']);
        Route::post('/users/info', [AuthController::class, 'updateInfo']);
        Route::post('/users/password', [AuthController::class, 'updatePassword']);

        Route::get('/users/{user}/links', [LinkController::class, 'index']);
        Route::get('/ambassadors', [AmbassadorController::class, 'index']);
        Route::get('/orders', [OrderController::class, 'index']);

        Route::apiResource('products', ProductController::class);
    });
});
Route::prefix('ambassador')->group(function () {
    common('scope.ambassador');
});
