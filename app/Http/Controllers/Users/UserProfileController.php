<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanyAdvertising;
use App\Models\CompanyUser;
use App\Models\HistoryUsersCompany;
use App\Models\Notification;
use App\Models\Product;
use App\Models\User;
use App\Models\UserProfile;
use App\Models\UsersFriedsByCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserProfileController extends Controller
{
    public function index()
    {

        $profile = (object)UserProfile::where('user_id', Auth::user()->getAuthIdentifier())->first();
        return view('pages.userProfile.userEditSection', compact('profile'));
    }

    public function updateUserProfileData(Request $request)
    {
        $this->validate($request, [
            'name' => ['string'],
            /* 'phone' => ['required', 'string'],
             'country' =>['required', 'string'],
             'region'=>['required', 'string'],
             'address'=>['required', 'string']*/
        ]);
        $profile = UserProfile::find($request->id);
        $profile->name = $request->name;
        $profile->phone = $request->phone;
        $profile->country = $request->country;
        $profile->region = $request->region;
        $profile->address = $request->address;
        $profile->messengers = $request->messengers;
        if ($profile->avatar != $request->avatar) {
            $profile->avatar = 'avatar/' . $request->avatar;
        }
        $profile->save();
        $user = User::find($profile->user_id);
        if ($user->avatar != $request->avatar) {
            $user->avatar = 'avatar/' . $request->avatar;
            $user->save();
        }
        return response()->json(null, 200);

    }

    public function getAuthUser()
    {
        $profile = Auth::user();
        $company = $profile->companies()->get();
        if ($company) {
            $ids = $company->pluck('id');
            $news = CompanyAdvertising::where('type', 'Баннер')->whereIn('company_id', $ids)->get();
            $stories = CompanyAdvertising::where('type', 'Сторис')->whereIn('company_id', $ids)->get();
        } else {
            $company = Company::latest()->get();
            $news = CompanyAdvertising::where('type', 'Баннер')->get();
            $stories = CompanyAdvertising::where('type', 'Сторис')->get();
        }
        $cashbackCompanies = HistoryUsersCompany::where('user_id', $profile->id)->distinct('company_id')->pluck('company_id');
        $actions = Notification::where('user_id', $profile->id)->latest()->limit(6)->get();
        $cashback = [];
        foreach($cashbackCompanies as $c){
            $debitings = HistoryUsersCompany::where(['user_id'=>$profile->id, 'company_id'=>$c, 'type->ru'=>'Начисление'])->sum('value');
            $offs = HistoryUsersCompany::where(['user_id'=>$profile->id, 'company_id'=>$c, 'type->ru'=>'Списание'])->sum('value');
            $score = 0;
            $money = HistoryUsersCompany::where(['user_id'=>$profile->id,'company_id'=>$c ])->sum('money_in_check');
            if($debitings>$offs){
                $score = round($debitings-$offs,2);
            }
            $cashback[] = [
                'company_id'=>$c,
                'image'=>Company::where('id', $c)->value('image'),
                'value'=>$score,
                'money_in_check'=>$money,
                'description'=>'Суммарный кэшбек от компании',
                'type'=>$offs
            ];
        }
        return view('pages/userProfile/userProfilePage', compact('profile', 'company',
            'news', 'stories', 'cashback', 'actions'));
    }

    public function getUserSettings()
    {
        $user = Auth::user();
        return view('pages/userProfile/userSettingsPage', compact('user'));
    }

    public function uploadAvatar(Request $request)
    {
        $fileName = time() . '.' . $request->file->getClientOriginalExtension();
        $request->file->move(public_path('assets/sample/avatar'), $fileName);

        return response()->json(['file' => $fileName]);
    }

    public function getProfileData($id)
    {
        $profile = (object)UserProfile::where('user_id', $id)->first();
        $user = User::find($id);
        $profile['email'] = $user->email;
        $friendsIds = UsersFriedsByCompany::where('parent_id', $id)->pluck('user_id');
        $friends = UserProfile::whereIn('id', $friendsIds)->get();
        return response()->json([
            'profile' => $profile,
            'friends' => $friends
        ]);
    }

    public function getProducts($id)
    {
        $profile = User::find($id);
        $company = $profile->companies()->get();
        if ($company) {
            $ids = $company->pluck('id');
            $products = Product::whereIn('company_id', $ids)->limit(30)->get();
        } else {
            $products = Product::latest()->limit(30)->get();
        }
        return response()->json([
            'products' => $products
        ]);
    }

    public function changeUserEmail(Request $request)
    {
        $this->validate($request, [
            'id' => ['required', 'exists:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users']
        ]);
        $user = User::find($request->id);
        $user->email = $request->email;
        $user->save();
        return response()->json(['status' => 'success']);

    }

    public function changeUserAvatar(Request $request)
    {
        $this->validate($request, [
            'id' => ['required', 'exists:users'],
            'avatar' => ['required', 'string']
        ]);
        $profile = UserProfile::where('user_id', $request->id)->first();
        if ($profile->avatar != $request->avatar) {
            $profile->avatar = 'avatar/' . $request->avatar;
            $profile->save();
            return response()->json(['status' => 'success']);
        }
        return response()->json(['status' => 'error']);
    }


}
