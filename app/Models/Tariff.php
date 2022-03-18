<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tariff extends Model
{
    use HasFactory;
    protected $table = 'tariffs';
    protected $fillable = ['money', 'title', 'description',
           'is_visible', 'properties', 'identifier', 'stripe_id',
        'stories', 'news', 'admins', 'is_vk_upload'];


    public function finances()
    {
        return $this->HasMany(FinanceAndTariff::class);
    }

    public function companies()
    {
        return $this->HasMany(Company::class);
    }
}
