<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\ServiceRequest;

use Session;

class RequestController extends Controller
{
    public function index(Request $request)
    {
        $this -> authorize("view", ServiceRequest::class);

        if ($request -> filled("query")) {
            $requests = ServiceRequest::whereHas("user", function ($q) use ($request) {
                return $q -> search($request -> input("query"));
            });
        } else {
            $requests = ServiceRequest::query();
        }

        if ($request -> filled("approved")) {
            $requests -> whereNotNull("approved_at");
        }

        $requests = $requests -> latest() -> paginate();

        return view("admin.request.index", compact("requests"));
    }

    public function show(ServiceRequest $request) {
        $this -> authorize("view", ServiceRequest::class);

        return view("admin.request.show", compact("request"));
    }

    public function approve(ServiceRequest $request) {
        $this -> authorize("update", ServiceRequest::class);

        $request -> approved_at = \Carbon\Carbon::now() -> toDateTimeString();
        $request -> save();

        Session::flash("success", "Service request was approved successfully!");

        return redirect() -> route("admin.request.index");
    }

    public function destroy(ServiceRequest $request) {
        $this -> authorize("delete", ServiceRequest::class);

        $request -> delete();

        Session::flash("success", "Service request was removed successfully!");

        return redirect() -> route("admin.request.index");
    }
}
