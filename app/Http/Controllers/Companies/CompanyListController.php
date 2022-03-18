<?php

namespace App\Http\Controllers\Companies;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanyUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyListController extends Controller
{
    public function index()
    {
        return Company::orderBy('created_at', 'DESC')->get();

    }

    public function getSearchPage()
    {
        $user = Auth::user();
        return view('pages/companies/searchCompanyPage', compact('user'));
    }

    public function search()
    {
        return Company::latest()->paginate(8);

    }

    public function userCompanies($id)
    {
        $user = User::find($id);
        return $user->companies;
    }

    public function addUserCompany($id)
    {
        $company = Company::where('id', $id)->first();
        if (!$company->users()->where('user_id', Auth::user()->getAuthIdentifier())->exists()) {
            if ($company->creator_id === Auth::user()->getAuthIdentifier()) {
                $companyUser = CompanyUser::create([
                    'user_id' => Auth::user()->getAuthIdentifier(),
                    'company_id' => $id,
                    'role' => 'admin'
                ]);

            } else {
                $company->users()->attach(['user_id' => Auth::user()->getAuthIdentifier()]);
            }
        }
        return redirect('/user-profile');
    }
}
