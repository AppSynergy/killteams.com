<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Specialism::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});
