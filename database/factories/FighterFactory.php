<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Fighter::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'killteam_id' => $faker->numberBetween(1, 5),
        'specialism_id' => $faker->numberBetween(1, 10),
        'miniature_id' => $faker->numberBetween(1, 10),
    ];
});
