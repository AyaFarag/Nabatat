<?php

namespace App\Policies\Admin;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServicePolicy
{
    use HandlesAuthorization;
    use PermissionsTrait;

    const VIEW   = "service:view";
    const CREATE = "service:create";
    const UPDATE = "service:update";
    const DELETE = "service:delete";

    public function __construct() {}
}
