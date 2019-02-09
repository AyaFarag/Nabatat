<?php

namespace App\Policies\Admin;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PaymentPolicy
{
    use HandlesAuthorization;
    use PermissionsTrait;

    const VIEW   = "payment:view";
    const UPDATE = "payment:update";

    public function __construct() {}
}
