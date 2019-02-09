<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Category extends Model
{
    use NodeTrait;
    
    protected $fillable = [
        "name","parent_id",
    ];

    public function parent()
    {
        return $this->belongsTo( Category::class, "parent_id");
    }

    public function children()
    {
        return $this->hasMany( Category::class, "parent_id");
    }
    
    public function ancestors()
    {
        return $this->hasMany( Category::class, "parent_id");
    }
    
    public function descendants()
    {
        return $this->hasMany( Category::class, "parent_id");
    }
}

