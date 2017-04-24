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
    // var_dump(app('router'));
    return 'error';
});

Route::group([
    'as' => 'visit::'
], function () {
    Route::get('/activities', 'ActivityController@index')->name('activities');
    Route::get('/activities/{activity}', 'ActivityController@info')
        ->middleware('exist-activity')
        ->name('activity');

    Route::get('/organizers', 'OrganizerController@index')->name('organizers');
    Route::get('/organizers/{organizer}', 'OrganizerController@info')
        ->middleware('exist-organizer')
        ->name('organizer');
});

Route::auth();

Route::group([
    'prefix' => '/register',
    'namesapce' => 'Auth',
    'as' => 'register::'
], function () {
    Route::get('/user', 'AuthController@showRegisterUser')->name('user');
    Route::get('/organizer', 'AuthController@showRegisterOrganizer')->name('organizer');
    
    Route::post('/user', 'AuthController@registerUser')->name('user::store');
    Route::post('/organizer', 'AuthController@registerOrganizer')->name('organizer::store');
});


Route::group([
    'prefix' => '/social-auth/{social_provider}',
    'namespace' => 'Auth',
    'middleware' => 'verify-social-provider',
    'as' => 'social-auth::'
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
        'middleware' => 'judge-role:2',
        'as' => 'organise::activity::'
    ], function () {
        Route::get('/', 'OrganiseController@index')->name('list');
        
        Route::get('/new', 'OrganiseController@edit')->name('create');
        Route::post('/new', 'OrganiseController@create')->name('store');
        
        Route::group([
            'prefix' => '/{activity}',
            'middleware' => 'exist-organise-activity'
        ], function () {
            Route::get('/edit', 'OrganiseController@edit')->name('modify');
            Route::put('/update', 'OrganiseController@update')->name('update');
            Route::delete('/delete', 'OrganiseController@delete')->name('delete');

            Route::get('/applicants', 'OrganiseController@applicants')->name('applicants');
        });
    });

    Route::group([
        'prefix' => '/participate/records',
        'middleware' => 'judge-role:1',
        'as' => 'participate::record::'
    ], function () {
        Route::get('/', 'ParticipateController@index')->name('list');
        Route::get('/{record}/view', 'ParticipateController@info')
            ->middleware('exist-participate-record')
            ->name('view');

        Route::put('/{record}/cancel', 'ParticipateController@cancel')
            ->middleware('exist-participate-record')
            ->name('cancel');
    });
});

Route::group([
    'prefix' => '/sign-up/{activity}',
    'namespace' => 'SignUp',
    'middleware' => ['exist-activity'],
    'as' => 'sign-up::'
], function () {
    Route::group([
        'prefix' => '/apply',
        'as' => 'apply::'
    ], function () {
        Route::get('/', 'StepController@showApply')->name('new');
        Route::get('/{record}', 'StepController@showApply')
            ->middleware('exist-participate-record')
            ->name('edit');

        Route::post('/', 'ActionController@postOrder')->name('store');
        Route::put('/{record}', 'ActionController@putOrder')
            ->middleware('exist-participate-record')
            ->name('update');
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


