<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Video;
use Faker\Generator as Faker;

$factory->define(Video::class, function (Faker $faker) {
    return [
        'channel_id' => App\Channel::all()->random()->id,
        'percentage' => 100,
        'views' => $faker->numberBetween(10,2000),
        'thumbnail' => $faker->imageUrl(),
        'title' => $faker->sentence(4),
        'path' => $faker->word(),
        'description' => $faker->sentence(10)
    ];
});
