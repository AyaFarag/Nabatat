<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Visitor;
use App\Models\User;
use App\Models\Order;

use DB;

class StatisticsController extends Controller
{
    public function index() {
        $total_users  = Visitor::count();
        $total_visits = Visitor::selectRaw("sum(count) as total") -> first() -> total;
        $by_country   = Visitor::selectRaw("sum(count) as total, country")
            -> groupBy("country")
            -> get();
        $by_city   = Visitor::selectRaw("sum(count) as total, city")
            -> groupBy("city")
            -> get();

        $total_registered_users = User::count();

        $orders = [
            "pending"    => Order::where("status", Order::PENDING) -> count(),
            "confirmed"  => Order::where("status", Order::CONFIRMED) -> count(),
            "on_the_way" => Order::where("status", Order::ON_THE_WAY) -> count(),
            "returned"   => Order::where("status", Order::RETURNED) -> count(),
            "delivered"  => Order::where("status", Order::DELIVERED) -> count(),
        ];

        $total_earned_money = Order::earnings() -> first() -> total;


        $data = compact(
            "total_users",
            "total_visits",
            "by_country",
            "by_city",
            "total_registered_users",
            "orders",
            "total_earned_money"
        );
        return view("admin.statistics.index", $data);
    }
}
