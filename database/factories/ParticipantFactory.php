<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Event;
use App\Participant;
use Faker\Generator as Faker;

$factory->define(Participant::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'surname' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'event_id' => factory(Event::class),
    ];
});
