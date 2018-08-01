<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Faction::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});
