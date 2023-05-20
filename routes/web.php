<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlaceApiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    // phpinfo();
    return view('welcome');
});

Route::prefix('api')->group(function () {
    Route::prefix('v0.1')->group(function () {
        Route::post('/place', [PlaceApiController::class, 'store']);
    });
});
