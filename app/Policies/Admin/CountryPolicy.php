<?php

namespace App\Policies\Admin;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CountryPolicy
{
    use HandlesAuthorization;
    use PermissionsTrait;

    const VIEW   = "country:view";
    const CREATE = "country:create";
    const UPDATE = "country:update";
    const DELETE = "country:delete";

    public function __construct() {}
}
