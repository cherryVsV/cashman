<?php

namespace App\Http\Controllers\Companies;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanyUser;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyAuthController extends Controller
{
    /**
     * @param Request $request
     */

    public function register(Request $request)
    {
        $result = [];
        $this->validate($request, [
            'title' => ['required', 'string'],
            'domain' => ['required', 'string', 'unique:companies'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'image' => ['required'],
            'description' => ['required', 'string'],
            'position' => ['required', 'string'],
            'confirmed' => ['accepted']
        ]);
        $address = $request->position;
        $ch = curl_init('https://geocode-maps.yandex.ru/1.x/?apikey=865b6aaf-1477-4185-ac17-c503079aa759&format=json&geocode=' . urlencode($address));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $res = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($res, true);
        $coordinates = $res['response']['GeoObjectCollection']['featureMember'][0]['GeoObject']['Point']['pos'];
        $coordinates = explode(' ', $coordinates);

        $company = Company::create(['title' => $request->title,
            'domain' => $request->domain,
            'password' => md5($request->password),
            'image' => 'companyLogos/' . $request->image,
            'description' => $request->description,
            'company_group_id' => 1,
            'latitude' => (float)$coordinates[1],
            'longitude' => (float)$coordinates[0],
            'creator_id' => Auth::user()->getAuthIdentifier(),
            'socials' => [
                'vk' => '',
                'telegram' => '',
                'instagram' => '',
                'facebook' => '',
                'youtube' => '',
            ],
            'properties' => [
                'time' => '',
                'address' => ''
            ]
        ]);
        $company->trial_ends_at = Carbon::now()->addDays(3);
        $company->save();
        $companyUser = CompanyUser::create([
            'user_id' => Auth::user()->getAuthIdentifier(),
            'company_id' => $company->id,
            'role' => 'admin'
        ]);
        $result['href'] = route('completeCompanyRegistration', ['id' => $company->id]);
        return response()->json($result);

    }

    /**
     * @param Request $request
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $result = [];
        $this->validate($request, [
            'domain' => ['required', 'string', 'exists:companies'],
            'password' => ['required', 'string']
        ]);
        $company = Company::where('domain', $request->domain)->first();
        $isAdmin = CompanyUser::where(['company_id' => $company->id, 'user_id' => Auth::user()->getAuthIdentifier(),
            'role' => 'admin'])->exists();
        if ($company->password == md5($request->password) && ($isAdmin || $company->creator_id == Auth::user()->getAuthIdentifier())) {
            $result['href'] = route('company-profile', ['id' => $company->id]);
            return response()->json($result);
        }
        $result['error'] = 'Ошибка при вводе домена компании или пароля!';
        return response()->json($result);

    }

    public function completeRegistration($id)
    {
        $company = Company::find($id);
        return view('auth/companyAuth/RegisterCompanyStepper', compact('company'));
    }
}
