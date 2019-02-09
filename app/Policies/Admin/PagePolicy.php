<?php

namespace App\Policies\Admin;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PagePolicy
{
    use HandlesAuthorization;
    use PermissionsTrait;

    const VIEW   = "page:view";
    const UPDATE = "page:update";

    public function __construct() {}
}
