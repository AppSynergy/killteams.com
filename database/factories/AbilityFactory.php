<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Ability::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->realText(144),
    ];
});
