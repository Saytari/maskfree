<?php

namespace App\Policies;

use App\Models\Receptionist;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ReceptionistPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Receptionist  $receptionist
     * @return mixed
     */
    public function view(User $user, Receptionist $receptionist)
    {
        return $user->manager->center->receptionists->contains($receptionist)
                ? Response::allow()
                : Response::deny('The receptionist does not work in the manager center');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->role->name === "manager"
                ? Response::allow()
                : Response::deny('This action is only for managers');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Receptionist  $receptionist
     * @return mixed
     */
    public function update(User $user, Receptionist $receptionist)
    {
        return $user->manager->center->receptionists->contains($receptionist)
                ? Response::allow()
                : Response::deny('The receptionist does not work in the manager center');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Receptionist  $receptionist
     * @return mixed
     */
    public function delete(User $user, Receptionist $receptionist)
    {
        return $user->manager->center->receptionists->contains($receptionist)
                ? Response::allow()
                : Response::deny('The receptionist does not work in the manager center');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Receptionist  $receptionist
     * @return mixed
     */
    public function restore(User $user, Receptionist $receptionist)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Receptionist  $receptionist
     * @return mixed
     */
    public function forceDelete(User $user, Receptionist $receptionist)
    {
        //
    }
}
