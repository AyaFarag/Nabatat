<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable =[
        'title','description','parent_id'
    ];

    public function parent()
    {
        return $this->belongsTo( Service::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany( Service::class, 'parent_id');
    }

    public function request()
    {
        return $this->belongsToMany(ServiceRequest::class, "request_services");
    }
}
