@extends('layouts.master')

@section('title','پروفایل')
@section('page title','پروفایل کاربری')

@section('content')

    <div class="container">
        <form action="{{route('profile.update')}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="username">نام کاربری</label>
                <input type="text" class="form-control" name="username" value="{{\Illuminate\Support\Facades\Auth::user()->username}}">
            </div>
            <div class="form-group">
                <label for="address">تصویر پروفایل</label>
                <input type="file" class="form-control" name="img">
            </div>
            <button class="btn btn-sm btn-outline-success" type="submit">ویرایش</button>
        </form>

    </div>

@endsection