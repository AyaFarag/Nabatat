<?php

namespace App\Http\Controllers\Admin;

use App\Models\Rate;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\RateResource;
use App\Http\Requests\Api\RateRequest;

class RateController extends Controller
{
    public function index()
    {
        $rate = Rate::orderBy('id', 'desc')->where('status',0)->paginate();
        return view('Admin.rates.index', compact('rate'));
    }
    
    public function approve(Request $request ,Rate $rate)
    {
        $rate->status = 1;
        $rate->save();
        return back()->with('success','Approved');
    }
    
    public function reject(Request $request ,Rate $rate)
    {   
        $rate->status = 0;
        $rate->save();
        if($rate){
            $rate->delete();
        }
        return back()->with('success','Rejected');
    }
}