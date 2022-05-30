@extends('layouts.master')

@section('title','جزئیات خرید')
@section('page title','جزئیات خرید')

@section('content')

<div class="container">
    <form action="{{route('factor.order')}}" method="post" id="confirmDetailsForm">
        @csrf
        <table class="table table-bordered table-striped text-center">
            <tr>
                <th>نام محصول</th>
                <th>توضیحات</th>
                <th>قیمت</th>
                <th>تعداد</th>
            </tr>

            @foreach($cart as $item)
                <tr>
                    <td><span>{{$item->product->title}}</span></td>
                    <td><span>{{\Illuminate\Support\Str::limit($item->product->description,15)}}</span></td>
                    <td>            <span>{{number_format((float)$item->product->price)}}&nbsp;تومان</span>
                    </td>
                    <td>
                        <div class="d-flex justify-content-around align-items-center">
                                <button class="btn btn-sm btn-outline-danger pb-0 decreaseButton" type="button"><i class="fa fa-minus" aria-hidden="true"></i>
                                </button>
                            <input type="hidden" name="counter[{{$loop->iteration-1}}][id]" value="{{$item->id}}">
                            <input type="hidden" name="counter[{{$loop->iteration-1}}][count]" value="{{$item->count}}" class="productCount">
                            <span>{{$item->count}}</span>

                                <button class="btn btn-sm btn-outline-success pb-0 increaseButton" type="button"><i class="fa fa-plus" aria-hidden="true"></i>
                                </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            <tr>
                <td colspan="4"><strong>مجموع:&nbsp;{{number_format((float)$total)}}&nbsp;تومان</strong></td>
            </tr>
        </table>


    <p><button type="submit" class="btn btn-block btn-success">ثبت و ادامه</button></p>
    </form>
</div>




@endsection