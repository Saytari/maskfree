<?php

namespace App\Services;

use App\Models\Center;
use Illuminate\Support\Collection;

class CenterService extends AbstractService
{
    public function __construct(CityService $cityService)
    {
        $this->cityService = $cityService;
    }

    public function all()
    {
        return Center::all();
    }

    protected function createModel(Collection $centerData)
    {
        $city = $this->cityService->firstOrCreate([
            'name' => $centerData->get('city')
        ]);

        $center = $city->centers()->create(
            $centerData->except(['city', 'phones'])->all()
        );

        $center->phones()->createMany(
            collect($centerData->get('phones'))->map(function($value) {
                return ['number' => $value];
            })->all()
        );

        $this->createDosesForCenters($center);
        $this->createDaysForCenter($center);
        return $center;
    }

    /**
     * @param App\Models\Center
     * @param Array
     */
    public function update($center, $updateData)
    {
        $center->name = $updateData['name'];

        $center->street = $updateData['street'];

        $city = $this->cityService->firstOrCreate([
            'name' => $updateData['city']
        ]);

        $center->city_id = $city->id;

        $phonesToUpdate = collect($updateData['phones'])->map(function($value, $key) {
            return ['number' => $value];
        });

        $center->phones()->delete();

        $center->phones()->createMany(
            $phonesToUpdate->all()
        );

        $center->save();
    }
    
    public function delete($center)
    {
        $center->delete();
    }

    public function createDosesForCenters($center)
    {
        $vaccines = \App\Models\Vaccine::all();

        foreach($vaccines as $vaccine)
            foreach($vaccine->doses as $dose) {
                $centerDose = new \App\Models\CenterDose();
                $centerDose->dose_id = $dose->id;
                $centerDose->center_id = $center->id;
                $centerDose->save();
            }
    }

    public function createDaysForCenter($center)
    {
        foreach (\App\Models\Day::all() as $day)
            $center->days()->create([
                'day_id' => $day->id
            ]);

        foreach ($center->days as $day)
            $day->periods()->create([
                'openning_time' => '07:00:00',
                'closeing_time' => '19:00:00'
            ]);
    }
}