<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/retrofit', 'RetrofitController@getRetrofit');
Route::post('/auth','AuthController@Auth');

Route::get('/stadium/all/{id}/{type}', 'StadiumController@getAll');
Route::get('/stadium/{id}/{type}', 'StadiumController@getStadiumDetail');

Route::post('/reserve', 'ReserveController@Reserve');
Route::post('/prereserve', 'ReserveController@preReserve');
Route::post('/myreserve', 'ReserveController@getMyReserve');
Route::get('/prereserve', 'ReserveController@testMyReserve');

Route::get('/test', 'ReserveController@getAllField');

Route::post('/quickmatch', 'QuickController@getQuickMatch');
Route::post('/quickmatch/join', 'QuickController@joinQuickMatch');

Route::post('/friendplay', 'PlayFriendController@getMatch');