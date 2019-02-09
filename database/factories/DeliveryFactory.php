<?php
use App\Models\Delivery as Delivery;
use Faker\Generator as Faker;

$factory->define(Delivery::class, function (Faker $faker) {
    return [
        "name" => $faker->name,
        "phone" => $faker->phoneNumber,
        "nationalId" => $faker->randomNumber,
        "image" => $faker->image,
    ];
});
