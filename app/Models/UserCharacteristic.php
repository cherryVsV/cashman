<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCharacteristic extends Model
{
    use HasFactory;

    protected $table = 'user_characteristics';
    protected $fillable = ['user_id', 'stat_id', 'value'];

    public function characteristic()
    {
        return $this->belongsTo(Characteristic::class, 'stat_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
