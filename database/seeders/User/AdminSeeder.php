<?php

namespace Database\Seeders\User;

use App\Models\Storage\Storage;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use StorageService;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $admin = User::query()->create([
            "name" => "Admin",
            "email" => "support@drive.com",
            "password" => Hash::make("support"),
        ])->assignRole("admin","api-user");
        $admin->storages->each(static function (Storage $storage) {
            StorageService::addFileToStorage($storage, fake()->name . ".txt", Str::random(5000 * random_int(1,15)));
        });
    }
}
