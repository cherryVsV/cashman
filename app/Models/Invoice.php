<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'price', 'payment_status', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getPaidAttribute() {
        if ($this->payment_status == 'Invalid') {
            return false;
        }
        return true;
    }
}
