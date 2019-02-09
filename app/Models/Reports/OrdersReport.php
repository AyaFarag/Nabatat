<?php

namespace App\Models\Reports;

use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use Illuminate\Http\Request;

class OrdersReport extends AbstractReport
{
    public function __construct(){
    	$this->model = new Order;
    	$this->query = $this->model->query();
    	$this->skipedValue = ['device_token','password'];
    }

    public function run(Request $request){
        $this->query
        ->join('users', 'users.id', '=', 'orders.user_id')
        ->join('payment_detailes', 'payment_detailes.order_id', '=', 'orders.id')
        ->select("orders.id", 'users.name', 'orders.shipping_cost', 'payment_detailes.total', "payment_detailes.payment_date", "orders.status as status_string");
        $this->filter($request);
        $this->report = $this->query->paginate(10);
    	return [ 'columns' => $this->getColumns(),
    			 'objects' => $this->report];
    }

    public function filter(Request $request){
    	$this->filterByDate($request, 'payment_detailes.payment_date');
        $this->filterByStatus($request);
        $this->filterByPrice($request, 'payment_detailes.total');
    }

    public function filterByStatus(Request $request){
        if($request->filled('status')){
            switch ($request->get('status')) {
                case Order::CONFIRMED:
                $this->query->status(Order::CONFIRMED);
                break;
                case Order::ON_THE_WAY:
                $this->query->status(ON_THE_WAY);
                break;
                case Order::RETURNED:
                $this->query->status(Order::RETURNED);
                break;
                case Order::DELIVERED:
                break;
                $this->query->status(Order::DELIVERED);
                break;
                default:
                $this->query->status(Order::PENDING);
            }
        }
    }

}
