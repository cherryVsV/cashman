<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanyUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyActionMenuController extends Controller
{
    public function index($id)
    {
        $company = Company::find($id);
        $isAdmin = CompanyUser::where(['company_id' => $company->id, 'user_id' => Auth::user()->getAuthIdentifier(),
                'role' => 'admin'])->exists() || $company->creator_id == Auth::user()->getAuthIdentifier();
        if ($isAdmin) {
            $admin = Auth::user()->getAuthIdentifier();
            return view('pages/companyProfile/Admin/CompanyActionMenu', compact('company', 'admin'));
        }
        return redirect()->back();
    }

    public function adminMenu($id)
    {
        return view('pages/companyProfile/Admin/companyAdminMenuPage', compact('id'));
    }
}
