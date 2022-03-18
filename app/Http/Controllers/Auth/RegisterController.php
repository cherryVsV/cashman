<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Notification;
use App\Models\UserProfile;
use App\Models\UsersFriedsByCompany;
use App\Notifications\RealTimeNotification;
use App\Providers\RouteServiceProvider;
use App\Models\User;

use Illuminate\Foundation\Auth\RegistersUsers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'submitted' => ['accepted']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $parent_id = session('user');
        $company_id = session('company');
        $user = User::create([
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        $profile = UserProfile::create([
            'user_id' => $user->id,
            'avatar' => 'avatar/avatar1.jpg',
            'messengers' => [
                'vk' => null,
                'telegram' => null,
                'instagram' => null,
                'facebook' => null,
                'youtube' => null
            ]
        ]);
        if ($parent_id != null && $company_id != null) {
            $company = Company::where('id', $company_id)->first();
            UsersFriedsByCompany::create(['user_id' => $user->id,
                'company_id' => $company_id, 'parent_id' => $parent_id]);
            $company->users()->attach(['user_id' => $user->id]);
            $parent = User::find($parent_id);
            if (!is_null($user->device_token)) {
                if ($data['lang'] == 'ru') {
                    $parent->notify(new RealTimeNotification('У вас появился новый друг по компании  ' . $company['title'],
                        'От компании ' . $company['title'],
                        'assets/sample/' . $company['image'], $parent->device_token));
                } else {
                    $parent->notify(new RealTimeNotification('You have a new friend in the company  ' . $company['title'],
                        'Company ' . $company['title'],
                        'assets/sample/' . $company['image'], $parent->device_token));
                }
            }
            Notification::create([
                'title' => ['ru'=>'У вас появился новый друг!', 'en'=>'You have a new friend!'],
                'description' => ['ru'=>'Вы сможете получать многоуровневый кэшбек от покупок данного пользователя в данной компании',
                    'en'=>'You will be able to receive multi-level cashback from purchases of this user in this company'],
                'user_id' => $parent_id,
                'notification_type' => ['ru'=>'Добавление рефералла', 'en'=>'Adding a referral'],
                'object_id' => $user->id,
                'object_type' => 'user'
            ]);
        }
        return $user;
    }

}
