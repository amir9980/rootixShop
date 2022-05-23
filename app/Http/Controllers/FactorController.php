<?php

namespace App\Http\Controllers;

use App\Models\cart;
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
        if (count($request->user()->cart) < 1){
            return redirect()->back()->withErrors(['شما محصولی برای خرید انتخاب نکرده اید!']);
        }

        DB::beginTransaction();

        try {

            $details = [];
            $total = null;


            foreach ($request->user()->cart as $cartItem) {
                $total += $cartItem->product->price * $cartItem->count;
            }

            $factor = factorMaster::create([
                'user_id' => $request->user()->id,
                'total_price'=>$total
            ]);

            foreach ($request->user()->cart as $cartItem) {
                $details[] = [
                    'master_id' => $factor->id,
                    'product_id' => $cartItem->product->id,
                    'count' => $cartItem->count
                ];
            }

            $factor->save();
            DB::table('factor_details')->insert($details);
            cart::where('user_id', $factor->user_id)->delete();


            DB::commit();
            return redirect()->route('factor.index')->with('message', 'سبد با موفقیت ثبت شد!');


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
        $request['from_price'] = str_replace(',','',$request->from_price);
        $request['to_price'] = str_replace(',','',$request->to_price);

        //validation
        $request->validate([
            'from_price'=>'nullable|numeric',
            'to_price'=>'nullable|numeric',
        ]);


        //      Search:
        if ($request->has('status') && !empty($request->status)) {
            if ($request->status=='paid'){
                $factors = $factors->where('is_paid', '=', 1);
            }
            elseif ($request->status=='not_paid'){
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

        $factors = $factors->paginate(15);
        $iteration = ($factors->currentPage() - 1) * $factors->perPage();


        return view('factors.index', ['factors' => $factors, 'iteration' => $iteration,'cart'=>$request->user()->cart]);
    }

    public function show(Request $request,factorMaster $factor)
    {
        $details = $factor->details;


        return view('factors.details', ['products' => $details, 'iteration' => '0','carts'=>$request->user()->carts]);

    }


}
