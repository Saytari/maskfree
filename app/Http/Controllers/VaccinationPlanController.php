<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\VaccinationPlanService;

class VaccinationPlanController extends Controller
{
    public function store(VaccinationPlanService $service, Request $request)
    {
        $algoData = collect($request->plan)->except([
            'first_date', 'last_date', 'pre', 'sym', 'asym'
        ]);

        $algoData['i0'] = [
            $request->plan['pre'],
            $request->plan['asym'],
            $request->plan['sym'],
        ];

        $algoData['contactRate'] = $this->getContactRate();

        $cdCommand = "cd " . storage_path('app\\public');

        $runCommand = "java -jar Algo.jar";

        \Storage::disk('public')->put('dataJson.json', json_encode($algoData));
        
        exec($cdCommand . " & " . $runCommand);

        $result = json_decode(\Storage::disk('public')->get('result.json'))->result;

        $service->createNewPlan($request, $result);

        return $this->successMessage();
    }

    protected function getContactRate()
    {
        return [[1.691899412142066,0.38109090871623286,0.4404172139607709,0.5775963461780598,0.23198344046210995,0.3042405776552255,0.15285000244108554,0.047147702547459217],
                [1.156196528388375,6.7514902704035125,1.1426091435671806,1.8784151762741836,1.427894522701207,2.1367639141204275,0.5164857041367577,0.22264985510302768],
                [1.556876468233312,1.3313262392681187,1.793489752820999,3.3865720565415205,0.812680717896993,1.795503670436118,0.4411985848965697,0.10378221256618753],
                [0.5104513010601041,0.547165105953449,0.8466430141353818,3.542156150310235,0.44887591760902956,2.3040583937708004,0.17191369913785687,0.0340389398128066],
                [0.7519940244569663,1.5256343543479562,0.7452251291617449,1.6464700407482058,1.2772297697237178,2.4911753760971074,0.46971363929492166,0.19693063241201086],
                [0.24655541785474264,0.5707565199469719,0.4116175101870504,2.1128127889355,0.6227938440242764,2.735320964210507,0.18461968440302623,0.06457304185009424],
                [0.4023460353003198,0.44811502800337155,0.32853263564541557,0.5120529631304562,0.38142577978034903,0.5996735133510736,1.0353957557417246,0.14383101963330774],
                [0.05366117111955141,0.08352547534729762,0.033414323111615005,0.043837497974195144,0.0691441564569017,0.09068875581001094,0.062189618800907745,0.1427289154931488]
        ];
    }
}
