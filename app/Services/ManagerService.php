<?php

namespace App\Services;

use App\Models\Role;
use App\Models\Manager;
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
        return Manager::with('user')->get();
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
        $manager->user->first_name = $managerData['first_name'];
        $manager->user->last_name = $managerData['last_name'];
        $manager->user->father_name = $managerData['father_name'];
        $manager->user->gender = $managerData['gender'];
        $manager->user->phone = $managerData['phone'];
        $manager->user->identity_number = $managerData['identity_number'];
        $manager->user->birth_date = $managerData['birth_date'];
        $manager->user->save();
        $manager->center_id = $managerData['center_id'];
        $manager->save();
    }
}
