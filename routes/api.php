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

Route::middleware(['cors'])->group(function () {

  Route::get('bestYouthPlayer',
  [
      'uses' => 'BestYouthPlayerController@listBestYouthPlayers'
  ]);

  Route::get('YouthList/add',
  [
      'uses' => 'YouthListController@add'
  ]);

  Route::get('YouthList/list',
  [
      'uses' => 'YouthListController@youthList'
  ]);
  Route::get('YouthList/blacklist',
  [
      'uses' => 'YouthListController@youthBlacklist'
  ]);

  Route::get('YouthList/remove',
  [
      'uses' => 'YouthListController@remove'
  ]);
});
