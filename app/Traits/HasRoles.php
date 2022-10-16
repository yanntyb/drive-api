<?php

namespace App\Traits;

trait HasRoles {

    use \Spatie\Permission\Traits\HasRoles;

    public function hasRole(...$roles): bool
    {
        return $this->roles()->whereIn("name", [...$roles])->count();
    }

}
