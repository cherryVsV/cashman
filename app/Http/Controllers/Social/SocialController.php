<?php

namespace App\Http\Controllers\Social;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{

    public function index($driver)
    {
        return Socialite::driver($driver)->redirect();
    }

    public function callback($driver)
    {
        $userSocial = Socialite::driver($driver)->stateless()->user();
        $user = User::where(['email' => $userSocial->getEmail()])->first();
        if ($user) {
            Auth::login($user);
            return redirect("/user-profile");
        }
        return redirect("/complete-register-" . $userSocial->getEmail());
    }

    public function complete($email)
    {
        return view('auth.registerStepper', compact('email'));
    }

}
