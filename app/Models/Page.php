<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = 'pages';

    const ABOUT = 'about';
    const PRIVACY = 'privacy';

    protected $fillable = [
        'content'
    ];


}
