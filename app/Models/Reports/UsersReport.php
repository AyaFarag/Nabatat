<?php

namespace App\Models\Reports;
use App\Models\User;
use Illuminate\Http\Request;

class UsersReport extends AbstractReport
{
    public function __construct(){
    	$this->model = new User;
    	$this->query = $this->model->query();
    	$this->skipedValue = ['device_token','password'];
    }

    public function run(Request $request){
    	$this->filter($request);
        $this->report = $this->query->select(['id', 'name', 'email', 'created_at'])->paginate(10);
    	return [ 'columns' => $this->getColumns(),
    			 'objects' => $this->report];
    }

    public function filter(Request $request){
    	$this->filterByDate($request);
    }

}
