<?php

namespace App\Http\Controllers;

use App\Models\WalletPayment;
use App\Models\user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Type;

class WalletPaymentController extends Controller
{
    public function store(Request $request,$u){
//        dd(gettype($request->value));
//        value is in number format like 10,000 so:
        $request['value'] = str_replace(',','',$request->value);


        $request->validate([
           'value'=>'required|numeric'
        ]);

        DB::beginTransaction();

        try{

            $user = user::find($u);

            $payment = WalletPayment::create([
                'user_id'=>$user->id,
                'value'=>$request->value,
                'doorway'=>'AsanPardakht'
            ]);


            $user->wallet += $request->value;

            $log = __('logs.factor_report',[
                'userId'=>$user->id,
                'userName'=>$user->username,
                'date'=>now(),
                'value'=>$request->value,
                'doorway'=>$payment->doorway
            ]);

            $payment->reports()->create([
                'status' => 'paid',
                'type' => 'increase',
                'value' => $request->value,
                'log' => $log,
            ]);

            $user->save();

            DB::commit();

            return redirect()->back()->with('message','پرداخت با موفقیت انجام شد!');

        }catch (\Exception $e){
            DB::rollBack();
            return redirect()->back()->withErrors($e);
        }
    }

}
