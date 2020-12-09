<?php
    /** Users route */
    Route::get('users', 'UserController@index');
    Route::post('users', 'UserController@store');
    Route::put('users/{id}', 'UserController@update');

    /** Posters route */
    Route::get('posters', 'PosterController@index');
    Route::post('posters', ['uses' => 'PosterController@store']);
    Route::get('posters/{id}', ['uses' => 'PosterController@show']);
    Route::put('posters/{id}', ['uses' => 'PosterController@update']);
    