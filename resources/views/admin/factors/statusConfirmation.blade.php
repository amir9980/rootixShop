@extends('layouts.master')
@section('title','وضعیت سفارش')
@section('page title','وضعیت سفارش')

@section('content')

    <div class="container d-flex justify-content-center">
        <div class="card text-center w-50">
            <div class="card-header">
                <p>
                    @switch($shipping->status)
                        @case('delivered')
                        امکان تغییر وضعیت به علت اتمام سفارش وجود ندارد!
                        @break
                        @case('sent')
                        تغییر وضعیت از <strong>ارسال شده</strong> به <strong>تحویل داده شده</strong>
                        @break
                        @case('checked')
                        تغییر وضعیت از <strong>تایید شده</strong> به <strong>ارسال شده</strong>
                        @break
                        @case('ordered')
                        تغییر وضعیت از <strong>ثبت شده</strong> به <strong>تایید شده</strong>
                        @break

                    @endswitch
                </p>
            </div>
            <div class="card-body">
                @if($shipping->status != 'delivered')
                    <form action="{{route('admin.shipping.status',$shipping->id)}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="extraDescription">توضیحات اضافه</label>
                            <textarea class="form-control" name="extraDescription" cols="30" rows="5"></textarea>
                        </div>
                        @if($shipping->status == 'checked')
                            <div class="form-group">
                                <label for="postalTrackingCode">شماره پیگیری پستی</label>
                                <input class="form-control" type="text" name="postalTrackingCode">
                            </div>
                        @endif
                        <button class="btn btn-outline-primary" type="submit">تایید</button>
                    </form>
                @endif
            </div>
        </div>
    </div>

@endsection