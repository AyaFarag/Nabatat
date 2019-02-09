<?php

use Faker\Generator as Faker;
use App\Models\Page as Page;

$factory->define(Page::class, function (Faker $faker) {
    return [
        'title' => $faker->name,
        'content' => $faker->text
    ];
});
