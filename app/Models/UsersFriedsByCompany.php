<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersFriedsByCompany extends Model
{
    use HasFactory;

    protected $table = 'users_frieds_by_companies';
    protected $fillable = ['user_id', 'company_id', 'parent_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
