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
    return view('index');
});

Route::auth();

Route::get('/home', 'HomeController@index');

Route::group([
    'prefix' => 'account',
    'namespace' => 'Account',
    'middleware' => 'auth'
], function() {
    Route::get('/info', 'InfoController@index');
    Route::post('/info', 'InfoController@save');

    Route::get('/organise/activities', 'OrganiseController@index');
    Route::get('/organise/activity', 'OrganiseController@edit');
    // Route::get('/organise/activities', 'OrganiseController@index');
});