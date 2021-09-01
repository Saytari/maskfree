<?php

namespace App\Services;

use App\Models\User;

use Illuminate\Support\Collection;

class TakerService extends AbstractService
{
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function all()
    {
        return User::has('Taker')->get();
    }

    public function createModel(Collection $TakerData)
    {
        $user = $this->userService->create(
            $TakerData
            ->except('medical_notes')
            ->except('has_medical_job')
            ->put('role', 'taker')
            ->except('taker_type')


            ->all()
        );
      

        $user->taker()->create(
            $TakerData
            ->only('medical_notes')


            ->all()
        );
        $user->update(
            $TakerData
            ->only('password')
            ->all()
        );
        return $user ;
    }

    public function update( $taker,$takerData)
    {
        $taker->user->update(
            collect($takerData)
            ->except('medical_notes')
            ->except('has_medical_job')
            ->except('taker_type')
            ->all()
        );

        $taker->medical_notes = $takerData['medical_notes'];
        $taker->has_medical_job = $takerData['has_medical_job'];
        $taker->taker_type = $takerData['taker_type'];
    }

    public function delete($taker)
    {
        $taker->delete();
    }
   
}
