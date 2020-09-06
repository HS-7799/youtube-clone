<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Channel;
use App\User;
use Faker\Generator as Faker;

$factory->define(Channel::class, function (Faker $faker) {

    return [
        'user_id' => Factory(User::class)->create(),
        'name' => $faker->word,
        'description' => $faker->paragraph
    ];
});
