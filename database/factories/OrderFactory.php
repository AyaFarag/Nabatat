<?php

use Faker\Generator as Faker;
use App\Models\Order as Order;
use App\Models\User as User;
use App\Models\Address as Address;
use App\Models\Payment as Payment;
use App\Models\Delivery as Delivery;

$factory->define(Order::class, function (Faker $faker) {
    return [
        "user_id" => function () {
            if (User::count() < 1) {
                return factory(User::class)->create()->id;
            } else {
                return User::inRandomOrder()->first()->id;
            }
        },
        "address_id" => function () {
            if (Address::count() < 1) {
                return factory(Address::class)->create()->id;
            } else {
                return Address::inRandomOrder()->first()->id;
            }
        },
        "delivery_id" => null,
        "shipping_cost" => $faker->randomNumber(2),
        "status" => mt_rand(0, 4),
        "code" => $faker->randomNumber(5),
        
    ];
});
