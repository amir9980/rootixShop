<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;
use Morilog\Jalali\Jalalian;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function index(Request $request)
    {

        //        value is in number format like 10,000 so:
        $request['from_price'] = str_replace(',','',$request->from_price);
        $request['to_price'] = str_replace(',','',$request->to_price);

        // dates too:
        $request['from_date'] = convert($request->from_date);
        $request['to_date'] = convert($request->to_date);

        $request->validate([
            'title' => 'nullable|max:255',
            'from_price' => 'nullable|numeric',
            'to_price' => 'nullable|numeric',
            'from_date' => 'nullable|regex:/....\/..\/../',
            'to_date' => 'nullable|regex:/....\/..\/../',
        ]);

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
            $products = $products->where('created_at', '>=', \Morilog\Jalali\CalendarUtils::createCarbonFromFormat('Y/m/d H:i:s', $request->from_date . ' 00:00:00'));
        }
        if ($request->has('to_date') && !empty($request->to_date)) {
            $products = $products->where('created_at', '<=', \Morilog\Jalali\CalendarUtils::createCarbonFromFormat('Y/m/d H:i:s', $request->to_date . ' 23:59:59'));
        }


        $products = $products->where('status', '=', 'Active')->paginate(15);

        return view('index', [
            'products' => $products,
        ]);
    }

}
