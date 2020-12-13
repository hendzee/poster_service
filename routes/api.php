<?php
    /** Users route */
    Route::get('users', ['uses' => 'UserController@index']); // Get user
    Route::get('users/posters', ['uses' => 'UserController@getUserPoster']); // Get user's poster
    Route::get('users/subscriptions', ['uses' => 'UserController@getUserSubscription']); // Get user's subscription
    Route::post('users', ['uses' => 'UserController@store']); // Store new user
    Route::put('users/{id}', ['uses' => 'UserController@update']); // Update user by id

    /** Posters route */
    Route::get('posters', ['uses' => 'PosterController@index']); // Get poster
    Route::get('posters/trending', ['uses' => 'PosterController@getTrendingPoster']); // Get trending poster
    Route::get('posters/recommendation', ['uses' => 'PosterController@getRecommendationPoster']); // Get recommendation poster
    Route::post('posters', ['uses' => 'PosterController@store']); // Store new poster
    Route::get('posters/{id}', ['uses' => 'PosterController@show']); // Show detail poster
    Route::put('posters/{id}', ['uses' => 'PosterController@update']); // Update poster by id
    Route::delete('posters/{id}', ['uses' => 'PosterController@destroy']); // Delete poster by id
    