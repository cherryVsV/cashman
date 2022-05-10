<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;

    protected $table = 'achievements';
    protected $fillable = ['title', 'achievement_description', 'achievement_image_url',
        'stat_id', 'value', 'position', 'prize_description', 'prize_image_url', 'is_active'];

    public function characteristic()
    {
        return $this->belongsTo(Characteristic::class, 'stat_id');
    }

    public function achievements()
    {
        return $this->hasMany(UserAchievement::class);
    }
}
