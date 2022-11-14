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
    public function run()
    {
        $defaultRole = [
            "admin",
            "user"
        ];
        $defaultPermissions = [
            "access-api-drive",
            "access-admin-panel",
        ];

        foreach($defaultRole as $role){
            Role::create([
                "name" => $role,
            ]);
        }

        foreach ($defaultPermissions as $permission){
            Permission::create([
                "name" => $permission,
            ]);
        }

        $this->associateDefaultRoleAndPermissions();
    }

    public function associateDefaultRoleAndPermissions(): void
    {
        Role::query()->firstWhere("name","admin")?->givePermissionTo(Permission::all());
        Role::query()->firstWhere("name","user")?->givePermissionTo(Permission::whereIn("name", [
            "access-api-drive"
        ]));
    }
}
