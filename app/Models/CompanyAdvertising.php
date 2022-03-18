<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CompanyAdvertising extends Model
{
    use HasFactory;

    protected $table = 'company_advertising';
    protected $fillable = ['title', 'description', 'company_id',
        'regularity', 'properties', 'creator_id', 'is_active', 'images', 'type'];
    protected $casts = [
        'properties' => 'array',
        'images' => 'array'
    ];
    protected $appends = ['name', 'avatar'];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
    public function getNameAttribute()
    {
        $companyId = DB::table('company_advertising')->where('id', $this->id)->value('company_id');
        $company = Company::find($companyId);
        if($company->count() > 0) {
            return $company->title;
        }
        return 0;
    }
    public function getAvatarAttribute()
    {
        $companyId = DB::table('company_advertising')->where('id', $this->id)->value('company_id');
        $company = Company::find($companyId);
        if($company->count() > 0) {
            return $company->image;
        }
        return 0;
    }

}
