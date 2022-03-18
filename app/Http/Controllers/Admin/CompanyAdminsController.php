<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyUser;
use App\Models\Notification;
use App\Models\User;
use App\Models\UserProfile;
use App\Notifications\RealTimeNotification;
use Illuminate\Http\Request;

class CompanyAdminsController extends Controller
{
    public function getCompanyGroupAdmin($id)
    {
        $adminIds = CompanyUser::where(['company_id' => $id, 'role' => 'admin'])->pluck('user_id');
        $admins = UserProfile::whereIn('id', $adminIds)->get();
        foreach ($admins as $admin) {
            $admin['isActive'] = CompanyUser::where(['company_id' => $id, 'user_id' => $admin->user_id, 'role' => 'admin'])->value('isActive');
        }
        return view('pages/companyProfile/Admin/CompanyGroupAdmin', compact('admins'));
    }

    public function addCompanyAdmin(Request $request)
    {
        $this->validate($request, [
            'user' => ['required', 'exists:users,id'],
        ]);
        if (CompanyUser::where(['user_id' => $request->user, 'company_id' => $request->company['id']])->exists()) {
            $admin = CompanyUser::where(['user_id' => $request->user, 'company_id' => $request->company['id']])->first();
            $admin->role = 'admin';
            $admin->isActive = true;
            $admin->save();
        } else {
            CompanyUser::create([
                'user_id' => $request->user,
                'company_id' => $request->company['id'],
                'role' => 'admin',
                'isActive' => true
            ]);
        }
        $user = User::find($request->user);
        if (!is_null($user->device_token)) {
            if ($request->lang == 'ru') {
                $user->notify(new RealTimeNotification('Вы стали администратором компании ' . $request->company['title'],
                    'От компании ' . $request->company['title'],
                    'assets/sample/' . $request->company['image'], $user->device_token));
            } else {
                $user->notify(new RealTimeNotification('You have become an administrator of the company ' . $request->company['title'],
                    'Company ' . $request->company['title'],
                    'assets/sample/' . $request->company['image'], $user->device_token));
            }
        }
        Notification::create([
            'title' => ['ru'=>'Вы стали администратором компании!', 'en'=>'You have become the company administrator!'],
            'description' => ['ru'=>'Теперь у Вас есть доступ к ресурсам компании ' . $request->company['title'],
                'en'=>'Now you have access to the company\'s resources ' . $request->company['title']],
            'user_id' => $user->id,
            'notification_type' => ['ru'=>'Назначение администратора', 'en'=>'Appointment of an administrator'],
            'object_id' => $request->company['id'],
            'object_type' => 'company'
        ]);
    }

    public function deleteCompanyAdmin(Request $request)
    {
        $this->validate($request, [
            'user' => ['required', 'exists:users,id'],
        ]);
        if (!CompanyUser::where(['user_id' => $request->user, 'company_id' => $request->company['id'], 'role' => 'admin'])->exists()) {
            return response()->json(['error' => 'Выбранный пользователь не является администратором компании']);
        }
        $user = CompanyUser::where(['user_id' => $request->user, 'company_id' => $request->company['id'], 'role' => 'admin'])->first();
        $user->role = 'user';
        $user->isActive = null;
        $user->save();
        $user = User::find($request->user);
        if (!is_null($user->device_token)) {
            if ($request->lang == 'ru') {
                $user->notify(new RealTimeNotification('Вас лишили прав администратора компании ' . $request->company['title'],
                    'От компании ' . $request->company['title'],
                    'assets/sample/' . $request->company['image'], $user->device_token));
            } else {
                $user->notify(new RealTimeNotification('You have been stripped of your company administrator rights ' . $request->company['title'],
                    'Company ' . $request->company['title'],
                    'assets/sample/' . $request->company['image'], $user->device_token));
            }
        }
        Notification::create([
            'title' => ['ru'=>'Вас лишили прав администратора компании...', 'en'=>'You have been stripped of your company administrator rights...'],
            'description' => ['ru'=>'Теперь у Вас нет доступа к ресурсам компании ' . $request->company['title'],
                'en'=>'Now you don\'t have access to the company\'s resources ' . $request->company['title']],
            'user_id' => $user->id,
            'notification_type' => ['ru'=>'Удаление администратора', 'en'=>'Deleting an Administrator'],
            'object_id' => $request->company['id'],
            'object_type' => 'company'
        ]);
    }

    public function changeActiveAdmin($admin, $company)
    {
        $user = CompanyUser::where(['user_id' => $admin, 'company_id' => $company])->first();
        if ($user->role == 'admin') {
            $user->isActive = !$user->isActive;
            $user->save();
        }
    }
}
