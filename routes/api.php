<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\SolarPanelController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;

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

    Route::get('products', [ProductController::class, 'index']);
    Route::POST('products/create', [ProductController::class, 'create']);
    Route::get('products/get-product/{id}', [ProductController::class, 'show']);
    Route::put('products/update-product/{id}', [ProductController::class, 'update']);
    Route::delete('products/delete-product/{id}', [ProductController::class, 'delete']);
    Route::get('products/getProducts', [ProductController::class, 'getProducts']);

    Route::get('customers', [CustomerController::class, 'index']);
    Route::POST('customers/create', [CustomerController::class, 'create']);
    Route::get('customers/get-customer/{id}', [CustomerController::class, 'show']);
    Route::put('customers/update-customer/{id}', [CustomerController::class, 'update']);
    Route::delete('customers/delete-customer/{id}', [CustomerController::class, 'delete']);

    Route::get('orders', [OrderController::class, 'index']);
    Route::POST('orders/create', [OrderController::class, 'create']);
    Route::get('orders/get-order/{id}', [OrderController::class, 'show']);
    Route::put('orders/update-order/{id}', [OrderController::class, 'update']);
    Route::delete('orders/delete-order/{id}', [OrderController::class, 'delete']);

    Route::get('order-items', [OrderItemController::class, 'index']);
    Route::POST('order-items/create', [OrderItemController::class, 'create']);
    Route::get('order-items/get-order-item/{id}', [OrderItemController::class, 'show']);
    Route::put('order-items/update-order-item/{id}', [OrderItemController::class, 'update']);
    Route::delete('order-items/delete-order-item/{id}', [OrderItemController::class, 'delete']);

});

});

