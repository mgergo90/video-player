<?php

use App\Models\User;
use App\Models\PlayList;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/**
 * PlayList factory.
 */
$factory->define(PlayList::class, function (Faker $faker, array $attributes) {
    return [
        'name' => $faker->name,
        'user_id' => $attributes['user_id'] ?? factory(User::class)->create()->id,
    ];
});
