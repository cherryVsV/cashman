<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinanceHistory extends Model
{
    use HasFactory;
    protected $table = 'finance_histories';
    protected $fillable = ['company_id', 'value', 'from'];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
