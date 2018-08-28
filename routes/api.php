<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('factions', 'Api\FactionController@index');
Route::get('factions/{id}', 'Api\FactionController@show');

Route::get('specialisms', 'Api\SpecialismController@index');

Route::post('killteam', 'Api\KillteamController@store');
Route::get('killteams', 'Api\KillteamController@index');
