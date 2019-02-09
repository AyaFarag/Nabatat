<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
	protected $table = "requests";
    protected $fillable = [
        "lat","lang","size","address"
    ];

    protected $casts = [
        "images" => "array"
    ];

    public function user() {
        return $this -> belongsTo(User::class );
    }

    public function services()
    {
        return $this->belongsToMany(Service::class, "request_services", "request_id", "service_id");
    }
}
