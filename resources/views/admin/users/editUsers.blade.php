@extends('layouts.master')

@section('title','ویرایش کاربر')
@section('page title','ویرایش کاربر')

@section('content')

    <div class="card card-secondary col-md-12">
        <div class="card-header">
            <h3 class="card-title">ویرایش کاربر "{{$user->username}}"</h3>
        </div>
        <!-- /.card-header -->


        <form action="{{route('users.update',$user)}}" method="post" enctype="multipart/form-data">
            <div class="card-body">
                @method('PUT')
                @csrf

                <div class="form-group">
                    <label for="username">نام کاربری</label>
                    <input type="text" class="form-control" name="username" value="{{$user->username}}">
                </div>

                <div class="form-group">
                    <label for="new_password">رمز جدید</label>
                    <input type="password" class="form-control" name="new_password" >
                </div>

                <div class="form-group">
                    <label for="new_password_confirmation">تایید رمز جدید</label>
                    <input type="password" class="form-control" name="new_password_confirmation" >
                </div>

                <div class="form-group">
                    <label for="img">تصویر پروفایل</label>
                    <input type="file" class="form-control" name="img" >
                </div>



                <!-- select -->
                <div class="form-group">
                    <label for="role">نقش</label>
                    <select class="form-control" name="role">
                        <option value="user" @if($user->is_admin==0)selected @endif>کاربر</option>
                        <option value="admin" @if($user->is_admin==1)selected @endif>مدیر</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="status">وضعیت</label>
                    <select class="form-control" name="status">
                        <option value="Active" @if($user->status == 'Active')selected @endif>فعال</option>
                        <option value="Inactive" @if($user->status == 'Inactive')selected @endif>غیرفعال</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>اعتبار کیف پول:</label>
                    <span>{{number_format($user->wallet)}}&nbsp;تومان</span>
                </div>

                <div class="form-group">
                    <label for="wallet">اضافه کردن اعتبار</label>
                    <input type="text" name="wallet" class="form-control numberInput" placeholder="تومان">
                </div>

                {{--<div class="form-group">--}}
                    {{--<label for="img">تصویر</label>--}}
                    {{--<div class="input-group">--}}
                        {{--<div class="custom-file">--}}
                            {{--<input type="file" class="custom-file-input" name="img">--}}
                            {{--<label class="custom-file-label" for="img">انتخاب فایل</label>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}


                <!-- /.card-body -->
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">ویرایش کاربر</button>
            </div>


        </form>




    </div>



@endsection