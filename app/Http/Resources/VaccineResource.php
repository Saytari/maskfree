<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VaccineResource extends JsonResource
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
            'name' => $this->name,
            'country' => $this->country->name,
            'efficiency' => $this->efficiency,
            'period_between_doses' => $this->period_between_doses,
            'immunization' => $this->immunization,
            'total_doses' => $this->totalDoses,
        ];
    }
}
