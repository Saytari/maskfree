<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class RequestResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $array = collect(
            $this->only(
                'user_id',
                'center_id',
                'request_date'
            )
        )

        ->all();
        return $array;
    }
}
