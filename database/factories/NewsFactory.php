<?php

use Faker\Generator as Faker;

$factory->define(App\Models\News::class, function (Faker $faker) {

    $title = $faker->sentence(6 );

    return [
        'title' => $title,
        'img_title' => $faker->image('storage/app/public/images', 1100, 550, 'business', false),
        'slug' => str_slug($title),
        'body' => $faker->text(4000 ),
        'analytical' => $faker->randomElement([true, false]),
        'category_id' => $faker->randomElement([1, 2, 3, 4]),
        'user_id' => $faker->randomElement([1, 2, 3]),
        'block_side' => $block_side,
        'block_position' => $block_position
    ];
});
