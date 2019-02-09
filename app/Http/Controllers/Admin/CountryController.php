<?php

namespace App\Http\Controllers\Admin;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CountryRequest;

use Session;

class CountryController extends Controller
{
    public function index(Request $request)
    {
        $this -> authorize("view", Country::class);

        $country = Country::paginate();

        return view('admin.country.index', compact('country'));
    }

    public function create()
    {
        $this -> authorize("create", Country::class);

        return view('admin.country.create');
    }

    public function store(CountryRequest $request)
    {
        $this -> authorize("create", Country::class);

        Country::create($request->all());

        Session::flash("success", "Country was added successfully!");

        return redirect() -> route("admin.country.index");
    }

    public function edit(Country $country)
    {
        $this -> authorize("update", Country::class);

        return view('admin.country.edit', compact('country'));
    }

    public function update(CountryRequest $request, Country $country)
    {
        $this -> authorize("update", Country::class);

        $country->update($request->all());

        Session::flash("success", "Country was updated successfully!");

        return redirect() -> route("admin.country.index");
    }

    public function destroy(Country $country)
    {
        $this -> authorize("delete", Country::class);

        $country->delete();

        Session::flash("success", "Country was deleted successfully!");

        return redirect() -> route("admin.country.index");
    }
}
