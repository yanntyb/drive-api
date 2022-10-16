<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Role;

trait HasRoles {

    use \Spatie\Permission\Traits\HasRoles;

    public function hasRole(...$roles): bool
    {
        return $this->roles()->whereIn("name", [...$roles])->count();
    }

    public function hasPermissionTo(...$permissions): bool
    {
        return $this->roles()->get()->filter(function(Role $role) use ($permissions){
            return $role->permissions->whereIn("name", [...$permissions]);
        })->count();
    }

}
