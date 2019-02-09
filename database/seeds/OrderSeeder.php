<?php

use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orders = factory(\App\Models\Order::class, 20) -> create();

        foreach ($orders as $order) {
        	$order -> paymentDetailes() -> attach([1 => [
        		"total" => 500,
        	]]);
        }


    }
}
