<?php

namespace App\Services;

use App\Models\User;
use App\Models\Manager;
use App\Models\Receptionist;
use Illuminate\Support\Collection;

class ReceptionistService extends AbstractService
{
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function all()
    {
       $IDs = auth()->user()->manager->center->receptionists->pluck('user.id');
        return User::whereIn('id', $IDs)->get();
    }

    public function createModel(Collection $receptionistData)
    {
        $user = $this->userService->create(
            $receptionistData
            ->except('center_id')
            ->put('role', 'receptionist')
            ->all()
        );
        
        $user->receptionist()->create([
            'center_id' => auth()->user()->manager->center->id
        ]);

        return $user;
    }

    public function update($receptionist, $updatedData)
    {
        $receptionist->user->update(
            collect($updatedData)
            ->all()
        );
    }

    public function delete($receptionist)
    {
        $receptionist->delete();
    }
}