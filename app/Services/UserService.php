<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use App\Models\Country;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

class UserService extends AbstractService
{
    public function all()
    {

    }
    
    public function createModel(Collection $userData)
    {
        $user = Role::firstWhere('name', $userData->get('role'))
        ->users()
        ->create(
            $userData
            ->except('role')
            ->put('password', Str::random(8))
            ->all()
        );

        return $user;
    }
}