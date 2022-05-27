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
    Route::get('/{product}', [ProductsController::class, 'product']);
});

Route::get('/stats', [CustomersController::class, 'stats']);
Route::get('/orders', [OrdersController::class, 'orders']);

//Route::get('/products/top', [ProductsController::class, 'top']);
//Route::get('/products', [ProductsController::class, 'products']);
//Route::get('/products/{product}', [ProductsController::class, 'product']);
