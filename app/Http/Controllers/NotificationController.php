<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function savePushNotificationToken(Request $request)
    {
        auth()->user()->update(['device_token' => $request->token]);
        return response()->json(['status' => 200]);
    }

}
