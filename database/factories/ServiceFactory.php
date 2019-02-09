<?php

use Faker\Generator as Faker;
use App\Models\Service as Service;

$factory->define(Service::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'description' => $faker->text(100),
    ];
});
