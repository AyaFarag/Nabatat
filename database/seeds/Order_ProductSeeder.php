<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Order as Order;
use App\Models\Product as Product;

class Order_ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(0, 50) as $i) {
            $randomProduct = Product::inRandomOrder() -> first();
            $randomOrder   = Order::inRandomOrder() -> first();
            $product = [
                'order_id' => $randomOrder -> id,
                'product_id' => $randomProduct -> id,
                'quantity' => mt_rand(1, 50),
                'price' => $randomProduct -> price,
                'regular_price' => $randomProduct -> discounted_price
            ];
            DB::table('order_products')->insert($product);
        }


    }
}
