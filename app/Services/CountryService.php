<?php

namespace App\Services;

use App\Models\Country;
use Illuminate\Support\Collection;

class CountryService extends AbstractService
{
    public function all()
    {
        return Country::all();
    }

    protected function createModel(Collection $countryData)
    {
        return Country::create($countryData->toArray());
    }

    protected function firstOrCreateModel(Collection $countryData)
    {
        return Country::firstOrCreate($countryData->toArray());
    }
}