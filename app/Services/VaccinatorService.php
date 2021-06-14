<?php

namespace App\Services;

use App\Models\User;
use App\Models\Manager;
use App\Models\Vaccinator;
use Illuminate\Support\Collection;

class VaccinatorService extends AbstractService
{
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function all()
    {
        $IDs = auth()->user()->manager->center->vaccinators->pluck('user.id');
        return User::whereIn('id', $IDs)->get();
    }

    public function createModel(Collection $vaccinatorData)
    {
        $user = $this->userService->create(
            $vaccinatorData
            ->except('center_id')
            ->put('role', 'vaccinator')
            ->all()
        );
        
        $user->vaccinator()->create([
            'center_id' => auth()->user()->manager->center->id
        ]);

        return $user;
    }

    public function update($vaccinator, $managerData)
    {
        $vaccinator->user->update(
            collect($managerData)
            ->all()
        );
    }

    public function delete($vaccinator)
    {
        $vaccinator->delete();
    }
}