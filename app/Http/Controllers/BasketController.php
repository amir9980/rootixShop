<?php

namespace App\Http\Controllers;

use http\Client\Curl\User;
use Illuminate\Http\Request;

class BasketController extends Controller
{
    public function store(Request $request,User $user){
        $productList = null;
        foreach ($user->cart as $cartItem){
            //
        }
    }
}
