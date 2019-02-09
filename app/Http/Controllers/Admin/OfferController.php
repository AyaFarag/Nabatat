<?php

namespace App\Http\Controllers\Admin;

use App\Models\Offer;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\OfferRequest;

use Session;

class OfferController extends Controller
{
    public function index()
    {
        $this -> authorize("view", Offer::class);

        $offer = Offer::paginate();
        return view('admin.offer.index' ,compact('offer'));
    }

    public function create()
    {
        $this -> authorize("create", Offer::class);

        $product = Product::pluck('name','id')->all();
        return view('admin.offer.create',compact('product'));
    }

    public function store(OfferRequest $request)
    {
        $this -> authorize("create", Offer::class);
        Offer::create($request->all());
        Session::flash("success", "Offer was added successfully!");

        return redirect() -> route("admin.offer.index");
    }

    public function edit(Offer $offer)
    {
        $this -> authorize("update", Offer::class);

        $product = Product::pluck('name','id')->all();

        return view('admin.offer.edit',compact('product', 'offer'));
    }

    public function update(Request $request, Offer $offer)
    {
        $this -> authorize("update", Offer::class);

        $offer->update($request->all());
        Session::flash("success", "Offer was updated successfully!");

        return redirect() -> route("admin.offer.index");
    }

    public function destroy(Offer $offer)
    {
        $this -> authorize("delete", Offer::class);

        $offer->delete();
        Session::flash("success", "Offer was deleted successfully!");

        return redirect() -> route("admin.offer.index");
    }
}
