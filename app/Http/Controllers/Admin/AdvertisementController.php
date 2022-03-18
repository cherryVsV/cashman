<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\CompanyAdvertising;
use Illuminate\Http\Request;

class AdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        return view('pages/companyProfile/Admin/AdminAdvertisementPage', compact('id'));
    }

    public function getAdvertisement($id)
    {
        $company = (object)Company::where('id', $id)->first();
        $news = $company->advertising()->where('type', 'Баннер')->get();
        $stories = $company->advertising()->where('type', 'Сторис')->get();
        return view('pages/companyProfile/Admin/StoryAdminMenu', [
            'stories' => $stories,
            'news' => $news,
            'id' => $id
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        ;
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $advertisement = CompanyAdvertising::find($id);
        $this->validate($request, [
            'title' => 'required|string',
            'description' => 'required|string',
            'images' => 'required'
        ]);
        $advertisement->title = $request->title;
        $advertisement->description = $request->description;
        if ($advertisement->images['main'] != $request->images['main']) {
            $advertisement->images = [
                'main' => $request->images['main']
            ];
        }
        $advertisement->save();
        return ['message' => 'record updated'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $advertisement = CompanyAdvertising::find($id);
        $advertisement->delete();
        return ['message' => 'record deleted'];
    }
}
