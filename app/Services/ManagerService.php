<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use App\Models\Country;
use Illuminate\Support\Collection;

class ManagerService extends AbstractService
{
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function all()
    {
        return User::has('manager')->get();
    }

    public function createModel(Collection $managerData)
    {
        $user = $this->userService->create(
            $managerData
            ->except('center_id')
            ->put('role', 'manager')
            ->all()
        );
        
        $user->manager()->create(
            $managerData
            ->only('center_id')
            ->all()
        );

        return $user;
    }

    public function update($manager, $managerData)
    {
        $manager->user->update(
            collect($managerData)
            ->except('center_id')
            ->all()
        );

        $manager->center_id = $managerData['center_id'];
    }
}