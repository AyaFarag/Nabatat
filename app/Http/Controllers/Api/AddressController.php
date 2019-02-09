<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\Api\AddressRequest;

use App\Models\Address;

use App\Http\Resources\AddressResource;

use Auth;

class AddressController extends Controller
{
    public function index()
    {
        return AddressResource::collection(Auth::user() -> addresses);
    }

    public function store(AddressRequest $request)
    {
        $address = new Address($request -> all());
        $address -> user_id = Auth::user() -> id;
        $address -> save();

        return response()
            -> json([
                "message" => trans("api.added_successfully")
            ], 201);
    }

    public function show(Address $address)
    {
        $this -> authorize("view", $address);

        return new AddressResource($address);
    }

    public function update(AddressRequest $request, Address $address)
    {
        $this -> authorize("update", $address);

        $address -> update($request -> all());

        return response()
            -> json([
                "message" => trans("api.updated_successfully")
            ], 200);
    }

    public function destroy(Address $address)
    {
        $this -> authorize("delete", $address);

        $address -> delete();

        return response()
            -> json([
                "message" => trans("api.deleted_successfully")
            ], 200);
    }
}
