<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Datasheet::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});
