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

Route::get('/', ['as'=>'home', function () {
    return view('welcome');
}]);

Route::prefix('feedings')->name('feedings.')->group(function () {
    Route::get('index', ['as' => 'home', 'uses' => 'FeedingsController@index']);
    Route::get('overview', ['as' => 'overview', 'uses' => 'FeedingsController@index']);
    Route::get('submit', ['as' => 'submit', 'uses' => 'FeedingsController@create']);
    Route::post('submit', ['as' => 'submit', 'uses' => 'FeedingsController@store']);
});

Route::get('foods', ['as' => 'foods', 'uses' => 'FoodsController']);
