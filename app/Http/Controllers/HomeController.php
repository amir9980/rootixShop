<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
            'to_price' => 'nullable|numeric',
            'from_date' => 'nullable',
            'from_date' => 'nullable',

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
            $products = $products->where('created_at', '>=', $request->from_date);
        }
        if ($request->has('to_date') && !empty($request->to_date)) {
            $products = $products->where('created_at', '<=', $request->to_date);
        }


        $products = $products->where('status', '=', 1)->paginate(15);

        return view('index', [
            'products' => $products,
            'cart' => $cart
        ]);
    }

}
