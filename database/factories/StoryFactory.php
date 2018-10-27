<?php

use App\Story;
use Faker\Generator as Faker;

$factory->define(Story::class, function (Faker $faker) {
    return [
        'label'       => $faker->sentence(10, true),
        'description' => $faker->paragraphs(3, true),
    ];
});