<?php

namespace App\Http\Controllers;
use App\Models\Taker;
use App\Models\User;
use App\Services\TakerService;
use App\Services\RequestService;
use App\Services\AppointmentService;

use App\Http\Resources\UserResource;
use App\Http\Requests\StoreTaker;
use App\Http\Requests\UpdateTaker;
use Illuminate\Http\Request;

class TakerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( TakerService $takerService)
    {
        $takers = $takerService->all();

        return UserResource::collection($takers);
        //
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTaker $request, TakerService $takerService)
    {
        $takerService->create($request->all());

        return $this->successMessage();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Taker $taker )
    {
        return new UserResource($taker->user);
    }
    public function showMyProfile()
    {
        $taker=Auth()->user();
        return new UserResource($taker);
    }
   



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTaker $request, Taker $taker,TakerService $takerService)
    {
        $takerService->update($taker, $request->all());

        return $this->successMessage();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Taker $taker, TakerService $takerService)
    {
        $takerService->delete($taker);

        return $this->successMessage();
    }
    
    public function hasRequest(User $user,RequestService $requestService){
        return $requestService->userHasRequest($user);
    }
    public function hasAppointment(User $user,AppointmentService $appointementService){
        return $appointementService->userHasAppointment($user);
    }
    public function couldOrder()
    {
        $centersTotalDosesInThisMonth = $this->calculateTotalCentersDosesInThisMonth();

        $categoryTakenDosesInThisMonth = $this->calculateCategoryTotalDoses();

        $userCategoryPriority = $this->getUserCategoryPriority();

        $couldOrder = ($categoryTakenDosesInThisMonth / $userCategoryPriority) <= $centersTotalDosesInThisMonth;

        return [
            'message' => $couldOrder
        ];
    }

    protected function calculateTotalCentersDosesInThisMonth()
    {
        $totalDoses = 0;

        $totalDays = 0;

        $centers = \App\Models\Center::with('centerDoses')->withCount('days as totalDays')->get();

        foreach ($centers as $center) {
            $totalDays = $center->totalDays;

            foreach($center->centerDoses as $centerDose)
                $totalDoses += $centerDose->daily_total;
        }

        // Approximatly, it should calculate the currency of every day in this month
        $totalDays = 4 * $totalDays;

        return $totalDays * $totalDoses;

    }

    protected function calculateCategoryTotalDoses()
    {
        $user = auth()->user();

        $userAge = \Carbon\Carbon::createFromDate($user->birth_date)->diffInYears(\Carbon\Carbon::now());

        $phase = \App\Models\Phase::orderBy('created_at', 'desc')
                                      ->where('start_date', "<=", \Carbon\Carbon::now())
                                      ->where('end_date', '>=', \Carbon\Carbon::now())
                                      ->first();

        $category = \App\Models\Category::orderBy('created_at', 'desc')
                                            ->where('start_age', "<=", $userAge)
                                            ->where('end_age', '>=', $userAge)
                                            ->first();
        
        $thisMonthAppointment = \App\Models\Appointment::with('user')
                                                        ->where('appointment_date', '>=', new \Carbon\Carbon('first day of this month'))
                                                        ->where('appointment_date', '<=', new \Carbon\Carbon('last day of this month'))
                                                        ->get();

        $totalCategoryDosesInThisMonth = 0;

        foreach($thisMonthAppointment as $app) {
            $apoUserAge = \Carbon\Carbon::createFromDate($app->$user->birth_date)->diffInYears(\Carbon\Carbon::now());
            
            if ($category->start_age <= $apoUserAge && $category->end_age >= $userAge)
                $totalCategoryDosesInThisMonth++;
        }

        return $totalCategoryDosesInThisMonth;     
    }

    public function getUserCategoryPriority()
    {
        $userAge =  \Carbon\Carbon::createFromDate(auth()->user()->birth_date)->diffInYears(\Carbon\Carbon::now());

        $priority = \App\Models\Category::orderBy('created_at', 'desc')
                                            ->where('start_age', "<=", $userAge)
                                            ->where('end_age', '>=', $userAge)
                                            ->first()
                                            ->priorties()
                                            ->where('phase_id', $phase->id)
                                            ->first();
        return $priority->ratio;
    }
}
