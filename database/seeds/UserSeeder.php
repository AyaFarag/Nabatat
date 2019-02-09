<?php

use Illuminate\Database\Seeder;

use Faker\Generator as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        $users = factory(\App\Models\User::class, 50) -> create();

        foreach ($users as $user) {
        	$phone = $faker -> e164PhoneNumber;
        	$user -> phones() -> create(["phone" => $phone]);
        	factory(\App\Models\Address::class) -> create([
				"first_name" => $user -> first_name,
				"last_name"  => $user -> last_name,
				"phone"      => $phone,
				"user_id"    => $user -> id
        	]);
        }
    }
}
