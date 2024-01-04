<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\UserController;



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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::controller(LoginController::class)->group(function () {
            Route::delete('/logout', 'logout');
        });
    });
  
    Route::prefix('user')->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::post('/', 'store');
            Route::get('/', 'index');
            Route::post('/datatable', 'datatable');
            
        });
    });
});