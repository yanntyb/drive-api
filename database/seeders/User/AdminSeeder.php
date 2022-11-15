<?php

namespace Database\Seeders\User;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        User::query()->create([
            "name" => "Admin",
            "email" => "support@drive.com",
            "password" => Hash::make("support"),
        ])->assignRole("admin");
    }
}
