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

Route::get('/', 'ComponentController@index');

Route::post('/components', 'ComponentController@store');
Route::patch('/components/{component}', 'ComponentController@update');
Route::delete('/components/{component}', 'ComponentController@destroy');
