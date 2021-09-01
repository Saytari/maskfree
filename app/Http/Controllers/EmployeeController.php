<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\EmployeeResource;
use App\Http\Requests\UpdateUser;
use App\Models\User;

class EmployeeController extends Controller
{
    public function index()
    {
        $Vids = collect(auth()->user()->manager->center->vaccinators->pluck('user_id'));

        $Rids = collect(auth()->user()->manager->center->receptionists->pluck('user_id'));

        $employees = User::whereIn('id', $Vids->merge($Rids))->get();

        return EmployeeResource::collection($employees);
    }

    public function show(User $user)
    {
        abort_if($user->role->name != 'vaccinator' && $user->role->name != 'receptionist', 404);
        return new EmployeeResource($user);
    }

    public function update(Request $request, User $user)
    {
        $user->first_name = $request['first_name'];
        $user->last_name = $request['last_name'];
        $user->father_name = $request['father_name'];
        $user->gender = $request['gender'];
        $user->phone = $request['phone'];
        $user->identity_number = $request['identity_number'];
        $user->birth_date = $request['birth_date'];
        $user->save();

        return $this->successMessage();
    }
}
