<?php

namespace App\Http\Controllers\Achievements;

use App\Models\Achievement;
use App\Models\Company;
use App\Models\Product;
use App\Models\UserAchievement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AchievementController extends Controller
{
    public function getAchievement($id)
    {
        $achievement = UserAchievement::where('id', $id)->with(['achievement'])->first();
        return view('pages/userProfile/achievements/achievementDetail', compact('achievement'));
    }

    public function getAchievements(){
        $achievements = UserAchievement::where('user_id', Auth::id())->with(['achievement'])->get();
        return view('pages/userProfile/achievements/achievementPage', compact('achievements'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return false|object|string
     */
    public function index($id)
    {
        return view('pages/companyProfile/Admin/companyAchievements', compact('id'));
    }

    public function addAchievementFile(Request $request)
    {
        $fileName = time() . rand() . '.' . $request->file->getClientOriginalExtension();
        $request->file->move(public_path('assets/sample/achievements'), $fileName);

        return response()->json(['file' => $fileName]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:255',
            'achievement_description' => 'required|string|max:255',
            'achievement_image_url' => 'required',
            'value' => 'required|numeric|exists:products,id',
            'position' => 'required',
            'prize_description' => 'required|string',
            'prize_image_url' => 'required|string',
        ]);
        $product = Product::find($request->value);
        if($product->company_id != $request->id){
            return response()->json('status',422);
        }
        return Achievement::create([
            'title'=>$request->title,
            'achievement_description' => $request->achievement_description,
            'stat_id' => $request->id,
            'achievement_image_url' => $request->achievement_image_url,
            'value' => $request->value,
            'position' => $request->position,
            'prize_description' => $request->prize_description,
            'prize_image_url' => $request->prize_image_url
        ]);
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
        $achievement = Achievement::find($id);
        $this->validate($request, [
            'title' => 'required|string|max:255',
            'achievement_description' => 'required|string|max:255',
            'value' => 'required|numeric|exists:products,id',
            'position' => 'required',
            'prize_description' => 'required|string',
        ]);
        $achievement->achievement_description = $request->achievement_description;
        $achievement->title = $request->title;
        if($request->achievement_image_url) {
            $achievement->achievement_image_url = $request->achievement_image_url;
        }
        $achievement->value = $request->value;
        $achievement->position = $request->position;
        $achievement->prize_description = $request->prize_description;
        if($request->prize_image_url) {
            $achievement->prize_image_url = $request->prize_image_url;
        }
        $achievement->save();
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
        $achievement = Achievement::find($id);
        $achievement->delete();
        return ['message' => 'record deleted'];
    }

    public function getData($id)
    {
        return response()->json([
            'achievements' => Achievement::where('stat_id', $id)->get(),
            'company'=>Company::find($id)
        ], Response::HTTP_OK);

    }
}
