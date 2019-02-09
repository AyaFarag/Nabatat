<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\ServiceRequest;
use App\Http\Controllers\Controller;

use Session;

class ServiceController extends Controller
{
    public function index()
    {
        $this -> authorize("view", Service::class);

        $services = Service::paginate();
        return view('admin.service.index' , compact('services'));
    }

    public function create()
    {
        $this -> authorize("create", Service::class);

        $services = Service::where('parent_id',null)->get()->pluck('title','id');
        return view('admin.service.create', compact('services'));
    }

    public function store(ServiceRequest $request)
    {
        $this -> authorize("create", Service::class);

        Service::create($request->all());
        Session::flash("success", "service was added successfully!");

        return redirect() -> route("admin.service.index");
    }

    public function edit(Service $service)
    {
        $this -> authorize("update", Service::class);

        $services = Service::where('parent_id', null)->get()->pluck('name','id');
        return view('admin.service.edit' ,compact('services' ,'service'));
    }


    public function update(Request $request, Service $service)
    {
        $this -> authorize("update", Service::class);

        $service->update($request->all());
        Session::flash("success", "Service was updated successfully!");

        return redirect() -> route("admin.service.index");
    }

    public function destroy(Service $service)
    {
        $this -> authorize("delete", Service::class);

        $service->delete();
        Session::flash("success", "Service was deleted successfully!");

        return redirect() -> route("admin.service.index");
    }
}
