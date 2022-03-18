<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;


class ProductsInCategories extends Pivot
{
    use HasFactory;
    protected $table = 'products_in_categories';
}
