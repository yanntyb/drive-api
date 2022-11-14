<?php

namespace App\Console\Commands\Database;

use App\Models\User;
use App\Services\ConfigService;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class Init extends Command
{

    private array $roles;
    private array $permissions;

    public function __construct()
    {

        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialise la base de donnée';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        foreach($this->roles as $role){
            if(Role::query()->where("name", $role)->count()) continue;
            Role::create(["name" => $role])->save();
            $this->info("Creation du role " . $role);
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

        return Command::SUCCESS;
    }
}
