<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $array = collect(
            $this->only(
                'id',
                'first_name',
                'last_name',
                'father_name',
                'gender',
                'birth_date',
                'phone',
                'identity_number',
            )
        )
        ->put('role', $this->role->name)
        ->all();

        return $array;
    }
}
