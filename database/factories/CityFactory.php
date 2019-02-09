<?php

use Faker\Generator as Faker;
use App\Models\City as City;
use App\Models\Country as Country;

$factory->define(City::class, function (Faker $faker) {
    return [
        "name" => $faker->city,
        'country_id' => function () {
            if (Country::count() < 1) {
                return factory(Country::class)->create()->id;
            } else {
                return Country::inRandomOrder()->first()->id;
            }
        },
        "shipping_cost" => $faker->randomNumber(2),
        "delivery_date" => $faker->date,

    ];
});
