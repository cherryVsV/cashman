<?php

namespace App\Http\Controllers\Achievements;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AchievementController extends Controller
{
    public function getAchievement($id)
    {
        $achievement = (object)[
            'title' => "Gaming Console",
            'description' => "Gaming",
            'achievement_image_url' => "../assets/sample/avatar/avatar4.jpg",
            'value' => 499,
            'prize_description' => "Gaming Console",
            'prize_image_url' => "../assets/sample/photo/wide2.jpg",
            'position' => 85,
            'created_at' => '25.06.2021'
        ];
        return view('pages/userProfile/achievements/achievementDetail', compact('achievement'));
    }


}
