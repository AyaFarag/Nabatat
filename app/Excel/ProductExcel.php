<?php
namespace App\Excel;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Database\Eloquent\Collection;

class ProductExcel implements FromView
{
	public $products;
	public $totals;

	public function __construct(Collection $products, $totals) {
		$this -> products = $products;
		$this -> totals = $totals;
	}

    public function view(): View
    {
    	$products = $this -> products;
    	$totals = $this -> totals;
        return view("admin.reports.product", compact("products", "totals"));
    }
}