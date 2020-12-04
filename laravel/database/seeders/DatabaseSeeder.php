<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $ownerRole = new Role();
        $ownerRole->name = 'Eigenaresse';
        $ownerRole->identifier = 'owner';
        $ownerRole->save();

        $employeeRole = new Role();
        $employeeRole->name = 'Medewerker';
        $employeeRole->identifier = 'employee';
        $employeeRole->save();

        \App\Models\User::factory(1)->create([
            'role_id' => 1,
        ]);
        \App\Models\Treatment::factory(4)->create();
    }
}
