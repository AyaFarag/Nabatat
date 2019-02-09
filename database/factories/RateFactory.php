<?php

use Faker\Generator as Faker;
use App\Models\Rate as Rate;
use App\Models\User as User;
use App\Models\Product as Product;

$factory->define(Rate::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            if (User::count() < 1) {
                return factory(User::class)->create()->id;
            } else {
                return User::inRandomOrder()->first()->id;
            }
        },
        'product_id' => function () {
            if (Product::count() < 1) {
                return factory(Product::class)->create()->id;
            } else {
                return Product::inRandomOrder()->first()->id;
            }
        },
        'rate' => $faker->randomDigit,
        'comment' => $faker->text,
    ];
});
