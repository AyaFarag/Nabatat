<?php

use Faker\Generator as Faker;
use App\Models\Offer as Offer;
use App\Models\Product as Product;

$factory->define(Offer::class, function (Faker $faker) {
    return [
        "discount" => mt_rand(0, 100),
        'product_id' => function () {
            if (Product::count() < 1) {
                return factory(Product::class)->create()->id;
            } else {
                return Product::inRandomOrder()->first()->id;
            }
        },
        "ended_at" => $faker->dateTime,

    ];
});

