<?php

namespace App\Policies\Shared;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\Models\User;
use App\Models\Admin;
use App\Models\Order;

class OrderPolicy
{
    use HandlesAuthorization;

    const VIEW   = "order:view";
    const CREATE = "order:create";
    const UPDATE = "order:update";
    const DELETE = "order:delete";

    public function __construct() {}

    public function view($user, Order $order = null) {
        return $user instanceof User
            ? $order -> user_id === $user -> id
            : in_array(self::VIEW, $user -> permissions);
    }

    public function create($user, Order $order = null) {
        return $user instanceof User
            ? true
            : in_array(self::CREATE, $user -> permissions);
    }

    public function update($user, Order $order = null) {
        return $user instanceof User
            ? $order -> user_id === $user -> id && $order -> status === Order::PENDING
            : in_array(self::UPDATE, $user -> permissions);
    }

    public function delete($user, Order $order = null) {
        return $user instanceof User
            ? $order -> user_id === $user -> id && $order -> status === Order::PENDING
            : in_array(self::DELETE, $user -> permissions);
    }
}
