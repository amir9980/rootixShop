<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = product::all();
        return view('admin.products.showProducts',['products'=>$products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.products.createProduct');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validated = Validator::make(request()->all(),[
            'title'=> 'required',
            'description'=> 'required',
            'price'=> 'required',
            'img'=>'required|mimes:png,jpg,jpeg|max:2048'
        ]);

        if ($validated->fails()){
            return redirect()->back()->withInput()->withErrors($validated);
        }

        $fileName = $request->file('img')->hashName();
        $request->file('img')->storeAs('public/images/products',$fileName);


        $product = product::create([
            'title'=>$request['title'],
            'description'=>$request['description'],
            'price'=>$request['price'],
            'old_price'=>$request['old_price'],
            'img_src'=>$fileName
        ]);

        $product->save();

        return redirect(route('product.index'))->with('message','Product stored seccesfully!');


    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(product $product)
    {
        $p = product::find($product->id);
        return view('admin.products.editProducts',['product'=>$p]);
    }

    public function show(product $product){

        if (\Illuminate\Support\Facades\Auth::user()){
            $cart = \Illuminate\Support\Facades\Auth::user()->cart;
        }else{
            $cart = null;
        }

        $p = product::find($product->id);

        return view('showProduct',['product'=>$p,'cart'=>$cart]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, product $product)
    {
        $validated = Validator::make(request()->all(),[
            'title'=> 'required',
            'description'=> 'required',
            'price'=> 'required',
            'img'=>'mimes:png,jpg,jpeg|max:2048'
        ]);

        if ($validated->fails()){
            return redirect()->back()->withInput()->withErrors($validated);
        }


        $fileName = $product->img_src;
        if ($request->file('img_src')){
            $fileName = $request->file('img')->hashName();
            $request->file('img')->storeAs('public/images/products',$fileName);

        }


        $product->update([
            'title'=>$request['title'],
            'description'=>$request['description'],
            'price'=>$request['price'],
            'old_price'=>$request['old_price'],
            'img_src'=>$fileName
        ]);



        return redirect(route('product.index'))->with('message','Product Updated seccesfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(product $product)
    {
        if (product::destroy($product->id)){
            return redirect()->back()->with('message','product deleted succesfully!');
        }else{
            return redirect()->back()->with('message','product did not deleted!');
        }
    }
}
