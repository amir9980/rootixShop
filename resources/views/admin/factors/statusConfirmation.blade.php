@extends('layouts.master')
@section('title','وضعیت سفارش')
@section('page title','وضعیت سفارش')

@section('content')

    <div class="container d-flex justify-content-center">
        <div class="card text-center w-50">
            <div class="card-header">
                <p>
                    @if($shipping->contains('type','delivered'))
                        امکان تغییر وضعیت به علت اتمام سفارش وجود ندارد!

                    @elseif($shipping->contains('type','sent'))

                        تغییر وضعیت از <strong>ارسال شده</strong> به <strong>تحویل داده شده</strong>

                    @elseif($shipping->contains('type','checked'))
                        تغییر وضعیت از <strong>تایید شده</strong> به <strong>ارسال شده</strong>

                    @elseif($shipping->contains('type','ordered'))

                        تغییر وضعیت از <strong>ثبت شده</strong> به <strong>تایید شده</strong>

                    @endif
                </p>
            </div>
            <div class="card-body">
                <form action="{{route('admin.shipping.status',$shipping->first()->factor->id)}}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="extraDescription">توضیحات اضافه</label>
                        <textarea class="form-control" name="extraDescription" cols="30" rows="5"></textarea>
                    </div>
                    @if($shipping->count() == 2)
                        <div class="form-group">
                            <label for="postalTrackingCode">شماره پیگیری پستی</label>
                            <input class="form-control" type="text" name="postalTrackingCode">
                        </div>
                    @endif
                    <button class="btn btn-outline-primary" type="submit">تایید</button>
                </form>
            </div>
        </div>
    </div>

@endsection
