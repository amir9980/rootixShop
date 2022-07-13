<?php

namespace App\Http\Controllers;

use App\Jobs\CalculateProductRate;
use App\Jobs\RateProduct;
use App\Models\FileUpload;
use App\Models\product;
use App\Models\Rate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use function PHPSTORM_META\type;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        //        value is in number format like 10,000 so:
        $request['from_price'] = str_replace(',', '', $request->from_price);
        $request['to_price'] = str_replace(',', '', $request->to_price);

        $request->validate([
            'title' => 'nullable|max:255',
            'from_price' => 'nullable|numeric',
            'to_price' => 'nullable|numeric',
            'from_date' => 'nullable',
            'to_date' => 'nullable',
            'status' => 'nullable|string|in:Active,Inactive,Deleted',

        ]);


        $products = product::query();

        if ($request->has('title') && !empty($request->title)) {
            $products = $products->where('title', 'LIKE', '%' . $request->title . '%');
        }

        if ($request->has('status') && !empty($request->status)) {
            $products = $products->where('status', '=', $request->status);
        }

        if ($request->has('from_price') && !empty($request->from_price)) {
            $products = $products->where('price', '>=', $request->from_price);
        }

        if ($request->has('to_price') && !empty($request->to_price)) {
            $products = $products->where('price', '<=', $request->to_price);
        }
        if ($request->has('from_date') && !empty($request->from_date)) {
            $products = $products->where('created_at', '>=', \Morilog\Jalali\CalendarUtils::createCarbonFromFormat('Y/m/d H:i:s', convert($request->from_date) . ' 00:00:00'));
        }
        if ($request->has('to_date') && !empty($request->to_date)) {
            $products = $products->where('created_at', '<=', \Morilog\Jalali\CalendarUtils::createCarbonFromFormat('Y/m/d H:i:s', convert($request->to_date) . ' 23:59:59'));
        }

        $products = $products->paginate(15)->withQueryString();

        $iteration = ($products->currentPage() - 1) * $products->perPage();

        return view('admin.products.index', ['products' => $products, 'iteration' => $iteration]);
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //        value is in number format like 10,000 so:
        $request['price'] = str_replace(',', '', $request->price);
        $request['off_price'] = str_replace(',', '', $request->off_price);

        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'off_price' => 'nullable|numeric',
            'images.*' => 'nullable|mimes:png,jpg,jpeg|max:2048'
        ]);

        $product = product::create([
            'title' => $request['title'],
            'description' => $request['description'],
            'price' => $request['price'],
            'off_price' => !empty($request['off_price'])?$request['off_price']:null,
        ]);

        if ($request->has('images') && !empty($request->file('images'))) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $fileName = $this->uploadImage($image);
                $images[] = ['path'=>$fileName , 'product_id'=>$product->id];
            }
            FileUpload::insert($images);
        }

        $product->thumbnail = $product->images()->first()->path;
        $product->save();

        return redirect(route('product.index'))->with('message', 'محصول با موفقیت ایجاد شد!');


    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(product $product)
    {
        $p = product::find($product->id);
        return view('admin.products.editProducts', ['product' => $p]);
    }

    public function show(product $product)
    {
        return view('showProduct', compact('product'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, product $product)
    {

        //        value is in number format like 10,000 so:
        $request['price'] = str_replace(',', '', $request->price);
        $request['off_price'] = str_replace(',', '', $request->off_price);


        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'price' => 'required|numeric',
            'off_price' => 'nullable|numeric',
            'status' => 'required|string|in:Active,Inactive,Deleted',
            'images.*' => 'mimes:png,jpg,jpeg|max:2048',
        ]);


        if ($request->has('images') && !empty($request->file('images'))) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $fileName = $this->uploadImage($image);
                $images[] = ['path'=>$fileName , 'product_id'=>$product->id];
            }
            FileUpload::insert($images);
        }

        $thumb = $request->has('thumb') && !is_null($request->thumb) ? $request->thumb : $product->images()->first()->path;

        $product->update([
            'title' => $request['title'],
            'description' => $request['description'],
            'price' => $request['price'],
            'off_price' => !empty($request['off_price'])?$request['off_price']:null,
            'status' => $request['status'],
            'thumbnail' => $thumb
        ]);


        return redirect(route('product.index'))->with('message', 'محصول با موفقیت ویرایش شد!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, product $product)
    {
        $request->validate([
            'reason' => 'required|max:255'
        ]);

        $p = product::find($product->id);
        $p->status = 'Deleted';
        $p->delete_reason = $request->reason;
        $p->save();

        return redirect()->back()->with('message', 'محصول با موفقیت حذف شد!');
    }

    public function rate(Request $request, product $product)
    {
        $request->validate(['rate' => 'nullable|numeric|between:1,5']);

        $rate = Rate::where('product_id', '=', $product->id)->where('user_id', '=', $request->user()->id)->first();
        if (is_null($rate)) {
            Rate::create([
                'user_id' => $request->user()->id,
                'product_id' => $product->id,
                'rate' => $request->rate
            ]);
            $product->rate_count += 1;
        }
        $average = Rate::where('product_id', '=', $product->id)->avg('rate');
        $product->rate = $average;
        $product->save();

        return response()->json([
            'message' => 'رای شما ثبت شد!',
            'rate' => $average,
            'rateCount' => $product->rate_count
        ]);
    }


    public function bookmark(Request $request, product $product)
    {

        try {
            $request->user()->bookmarks()->attach([$product->id]);
            return response()->json(['message' => 'added.']);

        }catch(\Exception $e){
            if ($e->getCode() == 23000){
                $request->user()->bookmarks()->detach([$product->id]);
                return response()->json(['message'=>'deleted.']);
            }
        }



    }


    public function status(Request $request, product $product)
    {


    }


    public function uploadImage($file)
    {
        $fileName = $file->hashName();
        $file->storeAs('images/products', $fileName);
        return $fileName;
    }


    public function deleteImg()
    {
//        return response()->json(['message' => 'done']);
    }
}
