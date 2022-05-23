@extends('layouts.master')

@section('title','Create Product')

@section('content')


    <div class="card card-success col-md-12">
        <div class="card-header">
            <h3 class="card-title">ایجاد محصول</h3>
        </div>
        <!-- /.card-header -->


        <form action="{{route('product.store')}}" method="post" enctype="multipart/form-data">
            <div class="card-body">

                @csrf

                <div class="form-group">
                    <label for="title">عنوان</label>
                    <input type="text" class="form-control" name="title" required>
                </div>

                <!-- textarea -->
                <div class="form-group">
                    <label for="description">توضیحات</label>
                    <textarea class="form-control" rows="3" name="description" placeholder="توضیحات محصول را وارد کنبد" required></textarea>
                </div>


                <div class="row">
                    <div class="form-group col-md-12 col-lg-6">
                        <label for="price">قیمت</label>
                        <input class="form-control numberInput" type="text" name="price" required placeholder="تومان">
                    </div>
                    <div class="form-group col-md-12 col-lg-6">
                        <label for="old_price">قیمت قبلی</label>
                        <input class="form-control numberInput" type="text" name="old_price" placeholder="تومان">
                    </div>
                </div>




                <div class="form-group">
                    <label for="img">تصویر</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="img">
                            <label class="custom-file-label" for="img">انتخاب فایل</label>
                        </div>
                    </div>
                </div>


                <!-- /.card-body -->
            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">ایجاد محصول</button>
            </div>


        </form>




    </div>


    {{--<form action="{{route('product.store')}}" method="POST" enctype="multipart/form-data">--}}
        {{--@csrf--}}
        {{--<div class="form-group">--}}
            {{--<label for="title">title:</label>--}}
            {{--<input type="text" name="title" required>--}}
        {{--</div>--}}
        {{--<div class="form-group">--}}
            {{--<label for="description">description:</label>--}}
            {{--<textarea name="description" cols="30" rows="10"></textarea>--}}
        {{--</div>--}}
        {{--<div class="form-group">--}}
            {{--<label for="price">price:</label>--}}
            {{--<input type="number" name="price" required>--}}
        {{--</div>--}}
        {{--<div class="form-group">--}}
            {{--<label for="old_price">old price:</label>--}}
            {{--<input type="number" name="old_price">--}}
        {{--</div>--}}
        {{--<div class="form-group">--}}
            {{--<label for="img">picture:</label>--}}
            {{--<input type="file" name="img">--}}
        {{--</div>--}}
        {{--<input type="submit" name="submit" value="store" class="btn btn-success">--}}
    {{--</form>--}}

    @endsection