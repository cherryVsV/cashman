<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class HistoryUsersCompany extends Model
{
    use HasTranslations, HasFactory;
    protected $table = 'history_users_companies';
    protected $fillable = ['user_id', 'company_id', 'company_admin_id',
        'value', 'money_in_check', 'description', 'type'];
    public $translatable = ['description','type'];
    protected $appends = ['company', 'user'];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'company_admin_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function getCompanyAttribute()
    {
        $company = Company::where('id',  $this->company_id)->first();
        if($company) {
            return $company;
        }
        return 0;
    }
    public function getUserAttribute()
    {
        $user = UserProfile::where('user_id',  $this->user_id)->first();
        if($user) {
            return $user;
        }
        return 0;
    }
}
