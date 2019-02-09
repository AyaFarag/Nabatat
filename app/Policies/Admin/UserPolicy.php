<?php

namespace App\Policies\Admin;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

use Auth;

class UserPolicy
{
    use HandlesAuthorization;
    use PermissionsTrait;

    const VIEW   = "user:view";
    const CREATE = "user:create";
    const UPDATE = "user:update";
    const DELETE = "user:delete";

    public function __construct() {}
}
