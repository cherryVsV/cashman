<?php

namespace App\Http\Controllers\Companies;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyEditSectionController extends Controller
{
    public function index($id)
    {
        $company = (object)Company::where('id', $id)->first();
        return view('pages/companyProfile/companyEditSection', compact('company'));
    }

    public function storeFile(Request $request)
    {
        $fileName = time() . rand() . '.' . $request->file->getClientOriginalExtension();
        $request->file->move(public_path('assets/sample/companyLogos'), $fileName);

        return response()->json(['file' => $fileName]);
    }

    public function updateCompanyData(Request $request)
    {
        $result = [];
        $this->validate($request, [
            'title' => ['required', 'string'],
            'image' => ['required'],
            'cashback_percent' => ['required', 'numeric'],
            'cashback_percent_level_1' => ['required', 'numeric'],
            'cashback_percent_level_2' => ['required', 'numeric'],
            'callback_url' => ['required', 'string'],
            'upload_vk_url' => ['required', 'string'],
            'description' => ['required', 'string'],
        ]);

        $company = Company::find($request->id);
        if ($company->image != $request->image) {
            $company->image = 'companyLogos/' . $request->image;
        }
        $company->title = $request->title;
        $company->cashback_percent = $request->cashback_percent;
        $company->cashback_percent_level_1 = $request->cashback_percent_level_1;
        $company->cashback_percent_level_2 = $request->cashback_percent_level_2;
        $company->callback_url = $request->callback_url;
        $company->upload_vk_url = $request->upload_vk_url;
        $company->description = $request->description;
        $company->properties = $request->properties;
        $company->socials = $request->socials;
        $company->save();
        $result['href'] = route('company-profile', ['id' => $company->id]);
        return response()->json($result);


    }
}
