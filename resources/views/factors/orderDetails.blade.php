@extends('layouts.master')

@section('title','مشخصات خریدار')
@section('page title','مشخصات خریدار')

@section('content')



    <div class="container">

        <div class="row">

            <div class="col-md-8">
                <h4>آدرس شما</h4>
                <form action="{{route('factor.store')}}" method="post" class="needs-validation">
                    @csrf
                    <div class="row form-group">
                        <div class="col-md-6">
                            <label for="firstName">نام</label>
                            <input type="text" class="form-control" name="firstName" value="{{$profile->first_name}}"/>
                            <div class="invalid-feedback">نام را وارد کنید</div>
                            <div class="valid-feedback">نام وارد شد</div>
                        </div>
                        <div class="col-md-6">
                            <label for="lastName">نام خانوادگی</label>
                            <input type="text" class="form-control" name="lastName" value="{{$profile->last_name}}"/>
                            <div class="invalid-feedback">نام خانوادگی را وارد کنید</div>
                            <div class="valid-feedback">نام خانوادگی وارد شد</div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>آدرس</label>
                        <input
                                class="form-control"
                                type="text"
                                name="address"
                                placeholder="مازندران, بابل"
                                value="{{$profile->address}}"
                        />
                        <div class="invalid-feedback">آدرس را وارد کنید</div>
                        <div class="valid-feedback">آدرس وارد شد</div>
                    </div>
                    <div class="row form-group">
                        <div class="col-md-6">
                            <label for="state" class="mt-xs-2 mt-md-0">استان</label>
                            <input
                                    type="text"
                                    name="state"
                                    class="form-control"
                                    placeholder="اصفهان"
                                    value="{{$profile->state}}"
                            />
                            <div class="invalid-feedback">استان را وارد کنید</div>
                            <div class="valid-feedback">استان وارد شد</div>
                        </div>
                        <div class="col-md-6">
                            <label for="city" class="mt-xs-2 mt-md-0">شهر</label>
                            <input
                                    type="text"
                                    name="city"
                                    class="form-control"
                                    placeholder="اصفهان"
                                    value="{{$profile->city}}"
                            />
                            <div class="invalid-feedback">شهر را وارد کنید</div>
                            <div class="valid-feedback">شهر وارد شد</div>
                        </div>
                    </div>
                    <hr class="my-4"/>

                    <h4 class="mb-4">نحوه پرداخت</h4>
                    <div class="form-check">
                        <input
                                class="form-check-input"
                                type="radio"
                                name="paymentMethod"
                                aria-valuemax="option1"
                                value="zarinpal"
                        />
                        <label for="paymentMethod" class="form-check-label"
                        >زرین پال</label
                        >
                    </div>
                    <div class="form-check">
                        <input
                                class="form-check-input"
                                type="radio"
                                name="paymentMethod"
                                aria-valuemax="option3"
                                value="asanpardakht"
                        />
                        <label for="paymentMethod" class="form-check-label"
                        >آسان پرداخت</label
                        >
                    </div>
                    <div class="form-check">
                        <input
                                class="form-check-input"
                                type="radio"
                                name="paymentMethod"
                                aria-valuemax="option3"
                                value="saderat"
                        />
                        <label for="paymentMethod" class="form-check-label">صادرات</label>
                    </div>
                    <div class="form-check">
                        <input
                                class="form-check-input"
                                type="radio"
                                name="paymentMethod"
                                aria-valuemax="option3"
                                value="cash"
                        />
                        <label for="paymentMethod" class="form-check-label">پرداخت نقدی</label>
                    </div>

                    <hr class="mb-4"/>
                        <input type="text" name="discount_token" class="form-control" placeholder="کد تخفیف"/>
                    <hr class="mb-4"/>

                    <button class="btn btn-lg btn-block btn-primary" type="submit">
                        ادامه و ثبت خرید
                    </button>
                </form>
            </div>

            <div class="col-md-4">
                <h4 class="d-flex justify-content-between my-4">
                    <span class="text-muted">سبد خرید شما</span>
                    <span class="badge badge-pill badge-warning pb-0">{{count($cart)}}</span>
                </h4>
                <ul class="list-group mb-3">
                    @foreach($cart as $item)
                        <li
                                class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <h6>{{$item->product->title}}</h6>
                                <small>{{$item->count}}&nbsp;عدد</small>
                            </div>
                            <span class="text-muted">{{number_format((float)$item->product->price)}}&nbsp;تومان</span>
                        </li>
                    @endforeach
                    {{--<li--}}
                    {{--class="list-group-item d-flex justify-content-between align-items-center bg-light text-success"--}}
                    {{-->--}}
                    {{--<div>--}}
                    {{--<h6>کد تخفیف</h6>--}}
                    {{--<small>EXAMPLECODE</small>--}}
                    {{--</div>--}}
                    {{--<span>-$12</span>--}}
                    {{--</li>--}}
                    <li
                            class="list-group-item d-flex justify-content-between align-items-center"
                    >
                        <span>جمع(تومان)</span>
                        <span class="text-muted">{{number_format((float)$total)}}</span>
                    </li>
                </ul>

            </div>
        </div>


    </div>


@endsection