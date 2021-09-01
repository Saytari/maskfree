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
        $vaccinator->user->first_name = $managerData['first_name'];
        $vaccinator->user->last_name = $managerData['last_name'];
        $vaccinator->user->father_name = $managerData['father_name'];
        $vaccinator->user->gender = $managerData['gender'];
        $vaccinator->user->phone = $managerData['phone'];
        $vaccinator->user->identity_number = $managerData['identity_number'];
        $vaccinator->user->birth_date = $managerData['birth_date'];
        $vaccinator->user->save();
    }

    public function delete($vaccinator)
    {
        $vaccinator->delete();
    }
}