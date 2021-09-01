<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ManagerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'first_name' => $this->user->first_name,
            'last_name' => $this->user->last_name,
            'father_name' => $this->user->father_name,
            'gender' => $this->user->gender,
            'birth_date' => $this->user->birth_date,
            'phone' => $this->user->phone,
            'identity_number' => $this->user->identity_number,
            'center_id' => $this->center_id
        ];
    }
}
