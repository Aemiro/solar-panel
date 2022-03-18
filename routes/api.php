<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\SolarPanelController;
use App\Http\Controllers\AuthController;



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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::group([
    'middleware' => 'api'
], function ($router) {

//

Route::group(['middleware' => ['jwt.verify']], function() {
    Route::post('auth/login', [AuthController::class, 'login']);
    Route::post('auth/register', [AuthController::class, 'register']);
    Route::get('auth/logout', [AuthController::class, 'logout']);
    Route::get('auth/profile', [AuthController::class, 'userProfile']);
    Route::get('auth/refresh', [AuthController::class, 'refresh']);

    Route::get('categories', [CategoriesController::class, 'index']);
    Route::POST('categories/create', [CategoriesController::class, 'create']);
    Route::get('categories/get-category/{id}', [CategoriesController::class, 'show']);
    Route::put('categories/update-category/{id}', [CategoriesController::class, 'update']);
    Route::delete('categories/delete-category/{id}', [CategoriesController::class, 'delete']);

    Route::get('solar-panel', [SolarPanelController::class, 'index']);
    Route::POST('solar-panel/create', [SolarPanelController::class, 'create']);
    Route::get('solar-panel/get-solar-panel/{id}', [SolarPanelController::class, 'show']);
    Route::put('solar-panel/update-solar-panel/{id}', [SolarPanelController::class, 'update']);
    Route::delete('solar-panel/delete-solar-panel/{id}', [SolarPanelController::class, 'delete']);
});

});

