<?php

namespace Database\Seeders\User\Role;

use App\Services\ConfigService;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $defaultRole = [
            [
                "name" => "admin",
            ],
            [
                "name" => "api-user",
            ],
        ];
        $defaultPermissions = [
            [
                "name" => "access-api-drive",
            ],
            [
                "name" => "access-api-admin",
            ],
            [
                "name" => "access-admin-panel",
            ],
        ];

        collect($defaultRole)->each(fn ($role) => Role::create($role));
        collect($defaultPermissions)->each(fn ($permission) => Permission::create($permission));

        $this->associateDefaultRoleAndPermissions();
    }

    public function associateDefaultRoleAndPermissions(): void
    {
        Role::query()->firstWhere("name","admin")?->givePermissionTo(Permission::all());
        Role::query()->firstWhere("name","api-user")?->givePermissionTo(Permission::whereIn("name", [
            "access-api-drive"
        ])->get());
    }
}
