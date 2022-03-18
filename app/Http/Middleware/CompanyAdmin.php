<?php

namespace App\Http\Middleware;

use App\Models\Company;
use App\Models\CompanyUser;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $company = $request->route()->parameter('id');
        $companyData = Company::find($company);
        $user = Auth::user()->getAuthIdentifier();
        $isAdmin = CompanyUser::where(['user_id' => $user, 'company_id' => $company, 'role' => 'admin'])->exists()
            || $companyData->creator_id == $user;
        if ($isAdmin) {
            return $next($request);
        } else {
            return redirect()->route('profile');
        }
    }
}
