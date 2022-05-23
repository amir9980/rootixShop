<?php

namespace App\Http\Controllers;

use App\Models\factorMaster;
use App\Models\PaymentReport;
use App\Models\user;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentReportController extends Controller
{
    public function buyCart(Request $request, $factorId)
    {
        $factor = factorMaster::find($factorId);
        $user = user::find($request->user()->id);

        if ($factor->total_price > $user->wallet) {
            return redirect()->route('users.charge')->withErrors(['شما مبلغ کافی در کیف پول خود ندارید!']);
        }

        DB::beginTransaction();
        try {

            $log = 'کاربر ';
            $log .= $user->username . '';
            $log .= 'با آیدی ';
            $log .= $user->id . '';
            $log .= 'در تاریخ ';
            $log .= now() . '';
            $log .= 'محصولات فاکتور ';
            $log .= $factor->id . '';
            $log .= 'را خریداری کرد و مبلغ ';
            $log .= $factor->total_price . '';
            $log .= 'تومان از کیف پول ایشان کاهش یافت.';


            $user->wallet -= $factor->total_price;
            $factor->is_paid = 1;


            $user->reports()->create([
                'status' => 'paid',
                'type' => 'decrease',
                'value' => $factor->total_price,
                'log' => $log,
            ]);

            $factor->reports()->create([
                'status' => 'paid',
                'type' => 'decrease',
                'value' => $factor->total_price,
                'log' => $log,
            ]);


            $user->save();
            $factor->save();

            DB::commit();

            return redirect()->back()->with('message', 'خرید شما با موفقیت ثبت شد!');

        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e);
        }


    }
}
