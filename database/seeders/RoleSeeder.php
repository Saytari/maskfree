<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'master'
        ]);

        Role::create([
            'name' => 'manager'
        ]);

        Role::create([
            'name' => 'vaccinator'
        ]);

        Role::create([
            'name' => 'receptionist'
        ]);
        Role::create([
            'name' => 'taker'
        ]);
    }
}
