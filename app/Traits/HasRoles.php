<?php

namespace App\Traits;

use App\Events\RoleAssignedEvent;
use App\Events\RoleRemovedEvent;
use App\Models\User;

trait HasRoles {

    use \Spatie\Permission\Traits\HasRoles {
        assignRole as protected originalAssignRole;
        removeRole as protected originalRemoveRole;
        syncRoles as protected originalSyncRoles;
    }

    /**
     * @param  mixed  ...$roles
     * @return User|HasRoles
     */
    public function assignRole(...$roles): self
    {
        $this->fireRoleAssignedEvent($roles);
        $this->originalAssignRole(...$roles);

        return $this;
    }

    /**
     * @param $role
     * @return bool
     */
    public function fireRoleAssignedEvent($role): bool
    {
        if (is_iterable($role)) {
            return array_walk($role, [$this, 'fireRoleAssignedEvent']);
        }
        if(!$role) {
            return false;
        }
        event(new RoleAssignedEvent($this, $this->getStoredRole($role)));

        return true;
    }

    /**
     * @param $role
     * @return User|HasRoles
     */
    public function removeRole($role): self
    {
        $this->fireRoleRemovedEvent($role);
        $this->originalRemoveRole($role);

        return $this;
    }

    /**
     * @param $role
     * @return bool
     */
    public function fireRoleRemovedEvent($role): bool
    {
        if (is_iterable($role)) {
            return array_walk($role, [$this, 'fireRoleRemovedEvent']);
        }
        if(!$role) {
            return false;
        }
        event(new RoleRemovedEvent($this, $this->getStoredRole($role)));

        return true;
    }

}
