<?php

namespace App\Http\Controllers\Admin;


use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\City;
use App\Excel\OrderExcel;
use App\Models\Delivery;
use App\Models\Product;
use Session;

class OrderController extends Controller
{
    private function applyFiltering(Request $request, $query) {
        if ($request -> filled("query"))
            $query -> search($request -> input("query"));
        if ($request -> has("status"))
            $query -> whereIn("status", $request -> input("status"));
        if ($request -> filled("minimum_products"))
            $query -> has("products", ">=", $request -> input("minimum_products"));
        if ($request -> filled("maximum_products"))
            $query -> has("products", "<=", $request -> input("maximum_products"));
        if ($request -> filled("city_id"))
            $query -> whereHas("address", function ($q) use ($request) { return $q -> where("city_id", $request -> input("city_id")); });
        if ($request -> filled("start_date"))
            $query -> where("orders.created_at", ">=", $request -> input("start_date"));
        if ($request -> filled("end_date"))
            $query -> where("orders.created_at", "<=", $request -> input("end_date"));
    }

    public function index(Request $request)
    {
        $this -> authorize("view", Order::class);

        $orders = Order::query();

        $this -> applyFiltering($request, $orders);

        $orders = $orders -> paginate();

        $cities = City::pluck("name", "id") -> all();

        return view("admin.order.index", compact("orders", "cities"));
    }

    public function report(Request $request) {
        $orders = Order::with("products", "address.city", "user", "paymentDetailes");

        $this -> applyFiltering($request, $orders);

        $report = new OrderExcel($orders -> get());
        return Excel::download($report, "orders.xlsx", \Maatwebsite\Excel\Excel::XLSX);
    }





    public function show(Order $order) {
        $this -> authorize("view", Order::class);
        $delivery = Delivery::pluck('name','id')->all();
        return view("admin.order.show", compact("order","delivery"));
    }




    public function changeStatus(Order $order, Request $request) {
        $this -> authorize("update", Order::class);

        $order -> status = $request -> status;
        $order -> save();

        Session::flash("success", "Order status was changed successfully!");
        return redirect() -> route("admin.order.show", ["order" => $order -> id]);
    }

    public function assignDelivery(Request $request, Order $order){
        
        $order->delivery_id = $request->delivery_id;
        $order->save();
        return back()->with('success','Delivery Added');
    }
    

    public function modifyProduct(Order $order, Request $request, $product) {
        $this -> authorize("update", Order::class);

        $order -> products() -> updateExistingPivot($product, ["quantity" => $request -> input("quantity")]);
        Session::flash("success", "Order product quantity was changed successfullly!");

        return redirect() -> route("admin.order.show", ["order" => $order -> id]);
    }

    public function orderReceipt(Order $order){

            return view("admin.order.receipt", compact("order"));
        
        }


}
