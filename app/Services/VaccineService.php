<?php

namespace App\Services;

use App\Models\Vaccine;
use Illuminate\Support\Collection;

class VaccineService extends AbstractService
{
    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }

    public function all()
    {
        return Vaccine::all();
    }

    protected function createModel(Collection $vaccineData)
    {
        $country = $this->countryService->firstOrCreate([
            'name' => $vaccineData->get('country')
        ]);

        $vaccine = $country->vaccines()->create(
            $vaccineData
            ->except(['country', 'total_doses'])
            ->all()
        );
        
        $vaccine->doses()->createMany(
            $this->prepareDoses(1, $vaccineData->get('total_doses'))
        );

        return $vaccine;
    }

    protected function prepareDoses($startNumber, $totalToPrepare)
    {
        $dosesData = [];

        $endNumber = $totalToPrepare;

        foreach (range($startNumber, $endNumber) as $doseNumber) {

            $dosesData[$doseNumber - 1] = [
                'number_in_row' => $doseNumber
            ];

        }

        return $dosesData;
    }

    public function update(Vaccine $vaccine, $updateData)
    {
        $country = $this->countryService->firstOrCreate([
            'name' => $updateData['country']
        ]);

        $vaccine->update(
            collect($updateData)->except(['country', 'total_doses'])
            ->put('country_id', $country->id)
            ->all()
        );

        $totalDoses = $updateData['total_doses'];

        if ($vaccine->doses->max('number_in_row') > $totalDoses)
            $vaccine->doses()->whereNotBetween("number_in_row", [1, $totalDoses])->delete();
        else if ($vaccine->doses->max('number_in_row') < $totalDoses) {
            $dosesToAdd = $this->prepareDoses($vaccine->doses->max('number_in_row') + 1, $totalDoses);
            
            $vaccine->doses()->createMany($dosesToAdd);
        }
    }
    
    public function removeExtraDoses($vaccine, $dosesToRemove)
    {
        $vaccine->doses()->whereIn(
            $dosesToRemove->pluck('id')
         )->delete();
    }

    public function delete(Vaccine $vaccine)
    {
        $vaccine->delete();
    }
}