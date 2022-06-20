<?php

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
Route::get('/return-error', function () {
    return response()->json(['message' => 'error message'], 500);
});
Route::get('/', function () {
    return view('rendered_by_frontend', ['apmCurrentTransaction' => Elastic\Apm\ElasticApm::getCurrentTransaction()]);
});
Route::get('/dashboard', function () {
    return view('rendered_by_frontend', ['apmCurrentTransaction' => Elastic\Apm\ElasticApm::getCurrentTransaction()]);
});
Route::get('/products', function () {
    return view('rendered_by_frontend', ['apmCurrentTransaction' => Elastic\Apm\ElasticApm::getCurrentTransaction()]);
});
Route::get('/orders', function () {
    return view('rendered_by_frontend', ['apmCurrentTransaction' => Elastic\Apm\ElasticApm::getCurrentTransaction()]);
});
Route::get('/orders/{orderId}', function () {
    return view('rendered_by_frontend', ['apmCurrentTransaction' => Elastic\Apm\ElasticApm::getCurrentTransaction()]);
});
Route::get('/customers', function () {
    return view('rendered_by_frontend', ['apmCurrentTransaction' => Elastic\Apm\ElasticApm::getCurrentTransaction()]);
});
Route::get('/customers/{customerId}', function () {
    return view('rendered_by_frontend', ['apmCurrentTransaction' => Elastic\Apm\ElasticApm::getCurrentTransaction()]);
});
Route::get('/products/{id}', function () {
    return view('rendered_by_frontend', ['apmCurrentTransaction' => Elastic\Apm\ElasticApm::getCurrentTransaction()]);
});
