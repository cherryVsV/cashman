<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Tariff;
use Carbon\Carbon;
use Illuminate\Http\Request;



class TariffController extends Controller
{
    public function getPage($id){
        $company = Company::find($id);
        $tariffs = Tariff::get();
        $intent = Company::find($id)->createSetupIntent();
        $plan = $this->getCurrentPlan($company);
        return view('pages.companyProfile.Admin.companyTariffs', compact('company', 'tariffs', 'intent', 'plan'));
    }


    public function store(Request $request) {
        $this->validate($request, [
            'token' => 'required'
        ]);

        $plan = Tariff::where('identifier', $request->plan)
            ->first();
        $company = Company::find($request->company['id']);
        if($company->subscribed('default')){
            $company->subscription('default')->swap($plan->stripe_id);
        }else {
            $company->newSubscription('default', $plan->stripe_id)->create($request->token);
        }
        $company->tariff_id = $plan->id;
        $company->save();
        $plan = $this->getCurrentPlan($company);
        return response()->json(['plan' => $plan]);
    }

    public function cancel(Request $request){
        $company = Company::find($request->company['id']);
        $company->subscription('default')->cancel();
        $plan = $this->getCurrentPlan($company);
        return response()->json(['plan' => $plan]);
    }

    public function resume(Request $request){
        $company = Company::find($request->company['id']);
        $company->subscription('default')->resume();
        $plan = $this->getCurrentPlan($company);
        return response()->json(['plan' => $plan]);
    }

    public function getCurrentPlan($company){
        $plan = null;
        if($company->subscribed('default') || $company->subscription('default')->onGracePeriod()){
            $tmp = Tariff::find($company->tariff_id);
            $plan = (object) ['name' => $tmp->title,
                'sum'=>$tmp->money,
                'expired_at'=>$company->trial_ends_at,
                'is_active'=>!$company->subscription('default')->cancelled()];
        }
        return $plan;
    }
}
