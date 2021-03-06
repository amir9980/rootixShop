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

                        <div class="row align-items-center">
                            <label for="title">عنوان:</label>
                            <div class="col-md-2">
                                <input type="text" class="form-control" name="title"
                                       value="{{request()->query('title')}}">
                            </div>
                            <label for="from_price">قیمت:</label>
                            <div class="col-md-2">
                                <div class="input-group align-items-center">
                                    <input type="text" class="form-control numberInput" placeholder="از"
                                           name="from_price"
                                           value="{{number_format((float)request()->query('from_price'))}}">

                                    <input type="text" class="form-control numberInput" placeholder="تا" name="to_price"
                                           value="{{number_format((float)request()->query('to_price'))}}">
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

    <div class="row justify-content-center">
        {{$products->links()}}
    </div>

    @else
        <div class="row col-sm-12 justify-content-center">
            <h2>محصولی یافت نشد!</h2>
        </div>

    @endif

@endsection

