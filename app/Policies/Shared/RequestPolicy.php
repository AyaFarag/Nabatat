<?php

namespace App\Policies\Shared;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\Models\User;
use App\Models\Admin;
use App\Models\ServiceRequest;

class RequestPolicy
{
    use HandlesAuthorization;

    const VIEW   = "request:view";
    const CREATE = "request:create";
    const UPDATE = "request:update";
    const DELETE = "request:delete";

    public function __construct() {}

    public function view($user, ServiceRequest $serviceRequest = null) {
        if ($user instanceof User)
            return $user -> id === $serviceRequest -> user_id;
        else
            return in_array(self::VIEW, $user -> permissions);
    }

    public function update($user, ServiceRequest $serviceRequest = null) {
        if ($user instanceof User)
            return $user -> id === $serviceRequest -> user_id;
        else
            return in_array(self::UPDATE, $user -> permissions);
    }

    public function delete($user, ServiceRequest $serviceRequest = null) {
        if ($user instanceof User)
            return $user -> id === $serviceRequest -> user_id;
        else
            return in_array(self::DELETE, $user -> permissions);
    }
}
