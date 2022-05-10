@extends('layouts.master')

@section('title', 'online shop')

@section('content')

    <div class="row">
    @foreach($products as $product)
        <div class="card col-sm-6 col-md-4 col-lg-3 mx-3">
            <a href="#">
            <img src="{{route('images',$product->img_src)}}" alt="تصویر محصول" class="card-img-top">
            </a>
            <div class="card-body">
                <h5 class="card-title">{{$product->title}}</h5>
                <p class="card-text">{{\Illuminate\Support\Str::limit($product->description,20)}}</p>
            </div>
            <div class="d-flex card-footer justify-content-around mb-2">
                <div class="col-sm-12 col-md-4">
                    <a href="#" class="btn btn-primary btn-sm "><small>مشاهده محصول</small></a>
                </div>
                <div class="col-sm-12 col-md-4">
                    <form action="{{route('cart.store',$product)}}" method="post">
                        @csrf
                        <button type="submit" name="addToCart" class="btn btn-warning btn-sm"><small>اضافه کردن به سبد</small></button>

                    </form>
                </div>


            </div>
        </div>

    @endforeach
    </div>



    @endsection
