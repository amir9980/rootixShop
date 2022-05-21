@extends('layouts.master')

@section('title','پروفایل')
@section('page title','پروفایل کاربری')

@section('content')

    <div class="container">
            <form action="{{route('users.profile.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="username">نام کاربری</label>
                    <input type="text" class="form-control" name="username" value="{{request()->user()->username}}">
                </div>

                <div class="form-group">
                    <label for="img">تصویر پروفایل</label>
                    <input type="file" class="form-control" name="img" >
                </div>
                <button class="btn btn-sm btn-outline-success" type="submit">ویرایش</button>
            </form>

    </div>

    @endsection