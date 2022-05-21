<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use Morilog\Jalali\Jalalian;

class HomeController extends Controller
{
    public function index(Request $request)
    {


        if (\Illuminate\Support\Facades\Auth::user()) {
            $cart = \Illuminate\Support\Facades\Auth::user()->cart;
        } else {
            $cart = null;
        }


        $validated = Validator::make($request->all(), [
            'title' => 'nullable|max:255',
            'from_price' => 'nullable|numeric',
//            'to_price' => 'nullable|numeric',
//            'from_date' => 'nullable|digits:13',
//            'to_date' => 'nullable|digits:13',

        ]);

$request->validate([

]);
        if ($validated->fails()) {
            return redirect()->back()->withInput()->withErrors($validated);
        }

        $products = product::query();

        if ($request->has('title') && !empty($request->title)) {
            $products = $products->where('title', 'LIKE', '%' . $request->title . '%');
        }

        if ($request->has('from_price') && !empty($request->from_price)) {
            $products = $products->where('price', '>=', $request->from_price);
        }

        if ($request->has('to_price') && !empty($request->to_price)) {
            $products = $products->where('price', '<=', $request->to_price);
        }
        if ($request->has('from_date') && !empty($request->from_date)) {
            $products = $products->where('created_at', '>=', \Morilog\Jalali\CalendarUtils::createCarbonFromFormat('Y/m/d H:i:s', $this->convert($request->from_date) . ' 00:00:00'));
        }
        if ($request->has('to_date') && !empty($request->to_date)) {
            $products = $products->where('created_at', '<=', \Morilog\Jalali\CalendarUtils::createCarbonFromFormat('Y/m/d H:i:s', $this->convert($request->to_date) . ' 23:59:59'));
        }


        $products = $products->where('status', '=', 1)->paginate(15);

        return view('index', [
            'products' => $products,
            'cart' => $cart
        ]);
    }

    public function convert($string)
    {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $arabic = ['٩', '٨', '٧', '٦', '٥', '٤', '٣', '٢', '١', '٠'];

        $num = range(0, 9);
        $convertedPersianNums = str_replace($persian, $num, $string);
        $englishNumbersOnly = str_replace($arabic, $num, $convertedPersianNums);

        return $englishNumbersOnly;
    }
}
