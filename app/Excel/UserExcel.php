<?php
namespace App\Excel;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Database\Eloquent\Collection;

class UserExcel implements FromView
{
	public $users;

	public function __construct(Collection $users) {
		$this -> users = $users;
	}

    public function view(): View
    {
    	$users = $this -> users;
        return view("admin.reports.user", compact("users"));
    }
}