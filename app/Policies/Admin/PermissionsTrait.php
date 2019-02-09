<?php

namespace App\Policies\Admin;

use App\Models\Admin;

use Auth;

trait PermissionsTrait {
    public function view(Admin $admin) {
        return in_array(static::VIEW, $admin -> permissions);
    }

    public function create(Admin $admin) {
        return in_array(static::CREATE, $admin -> permissions);
    }

    public function update(Admin $admin) {
        return in_array(static::UPDATE, $admin -> permissions);
    }

    public function delete(Admin $admin) {
        return in_array(static::DELETE, $admin -> permissions);
    }
}