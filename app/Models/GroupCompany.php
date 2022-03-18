<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupCompany extends Model
{
    use HasFactory;
    protected $table = 'group_companies';
    protected $fillable = ['image', 'title', 'description', 'position'];

    public function company()
    {
        return $this->HasMany(Company::class);
    }

}
