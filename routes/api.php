<?php

use App\Http\Controllers\LinkController;
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

Route::get('/transform', [LinkController::class, 'transform']);
Route::get('/redirect', [LinkController::class, 'redirect']);
Route::get('/clickcounter', [LinkController::class, 'getClickCounter']);
Route::get('/getall', [LinkController::class, 'getAll']);
