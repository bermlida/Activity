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

Route::get('/', 'IndexController@index');

Route::auth();

Route::get('/home', 'HomeController@index');

Route::group([
    'namespace' => 'Account',
    'middleware' => 'auth'
], function() {
    Route::get('/account/info', 'InfoController@index');
    Route::post('/account/info', 'InfoController@save');

    Route::get('/organise/activities', 'OrganiseController@index');
    Route::get('/organise/activity/{activity?}', 'OrganiseController@edit');
    Route::post('/organise/activity', 'OrganiseController@create');
    Route::put('/organise/activity', 'OrganiseController@update');
});

Route::get('/activities', 'ActivityController@index');
Route::get('/activity/{activity}', 'ActivityController@info');

Route::get('/organizers', 'OrganizerController@index');
Route::get('/organizer/{organizer}', 'OrganizerController@info');

Route::group([
    'prefix' => '/sign-up/{activity}',
    'namespace' => 'SignUp',
    'middleware' => 'auth'
], function () {
    Route::get('/fill-apply-form', 'StepController@showApplyForm');
});
