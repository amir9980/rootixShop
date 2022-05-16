@extends('layouts.master')

@section('title', 'online shop')
@section('page title', 'محصولات')

@section('content')

    <div class="row justify-content-around">


        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">فیلتر</h4>
                    </div>
                    <div class="card-body">
                        <form action="#" method="get">

                            <div class="row">
                                <label for="title">عنوان:</label>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" name="title"
                                           value="{{request()->query('title')}}">
                                </div>
                                <label for="price">قیمت:</label>
                                <div class="col-md-2">
                                    <div class="input-group">
                                        <input type="number" class="form-control" placeholder="از" name="from_price"
                                               value="{{request()->query('from_price')}}">
                                        <input type="number" class="form-control" placeholder="تا" name="to_price"
                                               value="{{request()->query('to_price')}}">
                                    </div>
                                </div>
                                <label for="date">تاریخ:</label>
                                <div class="col-md-2">
                                    <div class="input-group">

                                        <input type="text" class="jalaliDatePicker form-control" placeholder="از"
                                               title="از" name="from_date"
                                               value="{{request()->query('from_date')}}">
                                        <input type="text" class="jalaliDatePicker form-control" placeholder="تا"
                                               title="از" name="to_date"
                                               value="{{request()->query('to_date')}}">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button class="btn-primary btn" type="submit">فیلتر</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>


        @foreach($products as $product)

            <div class="card col-sm-6 col-md-4 col-lg-3 m-2">
                <a href="#">
                    <img src="{{route('images',$product->img_src)}}" alt="تصویر محصول" class="card-img-top">
                </a>
                <div class="card-body">
                    <h5 class="card-title">{{$product->title}}</h5>
                    <p class="card-text">{{\Illuminate\Support\Str::limit($product->description,20)}}</p>
                    <p>&nbsp;{{$product->price}}&nbsp;<del>{{$product->old_price}}</del>
                        تومان
                    </p>
                </div>
                <div class="d-flex card-footer justify-content-around mb-2">
                    <div class="col-sm-12 col-md-4">
                        <a href="#" class="btn btn-primary btn-sm ">
                            <small>مشاهده محصول</small>
                        </a>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <form action="{{route('cart.store',$product)}}" method="post">
                            @csrf

                            <button type="submit" name="addToCart" class="btn btn-warning btn-sm">
                                <small>اضافه کردن به سبد</small>
                            </button>

                        </form>
                    </div>


                </div>
            </div>

        @endforeach
    </div>

    <div class="row justify-content-center">
        {{$products->links()}}
    </div>




@endsection
