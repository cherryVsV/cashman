<?php

namespace App\Http\Controllers\Region;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class RegionMapController extends Controller
{
    public function getMap($id)
    {
        $company = Company::where('id', $id)->first();
        $lat = $company['latitude'];
        $lon = $company['longitude'];
        $coords = [(float)$lat, (float)$lon];
        return view('pages/companies/regionMapPage', compact('coords', 'company'));
    }
}
