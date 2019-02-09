<?php

namespace App\Http\Controllers\Api;

use App\Models\ServiceRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ServiceRequestRequest;
use App\Http\Resources\ServiceRequestResource;

class ServiceRequestController extends Controller
{
    public function index()
    {
        $serviceRequest = auth()->user()->requests()->paginate();
        return ServiceRequestResource::collection($serviceRequest);
    }

    public function store(ServiceRequestRequest $request)
    {
        $serviceRequest = new ServiceRequest($request -> all());
        $serviceRequest -> user_id = auth() -> user() -> id;
        $serviceRequest -> save();
        $serviceRequest -> services() -> sync($request -> input("service_ids"));

        return response() -> json([
            "message" => trans("api.added_successfully")
        ], 201);
    }

    public function show(ServiceRequest $serviceRequest)
    {
        $this -> authorize("view", $serviceRequest);

        return new ServiceRequestResource($serviceRequest);
    }

    public function update(ServiceRequestRequest $request, ServiceRequest $serviceRequest)
    {
        $this -> authorize("update", $serviceRequest);

        $serviceRequest -> update($request -> all());
        $serviceRequest -> services() -> sync($request -> input("service_ids"));

        return response() -> json([
            "message" => trans("api.updated_successfully")
        ], 200);
    }

    public function destroy(ServiceRequest $serviceRequest)
    {
        $this -> authorize("delete", $serviceRequest);

        $serviceRequest->delete();
        return response()->json([
            'message'=> trans('api.deleted_successfully')
        ],200);
    }
}
