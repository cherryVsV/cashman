<?php

namespace App\Http\Controllers\Stories;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanyAdvertising;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class StoryController extends Controller
{
    public function addStoryFile(Request $request)
    {
        $fileName = time() . rand() . '.' . $request->file->getClientOriginalExtension();
        $request->file->move(public_path('assets/sample/news'), $fileName);

        return response()->json(['file' => $fileName]);
    }

    public function getData($id)
    {
        return response()->json([
            'advertisements' => CompanyAdvertising::where('company_id', $id)->get(),
            'company'=>Company::find($id)
        ], Response::HTTP_OK);

    }

    public function getStepperPage($id)
    {
        return view('pages/companyProfile/addCompanyAdvertising', compact('id'));
    }

    public function store(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required|string',
            'description' => 'required|string|max:255',
            'type' => 'required|string',
            'images' => 'required'
        ]);
        $company = Company::find($id);
        return CompanyAdvertising::create([
            'title' => $request->title,
            'description' => $request->description,
            'company_id' => $id,
            'regularity' => 1,
            'properties' => [],
            'creator_id' => $company->creator_id,
            'is_active' => true,
            'images' => [
                'main' => 'news/' . $request->images
            ],
            'type' => $request->type
        ]);
    }
}
