<?php

namespace App\Policies\Api;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\Models\User;
use App\Models\Cart;

class CartPolicy
{
    use HandlesAuthorization;

    public function __construct() {}

    public function update(User $user, Cart $cart) {
        return $cart -> user_id === $user -> id;
    }

    public function delete(User $user, Cart $cart) {
        return $cart -> user_id === $user -> id;
    }
}
