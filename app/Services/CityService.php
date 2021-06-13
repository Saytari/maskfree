<?php

namespace App\Services;

use App\Models\City;
use Illuminate\Support\Collection;

class CityService extends AbstractService
{
    public function all()
    {

    }

    protected function firstOrCreateModel(Collection $cityData)
    {
        $city = City::firstOrCreate([
            'name' => $cityData->get('name')
        ]);

        return $city;
    }
}