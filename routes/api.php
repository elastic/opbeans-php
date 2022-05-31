<?php

use App\Http\Controllers\Api\CustomersController;
use App\Http\Controllers\Api\OrdersController;
use App\Http\Controllers\Api\ProductsController;
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
Route::group(['prefix' => 'products'], function () {
    Route::get('/', [ProductsController::class, 'products']);
    Route::get('/top', [ProductsController::class, 'top']);
    Route::get('/{productId}', [ProductsController::class, 'product']);
    Route::get('/{productId}/customers', [ProductsController::class, 'customers']);
});

Route::group(['prefix' => 'customers'], function () {
    Route::get('/', [CustomersController::class, 'customers']);
    Route::get('/{customerId}', [CustomersController::class, 'customer']);
});

Route::group(['prefix' => 'orders'], function () {
    Route::get('/', [OrdersController::class, 'orders']);
    Route::get('/{orderId}', [OrdersController::class, 'order']);
});

Route::get('/stats', [CustomersController::class, 'stats']);
