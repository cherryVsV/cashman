<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;


class UserPromocode extends Pivot
{
    use HasFactory;
    protected $table = 'user_promocodes';
}
