<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\apiController;

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

Route::get('/azapfy', [apiController::class, 'index']);
Route::get('/valor-nota', [apiController::class, 'readValorNota']);
Route::get('/valor-entregue', [apiController::class, 'readValorEntregue']);
Route::get('/valor-nao-entregue', [apiController::class, 'readValorNaoEntregue']);
Route::get('/valor-atraso', [apiController::class, 'readValorAtraso']);
