<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        if (\Illuminate\Support\Facades\Auth::user()){
            $cart = \Illuminate\Support\Facades\Auth::user()->cart;
        }else{
            $cart = null;
        }

        $products = \App\Models\product::all();

        return view('index',[
            'products'=>$products,
            'cart'=>$cart
        ]);
    }

}
