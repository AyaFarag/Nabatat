<?php

namespace App\Policies\Admin;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;
    use PermissionsTrait;

    const VIEW   = "category:view";
    const CREATE = "category:create";
    const UPDATE = "category:update";
    const DELETE = "category:delete";

    public function __construct() {}

}
