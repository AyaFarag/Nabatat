<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Models\User as User;
use App\Models\Product as Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CartRequest;
use App\Http\Resources\CartResource;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user()->id;
        $cart = Cart::where('user_id' , $user)->get();
        return CartResource:: collection($cart);
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
    public function store(CartRequest $request)
    {
        $user = auth() -> user();
        $existingProduct = $user -> carts() -> where("product_id", $request -> input("product_id")) -> first();
        if ($existingProduct) {
            $existingProduct -> quantity += $request -> input("quantity");
            $existingProduct -> save();
        } else {
                  $cart      = new Cart($request->all());
            $cart -> user_id = $user -> id;
            $cart -> save();
        }
        return new CartResource($cart);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(CartRequest $request, Cart $cart)
    {

        $this -> authorize("update", $cart);

        $cart->update($request->all());

        return new CartResource($cart);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        $this -> authorize("delete", $cart);
        $cart->delete();
        return response()
            -> json([
                "message" => trans("api.deleted_successfully")
            ], 200);
    }
}
