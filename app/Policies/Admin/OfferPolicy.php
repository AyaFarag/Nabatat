<?php

namespace App\Policies\Admin;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OfferPolicy
{
    use HandlesAuthorization;
    use PermissionsTrait;

    const VIEW   = "offer:view";
    const CREATE = "offer:create";
    const UPDATE = "offer:update";
    const DELETE = "offer:delete";

    public function __construct() {}
}
