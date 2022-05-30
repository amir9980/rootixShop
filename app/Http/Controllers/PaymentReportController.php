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

            $log = 'کاربر '.$user->username . "\n";
            $log .= 'با آیدی '.$user->id ."\n";
            $log .= 'با آدرس '.$factor->state.''.$factor->city.''.$factor->address."\n";
            $log .= 'به نام '.$factor->user_first_name.''.$factor->user_last_name."\n";
            $log .= 'از طریق درگاه '.$factor->payment_method."\n";
            $log .= 'در تاریخ '.now() ."\n";
            $log .= 'محصولات فاکتور '.$factor->id ."\n";
            $log .= 'را خریداری کرد و مبلغ '.$factor->total_price.'تومان از کیف پول ایشان کاهش یافت.';


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
