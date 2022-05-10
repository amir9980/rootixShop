<?php

namespace App\Http\Controllers;

use App\Models\basket;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BasketController extends Controller
{
    public function store(Request $request){
        $user = $request->user();
        $productList = null;
        foreach ($user->cart as $cartItem){
            $productList= Str::of($productList)->append($cartItem->product->id)
                ->append('_')
            ->append($cartItem->product->title)
            ->append('_')
            ->append($cartItem->count)
            ->append(',');
        }

        $basket = basket::create([
            'user_id'=>$request->user()->id,
            'products'=>(string)$productList,
        ]);

        $basket->save();

        DB::table('carts')->where('user_id','=',$request->user()->id)->delete();

        return redirect()->back()->with('message','سبد خرید با موفقیت اضافه شد!');
    }
}
