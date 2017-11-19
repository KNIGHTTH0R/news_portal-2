<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Advertisement::class, function (Faker $faker) {
    return [
        'text' => $faker->sentence(20),
        'sale_text' => $faker->sentence(20),
        'sale_title' => $faker->sentence(5),
        'seller' => $faker->catchPhrase(),
        'price' => $faker->numberBetween(500, 1000),
        'sale_price' => $faker->numberBetween(100, 400),
    ];
});
