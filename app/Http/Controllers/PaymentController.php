<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\user;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function store(Request $request,$u){
        $request->validate([
           'value'=>'required|numeric'
        ]);
        try{
            $user = user::find($u);
            Payment::create([
                'user_id'=>$user->id,
                'value'=>$request->value
            ]);
            $user->wallet += $request->value;
            $user->save();

            return redirect()->back()->with('message','پرداخت با موفقیت انجام شد!');

        }catch (Exception $e){
            return redirect()->back()->withErrors($e);
        }
    }

}
