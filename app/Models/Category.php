<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $fillable = ['title'];

    public function companies()
    {
        return $this->belongsToMany(Company::class)->using(CompanyCategory::class);
    }
}
