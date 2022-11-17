<?php

namespace Database\Seeders\User;

use App\Models\Storage\Storage;
use App\Models\User;
use Database\Seeders\User\Role\RoleSeeder;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Str;

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
            ->has(
                Storage::factory()
                    ->count(1)
                    ->state(function (array $attributes, User $user) {
                        return ["path" => Str::slug($user->name . " " . uniqid("storage", true))];
                    })
            )
            ->create()
            ->each(function (User $user) use ($usersRoles) {
                $user->assignRole($usersRoles);
            });

    }
}
