<?php

namespace App\Policies\Admin;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;
    use PermissionsTrait;

    const VIEW   = "product:view";
    const CREATE = "product:create";
    const UPDATE = "product:update";
    const DELETE = "product:delete";

    public function __construct() {}
}
