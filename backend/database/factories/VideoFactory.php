<?php

use App\Models\Video;
use App\Models\PlayList;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/**
 * PlayList factory.
 */
$factory->define(Video::class, function (Faker $faker, array $attributes) {
    return [
        'video_id' => $faker->name,
        'play_list_id' => $attributes['play_list_id'] ?? factory(PlayList::class)->create()->id,
    ];
});
