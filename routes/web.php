<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', function () {
    return view('welcome');
});
Route::get('/products', function () {
    return view('welcome');
});
Route::get('/orders', function () {
    return view('welcome');
});
Route::get('/customers', function () {
    return view('welcome');
});
Route::get('/products/{id}', function () {
    return view('welcome');
});
Route::redirect('/*', '/');
Route::get('/return-error', function () {
    return response()->json(['message' => 'error message'], 500);
});
