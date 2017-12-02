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

Route::get('/', function () {
    return view('welcome');
});


Route::get('bestYouthPlayer',
[
   'middleware' => 'cors',
    'uses' => 'BestYouthPlayerController@listBestYouthPlayers'
]);

Route::get('YouthList/add',
[
   'middleware' => 'cors',
    'uses' => 'YouthListController@add'
]);

Route::get('YouthList/list',
[
    'uses' => 'YouthListController@youthList'
    'middleware' => 'cors',
]);

Route::get('YouthList/remove',
[
   'middleware' => 'cors',
    'uses' => 'YouthListController@remove'
]);
