<?php

namespace App\Policies\Api;

use Illuminate\Auth\Access\HandlesAuthorization;


use App\Models\User;
use App\Models\Address;

class AddressPolicy
{
    use HandlesAuthorization;

    public function __construct() {}

    public function view(User $user, Address $address) {
        return $address -> user_id === $user -> id;
    }

    public function update(User $user, Address $address) {
        return $address -> user_id === $user -> id;
    }

    public function delete(User $user, Address $address) {
        return $address -> user_id === $user -> id;
    }
}
