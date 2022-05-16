<?php

namespace App\Http\Controllers;

use App\Models\cart;
use App\Models\factorMaster;
use App\Models\factorDetail;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class FactorController extends Controller
{
    public function store(Request $request)
    {

        DB::beginTransaction();

        try {

            $factor = factorMaster::create([
                'user_id' => $request->user()->id,
                'total_price' => $request->price

            ]);
            $details = [];


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
            return redirect()->back()->with('message', 'خرید با موفقیت انجام شد!');


        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors($e);
        }

    }


    public function index(Request $request)
    {

        if ($request->user()->is_admin == 1) {

            $factors = factorMaster::paginate(15);
        } else {
            $factors = factorMaster::where('user_id', $request->user()->id)->paginate(15);
        }
        $iteration = ($factors->currentPage() - 1) * $factors->perPage();

        return view('factors.index', ['factors' => $factors, 'iteration' => $iteration]);
    }

    public function show(factorMaster $factor)
    {
        $details = $factor->details;


        return view('factors.details', ['products' => $details, 'iteration' => '0']);

    }
}
