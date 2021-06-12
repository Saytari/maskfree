<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Master;
use Illuminate\Database\Seeder;

class MasterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'first_name' => env('MASTER_FIRST_NAME'),
            'last_name' => env('MASTER_LAST_NAME'),
            'father_name' => env('MASTER_FATHER_NAME'),
            'gender' => env('MASTER_GENDER'),
            'birth_date' => env('MASTER_BIRTH_DATE'),
            'phone' => env('MASTER_PHONE'),
            'identity_number' => env('MASTER_IDENTITY_NUMBER'),
            'password' => env('MASTER_PASSWORD'),
            'role_id' => Role::firstWhere('name', 'master')->id
        ]);

        Master::create([
            'user_id' => $user->id
        ]);
    }
}
