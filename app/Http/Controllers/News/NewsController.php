<?php

namespace App\Http\Controllers\News;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanyAdvertising;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    public function getNews()
    {
        $news = (object)CompanyAdvertising::where('type', 'Баннер')->get();
        return view('pages/userProfile/news/newsPage', compact('news'));
    }

    public function getNewsItem($id)
    {
        $news = CompanyAdvertising::where('id', $id)->first();
        $company_id = $news['company_id'];
        $company_news = CompanyAdvertising::whereCompanyIdAndType($company_id, 'Баннер')->get();
        $company = Company::find($company_id);
        return view('pages/userProfile/news/newsDetailPage', compact('news', 'company_news', 'company'));
    }
}
