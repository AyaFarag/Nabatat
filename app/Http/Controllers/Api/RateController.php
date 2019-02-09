<?php

namespace App\Http\Controllers\Api;

use App\Models\Rate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\RateResource;
use App\Http\Requests\Api\RateRequest;

class RateController extends Controller
{
    public function index(Rate $rate)
    {
        $product = $rate->product();
        $rate = Rate::where('product_id', $product && 'status', 1)->latest()->paginate();
        return RateResource::collection($rate);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(RateRequest $request)
    {
        $rate = new Rate($request->all());
        $rate -> user_id = auth()->id();

        $this -> authorize("create", $rate);

        $rate -> save();
        if($rate){
            return response()->json([
                'message'=> trans('api.added_successfully')
            ],201);
        }else{
            return response()->json([
                'message'=> trans('api.unexpected_error')
            ],500);
        }
    }


    public function update(RateRequest $request , Rate $rate)
    {
        $this -> authorize("update", $rate);

        $rate->update($request->all());

        return response()->json([
            'message'=> trans('api.updated_successfully')
        ],200);
    }


    public function destroy(Rate $rate)
    {
        $this -> authorize("delete", $rate);

        $rate->delete();
        return response()->json([
            'message'=> trans('api.deleted_successfully')
        ],200);
    }

}
