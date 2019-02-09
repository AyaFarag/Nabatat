<?php

namespace App\Policies\Admin;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CityPolicy
{
    use HandlesAuthorization;
    use PermissionsTrait;

    const VIEW   = "city:view";
    const CREATE = "city:create";
    const UPDATE = "city:update";
    const DELETE = "city:delete";

    public function __construct() {}

}
