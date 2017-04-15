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

Route::get('/error', function () {
    return 'error';
});

Route::group([
    'as' => 'visit::'
], function () {
    Route::get('/activities', 'ActivityController@index')->name('activities');
    Route::get('/activities/{activity}', 'ActivityController@info')->name('activity');

    Route::get('/organizers', 'OrganizerController@index')->name('organizers');
    Route::get('/organizers/{organizer}', 'OrganizerController@info')->name('organizer');
});

Route::auth();

Route::group([
    'prefix' => '/social-auth/{social_provider}',
    'as' => 'social-auth::',
    'namespace' => 'Auth'
], function () {
    Route::get('/ask', 'AuthController@redirectToProvider')->name('ask');
    Route::get('/reply', 'AuthController@handleProviderCallback')->name('reply');
});

Route::group([
    'namespace' => 'Account',
    'middleware' => 'auth'
], function () {
    Route::group([
        'prefix' => '/account',
        'as' => 'account::'
    ], function () {
        Route::get('/setting', 'SettingController@index')->name('setting');
        Route::post('/setting', 'SettingController@save')->name('setting::save');
    
        Route::get('/info', 'InfoController@index')->name('info');
        Route::post('/info', 'InfoController@save')->name('info::save');
    });

    Route::group([
        'prefix' => '/organise/activities',
        'as' => 'organise::activity::',
        'middleware' => 'judge-role:2'
    ], function () {
        Route::get('/', 'OrganiseController@index')->name('list');
        Route::get('/new/edit', 'OrganiseController@edit')->name('create');
        Route::get('/{activity}/edit', 'OrganiseController@edit')->name('modify')->middleware('exist-resource');
        
        Route::post('/', 'OrganiseController@create')->name('store');
        Route::put('/{activity}', 'OrganiseController@update')->name('update');
    });

    Route::group([
        'prefix' => '/participate/records',
        'as' => 'participate::record::',
        'middleware' => 'judge-role:1'
    ], function () {
        Route::get('/', 'ParticipateController@index')->name('list');
        Route::get('/{serial_number}/view', 'ParticipateController@info')->name('view');

        Route::put('/{serial_number}/cancel', 'ParticipateController@cancel')->name('cancel');
    });
});

Route::group([
    'prefix' => '/sign-up/{activity}',
    'as' => 'sign-up::',
    'namespace' => 'SignUp'
], function () {
    Route::group([
        'prefix' => '/fill-apply-form',
        'as' => 'fill-apply-form::'
    ], function () {
        Route::get('/{serial_number?}', 'StepController@showApplyForm')->name('edit');

        Route::post('/', 'ActionController@postApplyForm')->name('store');
        Route::put('/{serial_number}', 'ActionController@putApplyForm')->name('update');
    });

    Route::group([
        'prefix' => '/payment',
        'as' => 'payment::'
    ], function () {
        Route::get('/', 'StepController@showPayment')->name('confirm');

        Route::post('/', 'ActionController@postTransaction')->name('deal');
        Route::post('/deal-info', 'ActionController@savePaymentInfo')->name('deal-info');
        Route::post('/deal-result', 'ActionController@savePaymentResult')->name('deal-result');
    });
    
    Route::get('/confirm', 'StepController@showConfirm')->name('confirm');
});


