@extends('layouts.master')

@section('title','ساخت جشنواره تخفیف')
@section('page title','ساخت جشنواره تخفیف')

@section('content')

    <div class="container">
        <form action="{{route('discountEvent.store')}}" method="post">
            @csrf

            <div class="row">
                <div class="form-group col-md-3">
                    <label >عنوان</label>
                    <input class="form-control" type="text" name="title" value="{{old('title')}}">
                </div>
                <div class="form-group col-md-7">
                    <label >توضیحات</label>
                    <input class="form-control" type="text" name="description" value="{{old('description')}}">
                </div>
                <div class="form-group col-md-2">
                    <label >درصد تخفیف</label>
                    <input class="form-control" type="number" name="percentage" placeholder="%" >
                </div>

            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label >تاریخ شروع</label>
                    <input type="text" class="jalaliDatePicker form-control" placeholder="تاریخ شروع"
                           title="تاریخ شروع" name="start_date" value="{{old('start_date')}}"
                    >
                </div>
                <div class="form-group col-md-6">
                    <label >تاریخ انقضا</label>
                    <input type="text" class="jalaliDatePicker form-control" placeholder="تاریخ انقضا"
                           title="تاریخ انقضا" name="expire_date" value="{{old('expire_date')}}"
                    >
                </div>
            </div>


            <hr class="my-3">
            <button class="btn btn-block btn-primary" type="submit">ساخت</button>
        </form>
    </div>

@endsection