<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;


class LangController extends Controller
{
    public function getLang()
    {
        return response()->json(['locale'=>App::getLocale()]);
    }
    public function getLocales(){
        return response()->json(['locales'=>config('locale.languages')]);
    }
    public function setLang($lang){
        Session::put('locale', $lang);
    }
}
