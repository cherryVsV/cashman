<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\CompanyUser;
use App\Models\UserProfile;
use App\Models\UsersFriedsByCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserFriendsController extends Controller
{
    public function getUserFriendsPage()
    {
        $user = Auth::user()->getAuthIdentifier();
        $friendsIds = UsersFriedsByCompany::where('parent_id', $user)->latest()->pluck('user_id');
        $friends = UserProfile::whereIn('id', $friendsIds)->get();
        foreach ($friends as $friend) {
            $friend['date'] = UsersFriedsByCompany::where(['parent_id' => $user, 'user_id' => $friend->id])->value('created_at');
        }
        return view('pages/userProfile/friends/userFriendsPage', compact('friends'));
    }

    public function getUserFriendsTreePage($company)
    {
        $id = Auth::user()->getAuthIdentifier();
        $user = UserProfile::where('user_id', $id)->first();
        $friendsIds = UsersFriedsByCompany::where(['parent_id' => $user->user_id, 'company_id' => $company])->pluck('user_id');
        $userFriends = UserProfile::whereIn('id', $friendsIds)->get();
        $friends = [];
        foreach ($userFriends as $friend) {
            $children = [];
            $friendsIds2 = UsersFriedsByCompany::where(['parent_id' => $friend->user_id, 'company_id' => $company])->pluck('user_id');
            $friends2 = UserProfile::whereIn('id', $friendsIds2)->get();
            if (UsersFriedsByCompany::where(['parent_id' => $friend->user_id, 'company_id' => $company])->exists()) {
                foreach ($friends2 as $friend2) {
                    $children[] = ['name' => $friend2->name,
                        'image_url' => '../assets/sample/' . $friend2->avatar];
                }
            }
            $friends[] = [
                'name' => $friend->name,
                'image_url' => '../assets/sample/' . $friend->avatar,
                'children' => $children
            ];
        }
        if (count($friends) > 0) {
            $treeData = [
                'name' => $user->name,
                'image_url' => '../assets/sample/' . $user->avatar,
                'class' => ["rootNode"],
                'children' => $friends
            ];
        } else {
            $treeData = null;
        }


        return view('pages/userProfile/friends/usersFriendsTreePage', compact('treeData', 'id', 'company'));
    }


}
