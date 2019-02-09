<?php

namespace App\Models\Reports;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

abstract class AbstractReport
{
    protected $query;
    protected $model;
    protected $skipedValue = [];
    protected $report;

    const USERS_REPORT = 'users';
    const ORDERS_REPORT = 'orders';
    const OFFERS_REPORT = 'offers';
    const PRODUCTS_REPORT = 'products';

    abstract  public function __construct();

    abstract  public function run(Request $request);

    abstract  public function filter(Request $request);

    public function filterByDate(Request $request, $column = 'created_at'){
    	if($request->filled('start_date')){
    		$this->query->where($column, '>=', $request->get('start_date'));
    	}
    	if($request->filled('end_date')){
    		$this->query->where($column, '<=', $request->get('end_date'));
    	}
    }

    public function filterByPrice(Request $request, $column = 'price'){
    	if($request->filled('minimum_price')){
    		$this->query->where($column,'>=',$request->get('minimum_price'));
    	}
    	if($request->filled('maximum_price')){
    		$this->query->where($column,'<=',$request->get('maximum_price'));
    	}
    }

    public function filterByStatus(Request $request){
    	if($request->filled('status')){
    		$this->query->where('status', $request->get('status'));
    	}
    }

    public function getColumns(){
        $columns = [];
        if($this->report->total()){
            $attributes = $this->report[0]->getAttributes();
            foreach ($attributes as $key => $value) {
                $columns[$key] = ucfirst(str_replace('_', ' ', $key));
            }
        }
    	return $columns;
    }
}
