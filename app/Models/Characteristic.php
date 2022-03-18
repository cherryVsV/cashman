<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Characteristic extends Model
{
    use HasFactory;

    protected $table = 'characteristics';
    protected $fillable = ['title'];

    public function userCharacteristics()
    {
        return $this->hasMany(UserCharacteristic::class);
    }

    public function achievements()
    {
        return $this->hasMany(Achievement::class);
    }
}
