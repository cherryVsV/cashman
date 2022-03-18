<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyAlert extends Model
{
    use HasFactory;
    protected $table = 'company_alerts';
    protected $fillable = ['title', 'description', 'duration', 'company_id'];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
