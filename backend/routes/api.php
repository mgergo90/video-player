<?php

use Illuminate\Http\Request;

Route::middleware(['api'])
    ->group(function () {
        Route::namespace('YoutubeApi')
            ->prefix('youtube')
            ->group(function () {
                Route::get('search', 'YoutubeApiController@search');
            });

        Route::namespace('User')
            ->group(function () {
                Route::resource('user', 'UserController')
                    ->only(['store']);
            });

        Route::namespace('Auth')
            ->prefix('auth')
            ->name('auth.')
            ->group(function () {
                Route::post('login', 'AuthController@login')->name('login');
                Route::middleware(['jwt'])->group(function () {
                    Route::get('me', 'AuthController@getUser');
                    Route::middleware(['csrf'])->group(function () {
                        Route::get('logout', 'AuthController@logout');
                        Route::get('refresh', 'AuthController@refresh');
                    });
                });
            });


        Route::middleware(['jwt', 'csrf'])
            ->group(function () {

                Route::namespace('PlayList')->group(function () {
                    Route::resource('play-lists', 'PlayListController')
                        ->only(['store', 'update', 'index', 'destroy'])
                        ->parameters(['play-lists' => 'playList']);
                });

                Route::namespace('Video')->group(function () {
                    Route::resource('videos', 'VideoController')->only(['store', 'index', 'destroy']);
                });
            });
    });
