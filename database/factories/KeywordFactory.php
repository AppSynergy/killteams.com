<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Keyword::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
    ];
});
