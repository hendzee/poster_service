<?php
    /** Users route */
    Route::get('users', 'UserController@index');
    Route::post('users', 'UserController@store');
    Route::put('users/{id}', 'UserController@update');

    /** Posters route */
    Route::get('posters', 'PosterController@index');