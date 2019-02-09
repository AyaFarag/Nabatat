<?php
namespace App\Excel;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Database\Eloquent\Collection;

class OrderExcel implements FromView
{
	public $orders;

	public function __construct(Collection $orders) {
		$this -> orders = $orders;
	}

    public function view(): View
    {
    	$orders = $this -> orders;
        return view("admin.reports.order", compact("orders"));
    }
}