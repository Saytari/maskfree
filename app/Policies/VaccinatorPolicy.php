<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Vaccinator;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\Response;
use Illuminate\Auth\Access\HandlesAuthorization;

class VaccinatorPolicy
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
     * @param  \App\Models\Vaccinator  $vaccinator
     * @return mixed
     */
    public function view(User $user, Vaccinator $vaccinator)
    {
        return $user->manager->center->vaccinators->contains($vaccinator)
                ? Response::allow()
                : Response::deny('The vaccinator does not work in the manager center');
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
     * @param  \App\Models\Vaccinator  $vaccinator
     * @return mixed
     */
    public function update(User $user, Vaccinator $vaccinator)
    {
        return $user->manager->center->vaccinators->contains($vaccinator)
                ? Response::allow()
                : Response::deny('The vaccinator does not work in the manager center');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Vaccinator  $vaccinator
     * @return mixed
     */
    public function delete(User $user, Vaccinator $vaccinator)
    {
        return $user->manager->center->vaccinators->contains($vaccinator)
                ? Response::allow()
                : Response::deny('The vaccinator does not work in the manager center');
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Vaccinator  $vaccinator
     * @return mixed
     */
    public function restore(User $user, Vaccinator $vaccinator)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Vaccinator  $vaccinator
     * @return mixed
     */
    public function forceDelete(User $user, Vaccinator $vaccinator)
    {
        return false;
    }
}
