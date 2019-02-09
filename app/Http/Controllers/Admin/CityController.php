<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CityRequest;

use Session;

class CityController extends Controller
{
    public function index()
    {
        $this -> authorize("view", City::class);

        $city = City::paginate();
        return view('admin.city.index', compact('city'));
    }

    public function create()
    {
        $this -> authorize("create", City::class);

        $countries = Country::pluck('name','id')->all();
        return view('admin.city.create', compact('countries'));
    }

    public function store(CityRequest $request)
    {
        $this -> authorize("create", City::class);

        City::create($request->all());

        Session::flash("success", "City was added successfully!");

        return redirect() -> route("admin.city.index");
    }

    public function edit(City $city)
    {
        $this -> authorize("update", City::class);

        $countries = Country::pluck('name','id')->all();

        return view('admin.city.edit', compact('city','countries'));
    }

    public function update(Request $request, City $city)
    {
        $this -> authorize("update", City::class);

        $city->update($request->all());

        Session::flash("success", "City was updated successfully!");

        return redirect() -> route("admin.city.index");
    }

    public function destroy(City $city)
    {
        $this -> authorize("delete", City::class);

        $City->delete();

        Session::flash("success", "City was deleted successfully!");

        return redirect() -> route("admin.city.index");
    }
}
