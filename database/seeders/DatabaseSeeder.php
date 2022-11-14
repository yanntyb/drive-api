<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->roles as $role){
            if(Role::query()->where("name", $role)->count()) continue;
            Role::create(["name" => $role])->save();
        }
        $roles = Role::all();
        $roles->each(function(Role $role){

        });

        $support = User::query()->create([
            "name" => "support",
            "email" => "drive@support.fr",
            "password" => Hash::make("support"),
        ]);
        $support->save();
        $support->assignRole(Role::all());
    }
}
