<?php

namespace Database\Seeders\User;

use App\Models\User;
use Database\Seeders\User\Role\RoleSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
    }
}
