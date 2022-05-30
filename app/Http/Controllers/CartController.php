<?php

namespace App\Http\Controllers;

use App\Models\cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $productId = $request->product;

        $ifExistsInCart = false;
        $existedCart = null;

        foreach ($request->user()->cart as $c) {
            if ($c->product_id == $productId) {
                $ifExistsInCart = true;
                $existedCart = $c;
            }
        }

        if ($ifExistsInCart) {
            $existedCart->count = $existedCart->count + 1;
            $existedCart->save();
            return redirect()->back()->with('message', 'محصول مجددا به سبد خرید اضافه شد!');
        } else {
            cart::create([
                'user_id' => $request->user()->id,
                'product_id' => $productId,
                'count' => 1
            ]);
            return redirect()->back()->with('message', 'محصول موردنظر به سبد خرید شما اضافه شد!');

        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{

            $cart = cart::find($id);

            if ($cart->count > 1){
                $cart->count -= 1;
                $cart->save();
            }else{
                $cart->delete();
            }
            return redirect()->back()->with('message','محصول از سبد خرید حذف شد!');
        }catch (\Exception $e){
            return redirect()->back()->withErrors($e);
        }
    }
}
