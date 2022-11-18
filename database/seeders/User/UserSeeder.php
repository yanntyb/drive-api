<?php

namespace Database\Seeders\User;

use App\Facades\StorageService;
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
            ->create()
            ->each(function (User $user) use ($usersRoles) {
                $user->assignRole($usersRoles);
                $user->storages->each(static function (Storage $storage) {
                    StorageService::addFileToStorage($storage, "test.txt", Str::random(5000));
                });
            });

    }
}
