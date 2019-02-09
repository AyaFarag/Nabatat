<?php

namespace App\Policies\Shared;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\Models\User;
use App\Models\Admin;
use App\Models\Rate;

class RatingPolicy
{
    use HandlesAuthorization;

    const VIEW   = "rating:view";
    const CREATE = "rating:create";
    const UPDATE = "rating:update";
    const DELETE = "rating:delete";

    public function __construct() {}

    public function view($user, Rate $rating = null) {
        return $user instanceof User
            ? $rating -> user_id === $user -> id
            : in_array(self::VIEW, $user -> permissions);
    }

    public function create($user, Rate $rating = null) {
        return $user instanceof User
            ? $user -> rates() -> where("product_id", $rating -> product_id) -> count() === 0
            : in_array(self::CREATE, $user -> permissions);
    }

    public function update($user, Rate $rating = null) {
        return $user instanceof User
            ? $rating -> user_id === $user -> id
            : in_array(self::UPDATE, $user -> permissions);
    }

    public function delete($user, Rate $rating = null) {
        return $user instanceof User
            ? $rating -> user_id === $user -> id
            : in_array(self::DELETE, $user -> permissions);
    }
}
