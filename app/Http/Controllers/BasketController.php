<?php

namespace App\Http\Controllers;

use App\Models\basket;
use App\Models\basketDetail;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BasketController extends Controller
{
    public function store(Request $request){

        $basket = basket::create([
            'user_id'=>$request->user()->id,
            'total_price'=>$request->price

        ]);

        foreach ($request->user()->cart as $cartItem){
            basketDetail::create([
                'master_id'=>$basket->id,
                'product_id'=>$cartItem->product->id,
                'count'=>$cartItem->count
            ]);
        }





        DB::table('carts')->where('user_id','=',$request->user()->id)->delete();

        return redirect()->back()->with('message','سبد خرید با موفقیت اضافه شد!');
    }



    public function index(){
        $baskets = basket::paginate(15);
        $iteration = ($baskets->currentPage()-1)*$baskets->perPage();



        return view('admin.baskets.index',['baskets'=>$baskets,'iteration'=>$iteration]);
    }

    public function show(basket $basket){
        $products = $basket->details;


        return view('admin.baskets.details',['products'=>$products,'iteration'=>'0']);

    }
}
