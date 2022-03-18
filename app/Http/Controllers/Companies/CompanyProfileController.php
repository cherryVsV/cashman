<?php

namespace App\Http\Controllers\Companies;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanyAdvertising;
use App\Models\CompanyUser;
use App\Models\Product;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyProfileController extends Controller
{
    public function getCompanyData($id)
    {
        $company = (object)Company::where('id', $id)->first();
        $user = null;
        $isAdmin = false;
        if (Auth::check()) {
            $isAdmin = CompanyUser::where(['company_id' => $company->id, 'user_id' => Auth::user()->getAuthIdentifier(),
                    'role' => 'admin'])->exists() || $company->creator_id == Auth::user()->getAuthIdentifier();
            $user_id = Auth::user()->getAuthIdentifier();
            $user = User::find($user_id);
        }
        $usersIds = CompanyUser::where('company_id', $company->id)->pluck('user_id');
        $users = UserProfile::whereIn('user_id', $usersIds)->get();
        $news = $company->advertising()->where('type', 'Баннер')->get();
        $stories = $company->advertising()->where('type', 'Сторис')->get();
        if ($isAdmin) {
            $user['isActive'] = CompanyUser::where(['company_id' => $id, 'user_id' => $user->id, 'role' => 'admin'])->value('isActive');
        }
        return view('pages/companyProfile/companyProfilePage', compact('company',
            'news', 'users', 'stories', 'isAdmin', 'user'));
    }

    public function getActiveAdmins($id)
    {
        $adminIds = CompanyUser::where(['company_id' => $id, 'role' => 'admin', 'isActive' => true])->pluck('user_id');
        $admins = UserProfile::whereIn('id', $adminIds)->get();
        foreach ($admins as $admin) {
            $admin['email'] = User::where('id', $admin->user_id)->value('email');
        }
        $products = Product::where('company_id', $id)->get();
        return response()->json([
            'admins' => $admins,
            'products' => $products
        ]);

    }

    public function getUserCompanyPromocode($user, $company)
    {
        $operation_code = '000';
        $user_id = str_pad($user, 10, "0", STR_PAD_LEFT);
        $company_id = str_pad($company, 10, "0", STR_PAD_LEFT);
        $data = 'https://your-cashman.com/qr-handler/data=' . base64_encode($operation_code . $user_id . $company_id);
        return response()->json([
            'code' => $data
        ]);
    }
}
