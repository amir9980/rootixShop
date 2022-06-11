@extends('layouts.master')

@section('title','پروفایل')
@section('page title','پروفایل کاربری')

@section('content')

    <div class="container">
        <form action="{{route('profile.update')}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="first_name">نام</label>
                    <input type="text" class="form-control" name="first_name" value="{{old('first_name')}}">
                </div>
                <div class="form-group col-md-6">
                    <label for="last_name">نام خانوادگی</label>
                    <input type="text" class="form-control" name="last_name" value="{{old('last_name')}}">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="state">استان</label>
                    <input type="text" class="form-control" name="state" value="{{old('state')}}">
                </div>
                <div class="form-group col-md-6">
                    <label for="city">شهر</label>
                    <input type="text" class="form-control" name="city" value="{{old('city')}}">
                </div>
            </div>
            <div class="form-group">
                <label for="address">آدرس</label>
                <input type="text" class="form-control" name="address" value="{{old('address')}}">
            </div>
            <button class="btn btn-sm btn-outline-success" type="submit">ویرایش</button>
        </form>

    </div>

@endsection