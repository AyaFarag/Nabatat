<?php

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = factory(\App\Models\Product::class, 100) -> create();


        foreach ($products as $product) {
        	if (mt_rand(0, 10) > 7) {
        		$product -> offer() -> create(factory(\App\Models\Offer::class) -> make(["product_id" => $product -> id]) -> toArray());
        	}
        }
    }
}
