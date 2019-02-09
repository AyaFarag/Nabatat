<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\City;
use App\Models\Category;
use App\Models\User;
use App\Models\Page;
use App\Models\Setting;
use App\Models\Service;
use App\Models\Payment;

use App\Http\Resources\CountryResource;
use App\Http\Resources\CityResource;
use App\Http\Resources\CategoryTreeResource;
use App\Http\Resources\PageResource;
use App\Http\Resources\ContactResource;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\PaymentResource;


use Auth;

class UtilityController extends Controller
{
    public function countries()
    {
        return CountryResource:: collection(Country::all());
    }

    public function cities()
    {
        return CityResource:: collection(City::all());
    }

    public function categories()
    {
        return CategoryTreeResource:: collection(Category::with("children") -> whereNull("parent_id") -> get());
    }

    public function page($slug){
        $page = Page::where('type',$slug)->first();
        return new PageResource($page);
    }


    public function contacts() {
        return new ContactResource(Setting::first());
    }

    public function services(){
        return ServiceResource:: collection(Service::all());
    }

    public function payment_methods() {
        return PaymentResource:: collection(Payment::where("status", 1) -> get());
    }
}
