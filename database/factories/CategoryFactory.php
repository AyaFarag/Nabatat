<?php

use Faker\Generator as Faker;
use App\Models\Category as Category;

$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => $faker -> name,
        
    ];
});
