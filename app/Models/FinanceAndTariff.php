<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinanceAndTariff extends Model
{
    use HasFactory;
    protected $table = 'finance_and_tariffs';
    protected $fillable = ['company_id', 'money_balance', 'tariff_id'];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function tariff()
    {
        return $this->belongsTo(Tariff::class, 'tariff_id');
    }
}
