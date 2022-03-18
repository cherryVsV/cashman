<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProductCategory extends Model
{
    use HasFactory;
    protected $table = 'product_categories';
    protected $fillable = ['title'];
    protected $appends = ['number'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'products_in_categories');
    }
    public function getNumberAttribute(){
        $count = DB::table('products_in_categories')->where('product_category_id', $this->id)->select('product_id')->get()->pluck('product_id');
        if($count->count() > 0) {
            return $count->count();
        }
        return 0;
    }
}
