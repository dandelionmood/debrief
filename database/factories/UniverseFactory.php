<?php

use Faker\Generator as Faker;

$factory->define(\App\Universe::class, function (Faker $faker) {
    return [
        'type'        => \App\Universe::TYPE_WIKI,
        'label'       => $faker->words(3, true),
        'description' => $faker->realText(500),
    ];
});

$factory->state(\App\Universe::class, 'of_type_wiki', [
    'type' => \App\Universe::TYPE_WIKI,
]);
$factory->state(\App\Universe::class, 'of_type_diary', [
    'type' => \App\Universe::TYPE_DIARY,
]);