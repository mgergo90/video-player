<?php

use Illuminate\Http\Request;

Route::namespace('YoutubeApi')
    ->middleware(['api'])
    ->prefix('youtube')
    ->group(function () {
        Route::get('search', 'YoutubeApiController@search');
    });

Route::namespace('User')
    ->middleware(['api'])
    ->prefix('user')
    ->group(function () {
        Route::resource('user', 'UserController')
            ->only(['store', 'show']);
    });

Route::namespace('Auth')
    ->middleware(['api'])
    ->prefix('auth')
    ->name('auth.')
    ->group(function () {
        Route::post('login', 'AuthController@login')->name('login');
        Route::post('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');
        Route::post('me', 'AuthController@me');
    });
