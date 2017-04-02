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

Route::get('/social-auth/{social_provider}', [
    'as' => 'social-auth',
    'uses' => 'Auth\AuthController@redirectToProvider'
]);

Route::get('/social-auth/{social_provider}/callback', [
    'as' => 'social-auth-callback',
    'uses' => 'Auth\AuthController@handleProviderCallback'
]);

Route::group([
    'namespace' => 'Account',
    'middleware' => 'auth'
], function() {
    Route::get('/account/info', 'InfoController@index');
    Route::post('/account/info', 'InfoController@save');

    Route::group([
        'prefix' => '/organise',
        'as' => 'organise::'
    ], function () {
        Route::get('/activities', 'OrganiseController@index')->name('activities');
        Route::get('/activity/new', 'OrganiseController@edit')->name('new-activity');
        Route::get('/activity/edit/{activity}', 'OrganiseController@edit')->name('activity');

        Route::post('/activity/save', 'OrganiseController@create')->name('new-activity::save');
        Route::put('/activity/save/{activity}', 'OrganiseController@update')->name('activity::save');
    });

    Route::get('/participate/activities', 'ParticipateController@index');
    Route::get('/participate/activities/{activity}/info/{serial_number}', 'ParticipateController@info');
    Route::put('/participate/activities/{activity}/cancel/{serial_number}', 'ParticipateController@cancel');
});

Route::get('/activities', 'ActivityController@index');
Route::get('/activity/{activity}', 'ActivityController@info');

Route::get('/organizers', 'OrganizerController@index');
Route::get('/organizer/{organizer}', 'OrganizerController@info');

Route::group([
    'prefix' => '/sign-up/{activity}',
    'namespace' => 'SignUp'
    // 'middleware' => 'auth',
], function () {
    Route::get('/fill-apply-form/{serial_number?}', 'StepController@showApplyForm');
    Route::get('/payment', 'StepController@showPayment')->name('payment');
    Route::get('/confirm', 'StepController@showConfirm')->name('confirm');

    Route::post('/fill-apply-form', 'ActionController@postApplyForm');
    Route::put('/fill-apply-form/{serial_number}', 'ActionController@putApplyForm');
    Route::post('/payment/{serial_number}', 'ActionController@postTransaction');
    Route::post('/payment-info', 'ActionController@savePaymentInfo');
    Route::post('/payment', 'ActionController@savePaymentResult');
});


