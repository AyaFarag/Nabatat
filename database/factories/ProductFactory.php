<?php

use Faker\Generator as Faker;
use App\Models\Product as Product;
use App\Models\Category as Category;

$factory->define(Product::class, function (Faker $faker) {
    return [
        "name" => $faker->name,
        "price" => $faker->randomNumber(2),
        "description" => $faker->text,
        "quantity" => $faker->randomDigit,
        "height" => $faker->randomDigit,
        "width" => $faker->randomDigit,
        "category_id" => function () {
            if (Category::count() < 1) {
                return factory(Category::class)->create()->id;
            } else {
                return Category::whereNotNull("parent_id") -> inRandomOrder()->first()->id;
            }
        },
    ];
});
