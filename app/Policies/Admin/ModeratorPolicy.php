<?php

namespace App\Policies\Admin;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

use Auth;

class ModeratorPolicy
{
    use HandlesAuthorization;
    use PermissionsTrait;

    const VIEW   = "moderator:view";
    const CREATE = "moderator:create";
    const UPDATE = "moderator:update";
    const DELETE = "moderator:delete";

    public function __construct() {}
}
