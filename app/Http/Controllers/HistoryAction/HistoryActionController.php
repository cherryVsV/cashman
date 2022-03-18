<?php

namespace App\Http\Controllers\HistoryAction;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryActionController extends Controller
{
    public function getActionDetail($id)
    {
        $action = Notification::find($id);
        $action->is_seen = true;
        $action->save();
        return view('pages/userProfile/actions/actionDetail', compact('action'));
    }
    public function getActions($id){
        $actions = Notification::where('user_id', $id)->get();
        return response()->json(['actions'=>$actions]);
    }
    public function deleteAction($id){
        if(Notification::where('id', $id)->exists()){
            Notification::where('id', $id)->delete();
        }
    }
    public function getActionsPage(){
        $id = Auth::user()->getAuthIdentifier();
        return view('pages/userProfile/actions/userActionHistoryPage', compact('id'));
    }
}
