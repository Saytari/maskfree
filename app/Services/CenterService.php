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

        return $center;
    }

    /**
     * @param App\Models\Center
     * @param Array
     */
    public function update($center, $updateData)
    {
        $city = $this->cityService->firstOrCreate([
            'name' => $updateData['city']
        ]);

        $phonesToUpdate = collect($updateData['phones'])->map(function($value, $key) {
            return ['number' => $value];
        });

        $center->phones()->delete();

        $center->phones()->createMany(
            $phonesToUpdate->all()
        );
    }

    public function delete($center)
    {
        $center->delete();
    }
    /*
    public function getCenteropenningTime($center)
    {
      $center_day=Center_day::where('center_id', '=', $center->id)->first();
      $center_day_period=Center_Day_Period::where('center_day_id','=',$center_day->id);
      return $center_day_period->openning_time;
    }
    public function getCenterclosingTime($center)
    {
      $center_day=Center_day::where('center_id', '=', $center->id)->first();
      $center_day_period=Center_Day_Period::where('center_day_id','=',$center_day->id);
      return $center_day_period->closingTime_time;
    }
    */
}
