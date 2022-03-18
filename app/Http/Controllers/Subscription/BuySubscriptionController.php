<?php

namespace App\Http\Controllers\Subscription;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BuySubscriptionController extends Controller
{
    public function index(Request $request)
    {
        $this->validate($request, [
            'from' => ['required', 'string'],
            'to' => ['required', 'string'],
            'amount' => ['required', 'integer']
        ]);
    }
}
