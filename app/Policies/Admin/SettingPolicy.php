<?php

namespace App\Policies\Admin;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

use Auth;

class SettingPolicy
{
    use HandlesAuthorization;
    use PermissionsTrait;

    const UPDATE = "setting:update";

    public function __construct() {}
}
