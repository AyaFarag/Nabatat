<?php

namespace App\Models\Reports;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsReport extends AbstractReport
{
    const INSTOCK = "inStock";
    const OUTSTOCK = "outStock";
    public function __construct(){
    	$this->model = new Product;
    	$this->query = $this->model->query();
    	$this->skipedValue = ['device_token','password','description'];
    }

    public function run(Request $request){
    	$this->filter($request);
        $this->report = $this->query->paginate(10);
    	return [ 'columns' => $this->getColumns(),
    			 'objects' => $this->report];
    }

    public function filter(Request $request){
    	$this->filterByDate($request);
    	$this->filterByPrice($request);
        $this->filterByStatus($request);
    }

    public function filterByStatus(Request $request){
        if($request->filled('status')){
            switch ($request->get('status')) {
                case self::INSTOCK:
                    $this->query->inStock();
                    break;
                default:
                    $this->query->outStock();
                    break;
            }
        }
    }
}
