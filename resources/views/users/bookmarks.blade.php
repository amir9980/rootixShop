@extends('layouts.master')

@section('title', 'محصولات ذخیره شده')
@section('page title', 'محصولات ذخیره شده')

@section('content')

    <div class="row justify-content-around">

        @if(count($products)>0)

            @foreach($products as $product)
                <div class="col-sm-6 col-md-4 col-lg-3 px-5 py-3">
                    <div class="card h-100">
                        <div class="card-header">
                            <a href="{{route('product.show',$product->id)}}">
                                <img src="{{route('images.product',$product->thumbnail)}}" alt="تصویر محصول"
                                     class="card-img-top img-rounded">
                            </a>
                        </div>
                        <div class="card-body position-relative">
                            <h5 class="card-title">{{$product->title}}</h5>
                            <p class="card-text">{{\Illuminate\Support\Str::limit($product->description,20)}}</p>
                            <p>&nbsp;{{number_format($product->price)}}&nbsp;<del
                                        class="text-danger">{{number_format($product->old_price)}}</del>
                                تومان
                            </p>
                        </div>
                        <div class="card-footer">
                            <div class="col-12">
                                <form action="{{route('cart.store',$product)}}" method="post" class="">
                                    @csrf
                                    <button type="submit" name="addToCart"
                                            class="btn btn-block btn-success btn-sm submitbtn">
                                        <small>اضافه کردن به سبد</small>
                                    </button>

                                </form>
                            </div>


                        </div>
                    </div>
                </div>

            @endforeach
    </div>


    @else
        <div class="row col-sm-12 justify-content-center">
            <h2>محصولی یافت نشد!</h2>
        </div>

    @endif




@endsection

