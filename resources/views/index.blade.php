@extends('layouts.master')

@section('title', 'online shop')
@section('page title', 'محصولات')

@section('content')

    <div class="row justify-content-around">


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
                                <div class="col-md-2 my-2">
                                    <button class="btn-primary btn" type="submit">فیلتر</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>


        @if(count($products)>0)
        @foreach($products as $product)
            <div class="col-sm-6 col-md-4 col-lg-3 p-5">
            <div class="card ">
                <a href="#">
                    <img src="{{route('images.product',$product->img_src)}}" alt="تصویر محصول" class="card-img-top">
                </a>
                <div class="card-body">
                    <h5 class="card-title">{{$product->title}}</h5>
                    <p class="card-text">{{\Illuminate\Support\Str::limit($product->description,20)}}</p>
                    <p>&nbsp;{{number_format($product->price)}}&nbsp;<del>{{number_format($product->old_price)}}</del>
                        تومان
                    </p>
                </div>
                <div class="card-footer">
                    <div class="row ">
                        <div class="col-12 col-xl-6">
                            <a href="#" class=" btn btn-block btn-primary btn-sm mb-2 mb-xl-0">
                                <small>مشاهده محصول</small>
                            </a>
                        </div>
                        <div class="col-12 col-xl-6 ">
                            <form action="{{route('cart.store',$product)}}" method="post" class="">
                                @csrf

                                <button type="submit" name="addToCart" class="btn btn-block btn-warning btn-sm" onclick="this.disabled=true;this.innerHTML='<small>در حال انجام...</small>';this.form.submit();">
                                    <small>اضافه کردن</small>
                                </button>

                            </form>
                        </div>
                    </div>







                </div>
            </div>
            </div>

        @endforeach
    </div>

    <div class="row justify-content-center">
        {{$products->links()}}
    </div>

    @else
    <div class="row col-sm-12 justify-content-center">
        <h2>محصولی یافت نشد!</h2>
    </div>

    @endif


    </div>



@endsection
