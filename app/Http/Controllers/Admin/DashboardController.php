<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Order;
use App\Models\User;
use App\Models\ServiceRequest;

use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index() {
        $orderTypesData = [
            [
                "label" => "Pending",
                "data"  => Order::where("status", Order::PENDING) -> count(),
                "color" => "#FFFF00"
            ],
            [
                "label" => "Confirmed",
                "data"  => Order::where("status", Order::CONFIRMED) -> count(),
                "color" => "#0000FF"
            ],
            [
                "label" => "On The Way",
                "data"  => Order::where("status", Order::ON_THE_WAY) -> count(),
                "color" => "#add8e6"
            ],
            [
                "label" => "Returned",
                "data"  => Order::where("status", Order::RETURNED) -> count(),
                "color" => "#b22222"
            ],
            [
                "label" => "Delivered",
                "data"  => Order::where("status", Order::DELIVERED) -> count(),
                "color" => "#20da20"
            ]
        ];

        $today = Carbon::now() -> toDateString();

        $ordersCount = Order::where("created_at", ">=", $today) -> count();
        $earnings = Order::earnings()
            -> where("payment_date", ">=", $today)
            -> first()
            -> total;
        $registrationCount = User::where("created_at", $today) -> count();
        $serviceRequestsCount = ServiceRequest::where("created_at", $today) -> count();
        $specialUsers = User::selectRaw("orders.id, users.*, sum(total) as total")
            -> leftJoin("orders", "user_id", "=", "users.id")
            -> leftJoin("payment_detailes", "order_id", "=", "orders.id")
            -> whereNotNull("payment_date")
            -> groupBy("users.id")
            -> having("total", ">", "0")
            -> limit(15)
            -> get();
        $data = compact(
            "orderTypesData",
            "ordersCount",
            "earnings",
            "registrationCount",
            "serviceRequestsCount",
            "specialUsers"
        );

        return view("admin.dashboard", $data);
    }
}
