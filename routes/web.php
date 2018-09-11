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

Route::get('/',
    [
    	'middleware'=>["auth"],
        'as' 	=>'user_list',
        'uses'	=>'HomeController@index'
    ]
);

Route::put('/user/like',
    [
        'as' 	=>'user_like',
        'uses'	=>'LikeController@user_like'
    ]
);

Route::put('/notification/seen',
    [
        'as' 	=>'notification_seen',
        'uses'	=>'NotificationController@notification_seen'
    ]
);



Auth::routes();
