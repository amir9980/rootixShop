<?php

namespace App\Http\Controllers;

use App\Models\cart;
use App\Models\Discount;
use App\Models\DiscountToken;
use App\Models\factorMaster;
use App\Models\factorDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class FactorController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'address' => 'required|string',
            'state' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'paymentMethod' => 'required|string|max:255|in:zarinpal,saderat,cash,asanpardakht',
            'discount_token' => 'nullable|string|max:20'
        ]);

        $user = $request->user();


        if (count($user->cart) < 1) {
            return redirect()->back()->withErrors(['شما محصولی برای خرید انتخاب نکرده اید!']);
        }

        $total = null;
        foreach ($user->cart as $cartItem) {
            $total += $cartItem->product->price * $cartItem->count;
        }


        DB::beginTransaction();

        try {

            //check discount token
            if (!empty($request->discount_token)) {
                $token = DiscountToken::query()->where('token', '=', $request->discount_token)->first();
                if (isset($token)){
                    if ($token->access == 'public' || $token->user_id == $user->id) {
                        if ($token->start_date < now() && $token->expire_date > now()) {
                            $discount = Discount::query()->where('user_id','=',$user->id)->where('token_id','=',$token->id)->first();
                            if (isset($discount) && $discount->count < $token->usage_count){
                                $discount->count++;
                                $discount->save();
                            }else if(is_null($discount)){
                                Discount::create([
                                    'user_id'=>$user->id,
                                    'token_id'=>$token->id
                                ]);
                            }else{
                                return redirect()->back()->withInput()->withErrors(['کد تخفیف استفاده شده است!']);
                            }

                            $total -= $total / 100 * $token->percentage;


                        } else {
                            return redirect()->back()->withInput()->withErrors(['کد تخفیف منقضی شده یا هنوز فعال نشده است!']);

                        }
                    } else {
                        return redirect()->back()->withInput()->withErrors(['کد تخفیف نامعتبر میباشد!']);
                    }

                }else {
                    return redirect()->back()->withInput()->withErrors(['کد تخفیف نامعتبر میباشد!']);
                }
            }

            if ($total > $user->wallet) {
                return redirect()->route('users.charge')->withErrors(['شما مبلغ کافی در کیف پول خود ندارید!']);
            }

            $details = [];


            $factor = factorMaster::create([
                'user_id' => $user->id,
                'user_first_name' => $request->firstName,
                'user_last_name' => $request->lastName,
                'state' => $request->state,
                'city' => $request->city,
                'address' => $request->address,
                'total_price' => $total,
                'payment_method' => $request->paymentMethod,
            ]);
            if (isset($token)){
                $factor->discount_token_id = $token->id;
            }

            foreach ($user->cart as $cartItem) {
                $details[] = [
                    'master_id' => $factor->id,
                    'product_id' => $cartItem->product->id,
                    'count' => $cartItem->count
                ];
            }

            DB::table('factor_details')->insert($details);
            cart::where('user_id', $factor->user_id)->delete();

//            $log = 'کاربر '.$user->username . "\n";
//            $log .= 'با آیدی '.$user->id ."\n";
//            $log .= 'با آدرس '.$factor->state.''.$factor->city.''.$factor->address."\n";
//            $log .= 'به نام '.$factor->user_first_name.''.$factor->user_last_name."\n";
//            $log .= 'از طریق درگاه '.$factor->payment_method."\n";
//            $log .= 'در تاریخ '.now() ."\n";
//            $log .= 'محصولات فاکتور '.$factor->id ."\n";
//            $log .= 'را خریداری کرد و مبلغ '.$factor->total_price.'تومان از کیف پول ایشان کاهش یافت.';
            $log = __('logs.factor_report',['userId'=>$user->id,
                'userName'=>$user->username,
                'state'=>$factor->state,
                'city'=>$factor->city,
                'address'=>$factor->address,
                'firstName'=>$factor->user_first_name,
                'lastName'=>$factor->user_last_name,
                'paymentMethod'=>$factor->payment_method,
                'date'=>now(),
                'factorId'=>$factor->id,
                'price'=>$factor->total_price]);


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

            return redirect()->route('home')->with('message', 'خرید شما با موفقیت ثبت شد!');


        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e);
        }

    }


    public function index(Request $request)
    {

//        Authorize:
        if ($request->user()->is_admin == 1) {

            $factors = factorMaster::query();
        } else {
            $factors = factorMaster::where('user_id', $request->user()->id);
        }


        //        value is in number format like 10,000 so:
        $request['from_price'] = str_replace(',', '', $request->from_price);
        $request['to_price'] = str_replace(',', '', $request->to_price);

        //validation
        $request->validate([
            'from_price' => 'nullable|numeric',
            'to_price' => 'nullable|numeric',
        ]);


        //      Search:
        if ($request->has('status') && !empty($request->status)) {
            if ($request->status == 'paid') {
                $factors = $factors->where('is_paid', '=', 1);
            } elseif ($request->status == 'not_paid') {
                $factors = $factors->where('is_paid', '=', 0);
            }
        }

        if ($request->has('from_price') && !empty($request->from_price)) {
            $products = $factors->where('total_price', '>=', $request->from_price);
        }

        if ($request->has('to_price') && !empty($request->to_price)) {
            $products = $factors->where('total_price', '<=', $request->to_price);
        }

        if ($request->has('from_date') && !empty($request->from_date)) {
            $factors = $factors->where('created_at', '>=', \Morilog\Jalali\CalendarUtils::createCarbonFromFormat('Y/m/d H:i:s', convert($request->from_date) . ' 00:00:00'));
        }
        if ($request->has('to_date') && !empty($request->to_date)) {
            $factors = $factors->where('created_at', '<=', \Morilog\Jalali\CalendarUtils::createCarbonFromFormat('Y/m/d H:i:s', convert($request->to_date) . ' 23:59:59'));
        }

        $factors = $factors->orderBy('id','DESC')->paginate(15);
        $iteration = ($factors->currentPage() - 1) * $factors->perPage();


        return view('factors.index', ['factors' => $factors, 'iteration' => $iteration]);
    }

    public function show(Request $request, factorMaster $factor)
    {
        $details = $factor->details;


        return view('factors.details', ['products' => $details, 'iteration' => '0']);

    }


    public function confirmDetails(Request $request)
    {

        if (count($request->user()->cart) < 1) {
            return redirect()->back()->withErrors(['شما محصولی برای خرید انتخاب نکرده اید!']);
        }
        if (!isset($request->counter)){
            cart::destroy($request->user()->cart);
            return redirect()->route('home')->with('message','سبد خرید با موفقیت حذف شد!');
        }

        $request->validate([
            'counter[][id]' => 'numeric',
            'counter[][count]' => 'numeric',
        ]);

        try {
            $changes = [];
            $deletes = [];
            $carts = $request->user()->cart;


            foreach ($carts as $item) {
                $flag = false;
                foreach ($request->counter as $counter) {
                    if ($item->id == $counter['id']) {
                        $changes[] = ['id' => $item->id,
                            'count' => $counter['count'],
                            'user_id' => $item->user_id,
                            'product_id' => $item->product_id,
                        ];
                        $flag = true;
                    }
                }
                if ($flag == false) {
                    array_push($deletes, $item->id);
                }
            }

            cart::destroy($deletes);
            cart::query()->upsert($changes, ['id', 'user_id', 'product_id'], ['count']);

        } catch (Exception $e) {
            return redirect()->back()->withErrors($e);
        }

        return redirect()->route('factor.order');
    }

    public function orderDetails(Request $request)
    {
        $carts = $request->user()->cart;
        $profile = $request->user()->profile;
        if (count($carts) < 1) {
            return redirect()->back()->withErrors(['شما محصولی برای خرید انتخاب نکرده اید!']);
        }
        if (!isset($profile)) {
            return redirect()->route('profile.show')->withErrors(['لطفا پروفایل خود را تکمیل کنید!']);
        }

        $total = 0;
        foreach ($carts as $item) {
            $total += $item->product->price * $item->count;
        }
        return view('factors.orderDetails', ['total' => $total, 'cart' => $carts,'profile'=>$profile]);
    }


}
