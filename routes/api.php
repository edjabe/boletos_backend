<?php

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

Route::post('login', 'AuthController@login');
Route::post('register', 'AuthController@register');

Route::group(['middleware' => ['jwt.auth']], function () {
    Route::prefix('user')->group(function () {
        Route::post('refresh', 'AuthController@refresh');
        Route::post('logout', 'AuthController@logout');
        Route::get('user-profile', 'AuthController@userProfile');
    });

    Route::prefix('reservations')->group(function () {
        Route::get('/', 'ReservationController@index');
        Route::get('/{user_id}', 'ReservationController@userReservation');
        Route::post('/register', 'ReservationController@register');
    });

    Route::prefix('tickets')->group(function () {
        Route::get('/', 'TicketController@index');
    });
});
