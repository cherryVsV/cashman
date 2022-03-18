<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promocode extends Model
{
    use HasFactory;
    protected $table = 'promocodes';
    protected $fillable = ['code', 'activation_count', 'is_active',
            'company_id', 'creator_id', 'prize_value'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function userActivated()
    {
        return $this->belongsToMany(User::class)->using(UserPromocode::class);
    }
}
