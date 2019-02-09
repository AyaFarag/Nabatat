<?php

namespace App\Models\Reports;

use Illuminate\Database\Eloquent\Model;
use App\Models\Offer;
use Illuminate\Http\Request;

class OffersReport extends Model
{
    public function __construct(){
    	$this->model = new Offer;
    	$this->query = $this->model->query();
    	$this->skipedValue = ['device_token','password'];
    }

    public function run(Request $request){
        $this->report = $this->query->paginate(10);
    	return [ 'columns' => $this->getColumns(),
    			 'objects' =>$this->report];
    }

    public function filter(Request $request){
    	$this->filterByDate($request);
    }
}
