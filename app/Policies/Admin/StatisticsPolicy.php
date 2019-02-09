<?php

namespace App\Policies\Admin;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StatisticsPolicy
{
    use HandlesAuthorization;
    use PermissionsTrait;

    const VIEW = "statistics:view";

    public function __construct() {}
}
