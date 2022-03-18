<?php

namespace App\Http\Controllers\Companies;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Events\SearchEvent;

class SearchCompanyController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->query('query');

        $companies = Company::where('title', 'like', '%' . $query . '%')
            ->select('id', 'title', 'image')
            ->get();

        //broadcast search results with Pusher channels
        event(new SearchEvent($companies));

        return response()->json("ok");
    }

    public function index(Request $request)
    {
        $companies = Company::latest()->get();
        return response()->json($companies);
    }

}
