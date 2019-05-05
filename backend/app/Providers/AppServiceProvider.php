<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('attribute_keys', function ($attribute, $value, $parameters, $validator) {
            $attributes = array_keys($value);
            sort($parameters);
            sort($attributes);
            return $attributes === $parameters;
        });
    }
}
