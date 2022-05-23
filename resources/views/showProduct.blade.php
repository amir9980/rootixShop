@extends('layouts.master')

@section('title', 'مشاهده محصول')
@section('page title', 'مشاهده محصول')

@section('content')
    <div class="container">
        <div class="row">
            <div class="card col-12 text-center">
                <div class="card-header">
                    <h5>{{$product->title}}</h5>
                    <img src="{{route('images.product',$product->img_src)}}" alt="تصویر محصول" width="50%">
                </div>
                <div class="card-body">
                    <p>&nbsp;{{number_format($product->price)}}&nbsp;<del>{{number_format($product->old_price)}}</del>
                        تومان
                    </p>
                    <p class="lead">{{$product->description}}</p>
                </div>
                @auth
                <div class="card-footer">
                    <form action="{{route('cart.store',$product)}}" method="post" class="">
                        @csrf

                        <button type="submit" name="addToCart" class="btn btn-warning " onclick="this.disabled=true;this.innerHTML='<small>در حال انجام...</small>';this.form.submit();">
                            <small>اضافه کردن به سبد خرید</small>
                        </button>

                    </form>

                </div>
                    @endauth


            </div>
        </div>
    </div>



@endsection
