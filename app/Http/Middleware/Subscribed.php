<?php

namespace App\Http\Middleware;

use App\Models\Company;
use App\Models\CompanyUser;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Subscribed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $company_id = $request->route()->parameter('id');
        $company = Company::find($company_id);
        $is_trial = $company->trial_ends_at > Carbon::now();
        if ($company->subscribed('default') || $is_trial) {
            return $next($request);
        } else {
            return redirect()->route('profile');
        }
    }
}
