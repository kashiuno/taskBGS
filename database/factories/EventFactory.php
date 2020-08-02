<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Event;
use Faker\Generator as Faker;

$factory->define(Event::class, function (Faker $faker) {
    return [
        'title' => $faker->unique()->company,
        'date_start' => $faker->date(),
        'city' => $faker->city,
    ];
});
