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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'auth', 'namespace' => 'Api'], function () {

    Route::post('register',     'AuthController@register');

    /* ------------------------ For Personal Access Token ----------------------- */
    Route::post('login',        'AuthController@login');
    /* -------------------------------------------------------------------------- */

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('logout',    'AuthController@logout');
        Route::get('user',      'AuthController@getUser');
    });

   /* ------------------------ For Password Grant Token ------------------------ */
    Route::post('login_grant',  'AuthController@loginGrant');
    Route::post('refresh',      'AuthController@refreshToken');
    /* -------------------------------------------------------------------------- */

    /* -------------------------------- Fallback -------------------------------- */
    Route::any('{segment}', function () {
        return response()->json([
            'error' => 'Invalid url.'
        ]);
    })->where('segment', '.*');
});

Route::get('unauthorized', function () {
    return response()->json([
        'error' => 'Unauthorized.'
    ], 401);
})->name('unauthorized');
