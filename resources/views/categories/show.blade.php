@extends('layouts.master')

@section('title',$category->title)
@section('page title',$category->title)

@section('content')

    <div class="container">
        <div class="row">
            @foreach($category->products as $product)
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
                            <p>

                                @if(!is_null(($product->off_price )))
                                    <del class="text-danger">{{number_format($product->off_price)}}</del>
                                @endif
                                &nbsp;{{number_format($product->price)}}
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
    </div>

@endsection
