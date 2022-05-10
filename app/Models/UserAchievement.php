<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;



class UserAchievement extends Pivot
{
    use HasFactory;
    protected $table = 'user_achievements';

    public function achievement()
    {
        return $this->belongsTo(Achievement::class, 'achievement_id');
    }
}

