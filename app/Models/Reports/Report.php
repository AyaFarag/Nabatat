<?php

namespace App\Models\Reports;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Http\Request;

class Report extends Model
{
    private $report;

    const USERS_REPORT = 'users';
    const ORDERS_REPORT = 'orders';
    const OFFERS_REPORT = 'offers';
    const PRODUCTS_REPORT = 'products';


    public function run(Request $request, $report){
		switch ($report) {
    		case self::USERS_REPORT:
    			 $this->report = new UsersReport;
    			 break;
    		case self::OFFERS_REPORT:
    			$this->report = new OffersReport;
    			break;
    		case self::PRODUCTS_REPORT:
    			$this->report = new ProductsReport;
    			break;
    		default:
    			$this->report = new OrdersReport;
    			break;
    	}
    	return $this->report->run($request);
    }

}
