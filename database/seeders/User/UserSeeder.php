<?php

namespace Database\Seeders\User;

use App\Models\User;
use Database\Seeders\User\Role\RoleSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $this->callOnce([
            RoleSeeder::class,
            AdminSeeder::class,
        ]);

        $usersRoles = Role::whereIn("name", [
            "api-user",
        ])->get();

        User::factory()
            ->count(10)
            ->create()
            ->each(function(User $user) use ($usersRoles){
                $user->assignRole($usersRoles);
            })
        ;

    }
}
