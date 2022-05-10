<?php

namespace App\Http\Controllers;

use App\Models\product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use function PHPSTORM_META\type;

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
        return view('admin.products.index',['products'=>$products]);
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
        $request->file('img')->storeAs('images/products',$fileName);


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
            'old_price'=> 'required',
            'status'=> 'required|numeric',
            'img'=>'mimes:png,jpg,jpeg|max:2048'
        ]);

        if ($validated->fails()){
            return redirect()->back()->withInput()->withErrors($validated);
        }

        $fileName = $product->img_src;

        if ($request->has('img')){
            Storage::delete('images/products/'.$fileName);
            $fileName = $request->file('img')->hashName();
            $request->file('img')->storeAs('images/products',$fileName);

        }




        $product->update([
            'title'=>$request['title'],
            'description'=>$request['description'],
            'price'=>$request['price'],
            'old_price'=>$request['old_price'],
            'status'=>(int)$request['status'],
            'img_src'=>$fileName
        ]);



        return redirect(route('product.index'))->with('message','محصول با موفقیت ویرایش شد!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,product $product)
    {
            $validated = Validator::make($request->all(),[
               'reason'=>'required|max:255'
            ]);
            if ($validated->fails()){
                return redirect()->back()->withErrors($validated);

            }

            $p = product::find($product->id);
            $p->status = 3; //status 3 means 'deleted'
            $p->delete_reason = $request->reason;
            $p->save();
            return redirect()->back()->with('message','محصول با موفقیت حذف شد!');

    }


    public function status(Request $request,product $product){


    }
}
