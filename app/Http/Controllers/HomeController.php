<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(){
        if (\Illuminate\Support\Facades\Auth::user()){
            $cart = \Illuminate\Support\Facades\Auth::user()->cart;
        }else{
            $cart = null;
        }

        $products = product::where('status','=',1)->paginate(15);

        return view('index',[
            'products'=>$products,
            'cart'=>$cart
        ]);
    }

}
