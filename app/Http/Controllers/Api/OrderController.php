<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Address;
use App\Http\Requests\Api\OrderRequest;
use App\Http\Requests\Api\OrderProductRequest;
use App\Http\Resources\OrderResource;
use App\Http\Resources\EditableOrderResource;
use Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type)
    {
        $orders = Auth::user() -> orders();

        if (strtolower($type) === Order::PENDING_FILTER) {
            $orders -> whereIn("status", [
                Order::PENDING,
                Order::CONFIRMED,
                Order::ON_THE_WAY,
                Order::PREPARING
            ]);
        } else {
            $orders -> whereIn("status", [
                Order::DELIVERED,
                Order::RETURNED
            ]);
        }

        $orders = $orders -> paginate();

        return OrderResource::collection($orders);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
    {
        $this -> authorize("create", Order::class);

        $user = auth()->user();
        $order = Order::create([
            //prepare order data
            'user_id' => $user->id,
            'address_id' => $request->get('address_id'),
            'shipping_cost' => Address::find($request->get('address_id'))->city->shipping_cost,
            'code' => str_rand(5)->unique(),
        ]);
        //prepare order products
        $products = $order->prepareOrderProducts($user->products);
        //save order products
        $order->products()->sync($products);
        //prepare payment data
        $paymentData = $order->preparePaymentData($request);
        $order->paymentDetailes()->sync($paymentData);

        $user -> carts() -> delete();

        return response()
            -> json([
                "id" => $order -> id,
                "message" => trans("api.added_successfully")
            ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {

        $this -> authorize("view", $order);

        return new EditableOrderResource($order);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(OrderRequest $request, Order $order)
    {
        $this -> authorize("update", $order);

        $user = auth()->user();
        $order -> update([
            'address_id' => $request->get('address_id'),
            'shipping_cost' => Address::find($request->get('address_id'))->city->shipping_cost
        ]);

        return response()
            -> json([
                "message" => trans("api.added_successfully")
            ], 201);
    }

    public function addProduct(OrderProductRequest $request, Order $order) {
        $this -> authorize("update", $order);

        $product = Product::find($request -> input("product_id"));

        $orderProduct = $order -> products() -> where("product_id", $product -> id) -> first();

        if ($orderProduct) {
            $orderProduct -> pivot -> update(["quantity" => $request -> input("quantity")]);
        } else {
            $order
                -> products()
                -> attach(
                    $product -> id,
                    [
                        "regular_price" => $product -> price,
                        "price"         => $product -> discounted_price,
                        "quantity"      => $request -> input("quantity")
                    ]
                );
        }

        return response()
            -> json([
                "message" => trans("api.added_successfully")
            ], 201);
    }

    public function updateProduct(OrderProductRequest $request, Order $order) {
        $this -> authorize("update", $order);

        $product = Product::find($request -> input("product_id"));

        $order
            -> products()
            -> detach($product -> id);

        $order
            -> products()
            -> attach(
                $product -> id,
                [
                    "regular_price" => $product -> price,
                    "price"         => $product -> discounted_price,
                    "quantity"      => $request -> input("quantity")
                ]
            );


        return response()
            -> json([
                "message" => trans("api.updated_successfully")
            ], 200);
    }

    public function deleteProduct(OrderProductRequest $request, Order $order) {
        $this -> authorize("update", $order);

        $order
            -> products()
            -> detach($request -> input("product_id"));

        return response()
            -> json([
                "message" => trans("api.deleted_successfully")
            ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $this -> authorize("delete", $order);

        $order -> delete();

        return response()
            -> json([
                "message" => trans("api.deleted_successfully")
            ], 200);
    }
}
