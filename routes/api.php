<?php
    /** Users route */
    Route::get('users', ['uses' => 'UserController@index']);
    Route::post('users', ['uses' => 'UserController@store']);
    Route::put('users/{id}', ['uses' => 'UserController@update']);

    /** Posters route */
    Route::get('posters', ['uses' => 'PosterController@index']);
    Route::get('posters/trending', ['uses' => 'PosterController@getTrendingPoster']);
    Route::get('posters/recommendation', ['uses' => 'PosterController@getRecommendationPoster']);
    Route::post('posters', ['uses' => 'PosterController@store']);
    Route::get('posters/{id}', ['uses' => 'PosterController@show']);
    Route::put('posters/{id}', ['uses' => 'PosterController@update']);
    Route::delete('posters/{id}', ['uses' => 'PosterController@destroy']);
    