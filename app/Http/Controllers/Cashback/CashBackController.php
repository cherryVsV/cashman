<?php

namespace App\Http\Controllers\Cashback;

use App\Models\Achievement;
use App\Models\Company;
use App\Models\Notification;
use App\Models\Product;
use App\Models\UserAchievement;
use App\Models\UserProfile;
use App\Notifications\RealTimeNotification;
use App\Http\Controllers\Controller;
use App\Models\HistoryUsersCompany;
use App\Models\User;
use App\Models\UsersFriedsByCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class CashBackController extends Controller
{
    public function debitingCashback(Request $request)
    {
        $this->validate($request, [
            'user' => ['required', 'exists:users,id', 'exists:company_user,user_id'],
            'description' => ['required'],
            'sum' => ['required'],
            'cashback' => ['required']
        ]);
        if (!is_null($request->image)) {
            $request->description = ['en' => $request->description . '. The attached document is available at <a href="' . $request->image . '">link</a>',
                'ru' => $request->description . '. Прикрепленный документ доступен по <a href="' . $request->image . '">ссылке</a>'];
        }
        $this->cashback($request->user, $request->company, $request->admin, $request->cashback, $request->sum,
        $request->description, $request->lang);

    }

    public function offsCashback(Request $request)
    {
        $this->validate($request, [
            'user' => ['required', 'exists:users,id', 'exists:company_user,user_id'],
            'description' => ['required'],
            'sum' => ['required']
        ]);
        if (!is_null($request->image)) {
            $request->description = ['en' => $request->description . '. The attached document is available at <a href="' . $request->image . '">link</a>',
                'ru' => $request->description . '. Прикрепленный документ доступен по <a href="' . $request->image . '">ссылке</a>'];
        }
        $score = HistoryUsersCompany::where(['user_id' => $request->user, 'company_id' => $request->company['id'], 'type->ru' => 'Начисление'])->sum('value');
        $offs = HistoryUsersCompany::where(['user_id' => $request->user, 'company_id' => $request->company['id'], 'type->ru' => 'Списание'])->sum('value');
        if ($score - $offs < $request->sum) {
            return response()->json(['error' => 'Недостаточно средств для выполнения списания!']);
        }

        $this->debitingMultiLevelCashback($request->user, $request->company, $request->admin, $request->sum, $request->sum,
            $request->description, ['ru' => 'Списание', 'en' => 'Offs']);
        $user = User::find($request->user);
        if ($request->lang == 'ru') {
            $user->notify(new RealTimeNotification('Списание кэшбека - ' . $request->sum . '$' . ',offs',
                'Компанией ' . $request->company['title'],
                'assets/sample/' . $request->company['image'], $user->device_token));
        } else {
            $user->notify(new RealTimeNotification('Cashback debiting - ' . $request->sum . '$' . ',offs',
                'Company ' . $request->company['title'],
                'assets/sample/' . $request->company['image'], $user->device_token));
        }
    }

    public function debitingMultiLevelCashback($user, $company, $admin, $cashback, $sum, $description, $type, $r_user=null)
    {
        $id = null;
        if(!is_null($company)){
            $id = $company['id'];
        }
        HistoryUsersCompany::create([
            'user_id' => $user,
            'company_id' => $id,
            'company_admin_id' => $admin,
            'value' => $cashback,
            'money_in_check' => $sum,
            'description' => $description,
            'type' => $type
        ]);
        if(!is_null($company)) {
            $title = ['en' => $type['en'] . '  cashback - ' . $cashback . '$' . ' Company - ' . $company['title'],
                'ru' => $type['ru'] . ' кэшбека - ' . $cashback . '$' . ' Компания - ' . $company['title']];
            $object_id = $id;
            $object = 'company';
        }else{
            $title = ['en' => $type['en'] . '  cashback - ' . $cashback . '$' . ' To user '.$r_user->name,
                'ru' => $type['ru'] . ' кэшбека - ' . $cashback . '$' . ' Пользователю '.$r_user->name];
            $object_id = $r_user->user_id;
            $object = 'user';
        }
        Notification::create([
            'title' => $title,
            'description' => $description,
            'user_id' => $user,
            'notification_type' => $type,
            'object_id' => $object_id,
            'object_type' => $object
        ]);
    }

    public function loadDescriptionPhoto(Request $request)
    {
        $path = Storage::disk('public')->put('images/descriptions', $request->file);
        return response()->json(['file' => URL::to('/') . '/storage/' . $path]);
    }

    public function getUserBalance($id, $company)
    {
        $score = 0;
        $debitings = HistoryUsersCompany::where(['user_id' => $id, 'company_id' => $company, 'type->ru' => 'Начисление'])->sum('value');
        $offs = HistoryUsersCompany::where(['user_id' => $id, 'company_id' => $company, 'type->ru' => 'Списание'])->sum('value');
        if ($debitings > $offs) {
            $score = round($debitings - $offs, 2);
        }
        return response()->json(['score' => $score]);
    }

    public function sendCashback(Request $request){
        $this->validate($request, [
            'to' => ['required', 'exists:users,id'],
            'amount' => ['required', 'numeric']
        ]);

        $score = HistoryUsersCompany::where(['user_id' => Auth::id(), 'type->ru' => 'Начисление'])->sum('value');
        $offs = HistoryUsersCompany::where(['user_id' => Auth::id(), 'type->ru' => 'Списание'])->sum('value');
        if ($score - $offs < $request->amount) {
            return response()->json(['status'=>'error' ]);
        }
        $user = User::find(Auth::id());
        $r_user =UserProfile::where('user_id', $request->to)->first();
        $to= User::find($request->to);
        $from = UserProfile::where('user_id', Auth::id())->first();
        $this->debitingMultiLevelCashback(Auth::id(), null, null, $request->amount, null,
            'Перевод кэшбека пользователю '. $r_user->name, ['ru' => 'Списание', 'en' => 'Offs'], $r_user);
        if ($request->lang == 'ru') {
            $user->notify(new RealTimeNotification('Перевод кэшбека - ' . $request->amount . '$' . ',offs',
                'Пользователем ' . $from->name,
                'assets/sample/' . $from->avatar, $to->device_token));
        } else {
            $user->notify(new RealTimeNotification('Cashback sending - ' . $request->amount . '$' . ',offs',
                'From user '  . $from->name,
                'assets/sample/' . $from->avatar, $to->device_token));
        }
        $this->debitingMultiLevelCashback($request->to, null, null, $request->amount, null,
            'Перевод от пользователя '.$from->name, ['ru' => 'Перевод', 'en' => 'Transfer'], $from);
        $this->debitingMultiLevelCashback($request->to, null, null, $request->amount, null,
            'Перевод от пользователя '.$from->name, ['ru' => 'Начисление', 'en' => 'Accrual'], $from);
        return response()->json(['status'=>'success']);
    }

    public function cashback($user_id, $company, $admin, $cashback, $sum, $description, $lang){
        $this->debitingMultiLevelCashback($user_id, $company, $admin, $cashback, $sum,
            $description, ['ru' => 'Начисление', 'en' => 'Accrual']);
        $user = User::find($user_id);
        if (!is_null($user->device_token)) {
            if ($lang == 'ru') {
                $user->notify(new RealTimeNotification('Начисление кэшбека - ' . $cashback . '$' . ',accrual',
                    'От компании ' . $company['title'],
                    'assets/sample/' . $company['image'], $user->device_token));
            } else {
                $user->notify(new RealTimeNotification('Cashback accrual - ' . $cashback . '$' . ',accrual',
                    'From the company ' . $company['title'],
                    'assets/sample/' . $company['image'], $user->device_token));
            }
        }
        $friends1 = UsersFriedsByCompany::where(['user_id' => $user_id, 'company_id' => $company['id']])->get();
        if ($friends1 != null) {
            $cashback_percent_level_1 = $company['cashback_percent_level_1'];
            $cashback_percent_level_2 = $company['cashback_percent_level_2'];
            if (!is_null($cashback_percent_level_1)) {
                foreach ($friends1 as $friend1) {
                    $cashback1 = $sum / 100 * $cashback_percent_level_1;
                    $this->debitingMultiLevelCashback($friend1->parent_id, $company, $admin, $cashback1, $sum,
                        ['ru' => 'Начисление кэшбека 1 уровня от суммы чека вашего друга по компании', 'en' => 'Accrual of level 1 cashback from the amount of your friend\'s check for the company'],
                        ['ru' => 'Начисление', 'en' => 'Accrual']);
                    $user = User::find($friend1->parent_id);
                    if (!is_null($user->device_token)) {
                        if ($lang == 'ru') {
                            $user->notify(new RealTimeNotification('Начисление кэшбека 1 уровня - ' . $cashback . '$' . ',accrual',
                                'От компании ' . $company['title'],
                                'assets/sample/' . $company['image'], $user->device_token));
                        } else {
                            $user->notify(new RealTimeNotification('Accrual of level 1 cashback - ' . $cashback . '$' . ',accrual',
                                'From the company ' . $company['title'],
                                'assets/sample/' . $company['image'], $user->device_token));
                        }
                    }
                    $friends2 = UsersFriedsByCompany::where(['user_id' => $friend1->parent_id, 'company_id' => $company['id']])->get();
                    if ($friends2 != null) {
                        if (!is_null($cashback_percent_level_2)) {
                            foreach ($friends2 as $friend2) {
                                $cashback2 = $sum / 100 * $cashback_percent_level_2;
                                $this->debitingMultiLevelCashback($friend2->parent_id, $company, $admin, $cashback2, $sum,
                                    ['ru' => 'Начисление кэшбека 2 уровня от суммы чека вашего друга по компании', 'en' => 'Accrual of level 2 cashback from the amount of your friend\'s check for the company'],
                                    ['ru' => 'Начисление', 'en' => 'Accrual']);
                                $user = User::find($friend2->parent_id);
                                if (!is_null($user->device_token)) {
                                    if ($lang == 'ru') {
                                        $user->notify(new RealTimeNotification('Начисление кэшбека 2 уровня - ' . $cashback . '$' . ',accrual',
                                            'От компании ' . $company['title'],
                                            'assets/sample/' . $company['image'], $user->device_token));
                                    } else {
                                        $user->notify(new RealTimeNotification('Accrual of level 2 cashback - ' . $cashback . '$' . ',accrual',
                                            'From the company ' . $company['title'],
                                            'assets/sample/' . $company['image'], $user->device_token));
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }

    public function buyProduct(Request $request){
        $this->validate($request, [
            'id' => ['required', 'exists:products,id'],
        ]);
        $product = Product::find($request->id);
        $score = HistoryUsersCompany::where(['user_id' => Auth::id(), 'type->ru' => 'Начисление'])->sum('value');
        $offs = HistoryUsersCompany::where(['user_id' => Auth::id(), 'type->ru' => 'Списание'])->sum('value');
        if ($score - $offs < $product->price) {
            return response()->json(['status'=>'error']);
        }
        $company = Company::find($product->company_id);
        $cashback = $product->price / 100 * $company->cashback_percent;
        $description = 'Кешбек с покупки товара '.$product->title;
        $this->debitingMultiLevelCashback(Auth::id(), $company, null, $product->price, $product->price,
            'Списание при покупке товара '.$product->title, ['ru' => 'Списание', 'en' => 'Offs']);
        $this->cashback(Auth::id(), $company, null, $cashback, $product->price,
            $description, 'ru');
        if(Achievement::where(['value'=>$product->id, 'is_active'=>true])->exists()){
            $achievements = Achievement::where(['value'=>$product->id, 'is_active'=>true])->get();
            foreach($achievements as $achievement){
                if(UserAchievement::where(['user_id'=>Auth::id(), 'achievement_id'=>$achievement->id])->exists()){
                    $user_achievement = UserAchievement::where(['user_id'=>Auth::id(), 'achievement_id'=>$achievement->id])->first();
                    if($user_achievement->amount < $achievement->position){
                        $user_achievement->amount +=1;
                        $user_achievement->progress = $user_achievement->amount/$achievement->position*100;
                        $user_achievement->save();
                    }else if($user_achievement->amount == $achievement->position){
                        $user_achievement->amount = $achievement->position;
                        $user_achievement->progress = 100;
                        $user_achievement->save();
                    }
                }else{
                    UserAchievement::create([
                        'user_id'=>Auth::id(),
                        'achievement_id'=>$achievement->id,
                        'progress'=>1/$achievement->position*100,
                        'amount'=>1
                    ]);
                }
            }
        }
        return response()->json(['status'=>'success']);
    }
}
