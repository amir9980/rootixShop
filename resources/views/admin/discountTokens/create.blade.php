@extends('layouts.master')

@section('title','ساخت کد تخفیف')
@section('page title','ساخت کد تخفیف')

@section('content')

    <div class="container">
        <form action="{{route('discountToken.store')}}" method="post">
            @csrf
            <div class="row">
                <div class="form-group col-md-6">
                    <label>دسترسی</label>
                    <select name="access" class="form-control" id="accessSelectBox">
                        <option selected>انتخاب کنید</option>
                        <option value="private">شخصی</option>
                        <option value="public">عمومی</option>
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label>آیدی کاربر</label>
                    <input class="form-control" type="number" name="user_id" id="userIdInput">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label >درصد تخفیف</label>
                    <input class="form-control" type="number" name="percentage" placeholder="%">
                </div>
                <div class="form-group col-md-6">
                    <label >تعداد مجاز استفاده</label>
                    <input class="form-control" type="number" name="usage_count">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-md-6">
                    <label >تاریخ شروع</label>
                    <input type="text" class="jalaliDatePicker form-control" placeholder="تاریخ شروع"
                           title="تاریخ شروع" name="start_date"
                           >
                </div>
                <div class="form-group col-md-6">
                    <label >تاریخ انقضا</label>
                    <input type="text" class="jalaliDatePicker form-control" placeholder="تاریخ انقضا"
                           title="تاریخ انقضا" name="expire_date"
                    >
                </div>
            </div>
                <div class="form-group">
                    <label >تعداد</label>
                    <input class="form-control" type="number" name="count">
                </div>

            <hr class="my-3">
            <button class="btn btn-block btn-primary" type="submit">ساخت</button>
        </form>
    </div>

@endsection