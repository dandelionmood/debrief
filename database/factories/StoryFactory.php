<?php

use App\Story;
use Faker\Generator as Faker;

$factory->define(Story::class, function (Faker $faker) {
    $user_id = factory(\App\User::class)->create()->id;
    return [
        'label'                  => $faker->sentence(10, true),
        'description'            => $faker->paragraphs(3, true),
        'created_by_user_id'     => $user_id,
        'last_edited_by_user_id' => $user_id,
    ];
});

$factory->state(Story::class, 'diary_entry', function (Faker $faker) {
    return [
        'label' => $faker->date(),
    ];
});