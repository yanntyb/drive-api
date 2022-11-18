<?php

namespace App\Events;

use App\Models\Storage\Storage;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role;
use Str;

class RoleAssignedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected Collection $currentRole;
    protected User $user;
    protected Role $newRole;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, Role $newRole)
    {
        $this->currentRole = $user->roles ?? collect();
        $this->user = $user;
        $this->newRole = $newRole;

        $this->assignNewStorage();
    }

    /**
     * @return void
     */
    public function assignNewStorage(): void
    {
        if ($this->newRoleNameIsAndDontExist("api-user")) {
            $storage = new Storage([
                "path" => Str::slug($this->user->email . uniqid("-storage",true)),
                "storage_size" => 1000,
            ]);
            $storage->save();
            $this->user->storages()->sync($storage);
        }
    }

    public function newRoleNameIsAndDontExist(string $name): bool
    {
        return $this->newRole->name === $name && !$this->roleIsAssigned($name);
    }

    public function roleIsAssigned(string $name): bool
    {
        return $this->currentRole->where("name", $name)->first() ?? false;
    }


}
