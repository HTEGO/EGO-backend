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

Route::get('/', 'WelcomeController@index');
/*Route::middleware(['cors'])->group(function(){

	Route::get('bestYouthPlayer', 'BestYouthPlayerController@listBestYouthPlayers');

});*/

Route::get('bestYouthPlayer',
[
  //  'middleware' => 'cors',
    'uses' => 'BestYouthPlayerController@listBestYouthPlayers'
]);

Route::get('YouthList/add',
[
   // 'middleware' => 'cors',
    'uses' => 'YouthListController@add'
]);

Route::get('YouthList/list',
[
   // 'middleware' => 'cors',
    'uses' => 'YouthListController@youthList'
]);

Route::get('YouthList/remove',
[
  //  'middleware' => 'cors',
    'uses' => 'YouthListController@remove'
]);
