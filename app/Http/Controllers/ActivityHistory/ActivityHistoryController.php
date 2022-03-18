<?php

namespace App\Http\Controllers\ActivityHistory;

use App\Http\Controllers\Controller;
use App\Models\HistoryUsersCompany;
use Illuminate\Http\Request;

class ActivityHistoryController extends Controller
{
    public function getActivityHistory()
    {
        $history = HistoryUsersCompany::latest()->get();
        return view('pages.activityHistoryPage', compact('history'));

    }
}
