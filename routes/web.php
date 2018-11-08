<?php

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

// Authentication Routes

Auth::routes();

Route::get(
    'login/{provider}',
    'Auth\LoginController@redirectToProvider'
)
    ->name('login.provider');

Route::get(
    'login/{provider}/callback', 'Auth\LoginController@handleProviderCallback'
)
    ->name('login.provider.callback');


// Application Routes

Route::get(
    '/',
    'HomeController@index'
)
    ->name('home');

Route::get(
    'builder',
    'BuilderController@index'
)
    ->name('builder');
