<?php

use Faker\Generator as Faker;
use App\Models\User as User;

$factory->define(User::class, function (Faker $faker) {
    return [
				'first_name' => $faker->firstName,
				'last_name'  => $faker->lastName,
				'email'      => $faker->unique()->safeEmail,
				'password'   => $faker->password,
				'api_token'  => str_random(60)
    ];
});
