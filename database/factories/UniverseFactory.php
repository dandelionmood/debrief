<?php

use Faker\Generator as Faker;

$factory->define(\App\Universe::class, function (Faker $faker) {
    return [
        'type'        => \App\Universe::TYPE_WIKI,
        'label'       => $faker->words(3, true),
        'description' => $faker->realText(500),
    ];
});
