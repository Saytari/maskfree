<?php

namespace App\Services;
use App\Models\Plan;
use Carbon\Carbon;

class VaccinationPlanService
{

    public function createNewPlan($request, $result)
    {
        $plan = $this->createPlan($request);

        $categories = $this->createCategories($plan, $request);

        $this->createCategoriesStates($categories, $request);

        $phases = $this->createPhases($plan, $request);

        $this->createPriorities($categories, $phases, $result);
    }

    protected function createPlan($request)
    {
        return Plan::create([
            'start_date' => $request->plan['first_date'],
            'end_date' => $request->plan['last_date'],
            'daily_ratio' => $request->plan['v'],
            'pre_infection' => $request->plan['t'][0],
            'asym_infection' => $request->plan['t'][1],
            'sym_infection' => $request->plan['t'][2],
            'alpha' => $request->plan['alpha'],
            'transmission_ratio' => $request->plan['q'],
            'NPI_ratio' => $request->plan['theta'],
            'dExp' => $request->plan['dExp'],
            'dPre' => $request->plan['dPre'],
            'dSym' => $request->plan['dSym'],
            'dAsym' => $request->plan['dAsym'],
        ]);
    }

    protected function createCategories($plan, $request)
    {
        foreach ($request->categories as $category)
            $plan->categories()->create([
                'start_age' => $category['min'],
                'end_age' => $category['max'],
                "ratio" => 0.4
            ]);
        
        return $plan->categories;
    }

    protected function createCategoriesStates($categories, $request)
    {
        foreach ($categories as $categoryIndex => $category)
           $category->states()->create([
               'r0' => $request->plan['r0'][$categoryIndex],
               'p0' => $request->plan['p0'][$categoryIndex],
               'f0' => $request->plan['f0'][$categoryIndex],
               's0' => $request->plan['s0'][$categoryIndex],
               'e0' => $request->plan['e0'][$categoryIndex],
               'pre0' => $request->plan['pre'][$categoryIndex],
               'sym0' => $request->plan['sym'][$categoryIndex],
               'asym0' => $request->plan['asym'][$categoryIndex],
               'd0' => $request->plan['d0'][$categoryIndex],
           ]);
        
    }

    public function createPhases($plan, $request)
    {
        $phases = [];

        $start_date = $request->plan['first_date'];

        $total_days = Carbon::parse($request->plan['first_date'])
                        ->diffInDays(Carbon::parse($request->plan['last_date']));

        $phaseLength = $total_days / $request->plan['monthsCount'];

        for ($phaseIndex = 0; $phaseIndex < $request->plan['monthsCount']; ++$phaseIndex) {
            $last_date = Carbon::parse($start_date)->addDays($phaseLength);

            $phases[] = $plan->phases()->create([
                'start_date' => $start_date,
                'end_date' => $last_date > $request->plan['last_date'] ? $request->plan['last_date'] : $last_date
            ]);

            $start_date = Carbon::parse($last_date)->addDays(1);
        }

        return $phases;
    }

    public function createPriorities($categories, $phases, $result)
    {
        foreach($categories as $categoryIndex => $category)
            foreach($phases as $phaseIndex => $phase) {
                $category->priorties()->create([
                    'phase_id' => $phase->id,
                    'ratio' => $result[$phaseIndex][$categoryIndex] / 100
                ]);
            }
    }
}