<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Address;
use App\Models\cart;
use App\Models\Discount;
use App\Models\DiscountEvent;
use App\Models\DiscountToken;
use App\Models\factorMaster;
use App\Models\factorDetail;
use App\Models\OrderShipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Morilog\Jalali\Jalalian;

class FactorController extends Controller
{
    public function store(Request $request)
    {
//        dd($request->all());
        $user = $request->user();
        if ($request->has('addressBar') && $request->addressBar == 'newAddress') {
            $request->validate([
                'address' => 'required|string',
                'state' => 'required|string|max:255',
                'city' => 'required|string|max:255',
                'paymentMethod' => 'required|string|max:255|in:zarinpal,saderat,cash,asanpardakht',
                'discount_token' => 'nullable|string|max:20'
            ]);
            $address = Address::create([
                'state' => $request->state,
                'city' => $request->city,
                'address' => $request->address,
                'user_id' => $user->id
            ]);
        } else {
            $request->validate([
                'addressBar' => 'required|numeric',
                'paymentMethod' => 'required|string|max:255|in:zarinpal,saderat,cash,asanpardakht',
                'discount_token' => 'nullable|string|max:20'
            ]);
            $address = Address::find($request->addressBar);
            if (is_null($address) || $address->user_id != $request->user()->id) {
                return back()->withErrors(['آدرس وارد شده نامعتبر میباشد!']);
            }
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
                if (isset($token)) {
                    if ($token->access == 'public' || $token->user_id == $user->id) {
                        if ($token->start_date < now() && $token->expire_date > now()) {
                            $discount = Discount::query()->where('user_id', '=', $user->id)->where('token_id', '=', $token->id)->first();
                            if (isset($discount) && $discount->count < $token->usage_count) {
                                $discount->count++;
                                $discount->save();
                            } else if (is_null($discount)) {
                                Discount::create([
                                    'user_id' => $user->id,
                                    'token_id' => $token->id
                                ]);
                            } else {
                                return redirect()->back()->withInput()->withErrors(['کد تخفیف استفاده شده است!']);
                            }

                            $total -= $total / 100 * $token->percentage;


                        } else {
                            return redirect()->back()->withInput()->withErrors(['کد تخفیف منقضی شده یا هنوز فعال نشده است!']);

                        }
                    } else {
                        return redirect()->back()->withInput()->withErrors(['کد تخفیف نامعتبر میباشد!']);
                    }

                } else {
                    return redirect()->back()->withInput()->withErrors(['کد تخفیف نامعتبر میباشد!']);
                }
            }

            //check discount events
            $events = DiscountEvent::all();
            if (!empty($events)) {
                $currentEvent = null;
                foreach ($events as $event) {
                    if ($event->start_date < now() && $event->expire_date > now()) {
                        $currentEvent = $event;
                        break;
                    }
                }
                if (!is_null($currentEvent)) {
                    $total -= ($total / 100) * ($currentEvent->percentage);
                }


            }

            if ($total > $user->wallet) {
                return redirect()->route('users.charge')->withErrors(['شما مبلغ کافی در کیف پول خود ندارید!']);
            }

            $details = [];

            $factor = factorMaster::create([
                'user_id' => $user->id,
                'total_price' => $total,
                'payment_method' => $request->paymentMethod,
                'address_id' => $address->id,
            ]);

            if (isset($token)) {
                $factor->discount_token_id = $token->id;
            }
            if (isset($currentEvent) && !is_null($currentEvent)) {
                $factor->discount_event_id = $currentEvent->id;
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

            $log = __('logs.factor_report', ['userId' => $user->id,
                'userName' => $user->username,
                'state' => $factor->address->state,
                'city' => $factor->address->city,
                'address' => $factor->address->address,
                'paymentMethod' => $factor->payment_method,
                'date' => Jalalian::forge(now()),
                'factorId' => $factor->id,
                'price' => $factor->total_price]);


            $user->wallet -= $factor->total_price;
            $factor->is_paid = 1;
            $user->save();

            $factor->reports()->create([
                'status' => 'paid',
                'type' => 'decrease',
                'value' => $factor->total_price,
                'log' => $log,
            ]);


            OrderShipping::create([
                'factor_id' => $factor->id,
                'tracking_code' => Str::random(10),
                'ordered_description' => __('logs.order_ordered_log',[
                    'user'=>$user->username,
                    'date'=>Jalalian::forge($factor->created_at)
                ])
            ]);

            $factor->save();

            DB::commit();

            return redirect()->route('factor.show', $factor->id)->with('message', 'خرید شما با موفقیت ثبت شد!');


        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e);
        }

    }


    public function index(Request $request)
    {
        $factors = factorMaster::where('user_id', $request->user()->id);

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
            $factors = $factors->where('total_price', '>=', $request->from_price);
        }

        if ($request->has('to_price') && !empty($request->to_price)) {
            $factors = $factors->where('total_price', '<=', $request->to_price);
        }

        if ($request->has('from_date') && !empty($request->from_date)) {
            $factors = $factors->where('created_at', '>=', \Morilog\Jalali\CalendarUtils::createCarbonFromFormat('Y/m/d H:i:s', convert($request->from_date) . ' 00:00:00'));
        }
        if ($request->has('to_date') && !empty($request->to_date)) {
            $factors = $factors->where('created_at', '<=', \Morilog\Jalali\CalendarUtils::createCarbonFromFormat('Y/m/d H:i:s', convert($request->to_date) . ' 23:59:59'));
        }

        $factors = $factors->latest()->paginate(15);
        $iteration = ($factors->currentPage() - 1) * $factors->perPage();


        return view('factors.index', ['factors' => $factors, 'iteration' => $iteration]);
    }

    public function adminIndex(Request $request)
    {

        $request['from_price'] = str_replace(',', '', $request->from_price);
        $request['to_price'] = str_replace(',', '', $request->to_price);

        //validation
        $request->validate([
            'from_price' => 'nullable|numeric',
            'to_price' => 'nullable|numeric',
        ]);

        $factors = factorMaster::query();

        //      Search:
        if ($request->has('status') && !empty($request->status)) {
            if ($request->status == 'paid') {
                $factors = $factors->where('is_paid', '=', 1);
            } elseif ($request->status == 'not_paid') {
                $factors = $factors->where('is_paid', '=', 0);
            }
        }

        if ($request->has('from_price') && !empty($request->from_price)) {
            $factors = $factors->where('total_price', '>=', $request->from_price);
        }

        if ($request->has('to_price') && !empty($request->to_price)) {
            $factors = $factors->where('total_price', '<=', $request->to_price);
        }

        if ($request->has('from_date') && !empty($request->from_date)) {
            $factors = $factors->where('created_at', '>=', \Morilog\Jalali\CalendarUtils::createCarbonFromFormat('Y/m/d H:i:s', convert($request->from_date) . ' 00:00:00'));
        }
        if ($request->has('to_date') && !empty($request->to_date)) {
            $factors = $factors->where('created_at', '<=', \Morilog\Jalali\CalendarUtils::createCarbonFromFormat('Y/m/d H:i:s', convert($request->to_date) . ' 23:59:59'));
        }

        $factors = $factors->latest()->paginate(15);
        $iteration = ($factors->currentPage() - 1) * $factors->perPage();


        return view('admin.factors.index', ['factors' => $factors, 'iteration' => $iteration]);

    }

    public function show(Request $request, factorMaster $factor)
    {

        return view('factors.details', ['factor' => $factor, 'iteration' => '0']);

    }


    public function confirmDetails(Request $request)
    {

        if (count($request->user()->cart) < 1) {
            return redirect()->back()->withErrors(['شما محصولی برای خرید انتخاب نکرده اید!']);
        }
        if (!isset($request->counter)) {
            cart::destroy($request->user()->cart);
            return redirect()->route('home')->with('message', 'سبد خرید با موفقیت حذف شد!');
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
        $cart = $request->user()->cart;
        $addresses = $request->user()->addresses;

        $total = 0;
        foreach ($cart as $item) {
            $total += $item->product->price * $item->count;
        }
        return view('factors.orderDetails', ['addresses' => $addresses, 'total' => $total, 'cart' => $cart]);
    }

    public function searchOrderShipping()
    {
        return view('factors.searchOrderShipping');
    }

    public function orderShipping(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:20'
        ]);


        $shipping = OrderShipping::where('tracking_code', '=', $request->code)->firstOrFail();

        return view('factors.orderShipping', compact('shipping'));
    }

    public function statusConfirmation(Request $request, OrderShipping $shipping)
    {

        return view('admin.factors.statusConfirmation', compact('shipping'));
    }

    public function status(Request $request, OrderShipping $shipping)
    {
        $request->validate([
            'extraDescription' => 'nullable|string|max:500',
            'postalTrackingCode' => 'nullable|string|max:30'
        ]);

        switch ($shipping->status) {
            case 'ordered':
                $shipping->update([
                    'status' => 'checked',
                    'checked_description' =>__('logs.order_checked_log',[
                        'user'=>$shipping->factor->user->username,
                        'admin'=>$request->user()->username,
                        'date'=>Jalalian::forge(now())
                    ]),
                ]);
                break;
            case 'checked':
                if (!$request->has('postalTrackingCode') || empty($request->postalTrackingCode)){
                    return back()->withErrors(['شماره پیگیری پستی وارد نشده است!']);
                }
                $shipping->update([
                    'status' => 'sent',
                    'sent_description' => __('logs.order_sent_log',[
                        'user'=>$shipping->factor->user->username,
                        'date'=>Jalalian::forge(now())
                    ]),
                    'postal_tracking_code'=>$request->postalTrackingCode
                ]);
                break;
            case 'sent':
                $shipping->update([
                    'status' => 'delivered',
                    'delivered_description' => __('logs.order_delivered_log',[
                        'user'=>$shipping->factor->user->username,
                        'date'=>Jalalian::forge(now())
                    ]),
                ]);
                break;
            case 'delivered':
                return back()->withErrors(['امکان ویرایش وضعیت وجود ندارد!']);
        }

        return redirect()->route('admin.factor.index')->with('message','تغییر وضعیت با موفقیت اعمال شد!');
    }


}
