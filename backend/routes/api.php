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
    ->group(function () {
        Route::resource('user', 'UserController')
            ->only(['store']);
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

Route::namespace('PlayList')
    ->middleware(['api', 'jwt'])
    ->group(function () {
        Route::resource('play-lists', 'PlayListController')
            ->only(['store', 'update', 'index', 'destroy'])
            ->parameters(['play-lists' => 'playList']);
    });

Route::namespace('Video')
    ->middleware(['api', 'jwt'])
    ->group(function () {
        Route::resource('videos', 'VideoController')
            ->only(['store', 'index', 'destroy']);
    });
