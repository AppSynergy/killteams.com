<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Miniature::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'faction_id' => $faker->numberBetween(1, 10),
    ];
});
