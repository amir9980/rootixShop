@extends('layouts.master')

@section('title','Show Product')

@section('content')

    <div class="card card-success col-md-12">
        <div class="card-header">
            <h3 class="card-title">ویرایش محصول "{{$product->title}}"</h3>
        </div>
        <!-- /.card-header -->


            <form action="{{route('product.update',$product)}}" method="post" enctype="multipart/form-data">
                <div class="card-body">

                        @csrf

                        <div class="form-group">
                            <label for="title">عنوان</label>
                            <input type="text" class="form-control" name="title" value="{{$product->title}}">
                        </div>

                        <!-- textarea -->
                        <div class="form-group">
                            <label for="description">توضیحات</label>
                            <textarea class="form-control" rows="3" name="description">{{$product->description}}</textarea>
                        </div>


                        <div class="row">
                            <div class="form-group col-md-12 col-lg-6">
                                <label for="price">قیمت</label>
                                <input class="form-control" type="number" name="price" value="{{$product->price}}">
                            </div>
                            <div class="form-group col-md-12 col-lg-6">
                                <label for="old_price">قیمت قبلی</label>
                                <input class="form-control" type="number" name="old_price" value="{{$product->old_price}}">
                            </div>
                        </div>



                        <!-- select -->
                        <div class="form-group">
                            <label for="status">وضعیت</label>
                            <select class="form-control" name="status">
                                <option value="1" @if($product->status==1)selected @endif>فعال</option>
                                <option value="2" @if($product->status==2)selected @endif>غیرفعال</option>
                                <option value="3" @if($product->status==3)selected @endif>حذف شده</option>
                            </select>
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
                    <button type="submit" class="btn btn-primary">ویرایش محصول</button>
                </div>


            </form>




    </div>

    {{--<div class="d-flex col-lg-3">--}}


        {{--<form action="{{route('product.update',$product)}}" method="post" enctype="multipart/form-data">--}}
            {{--@csrf--}}
            {{--<div class="form-group">--}}
                {{--<label for="title">title:</label>--}}
                {{--<input type="text" name="title" value="{{$product->title}}">--}}
            {{--</div>--}}
            {{--<div class="form-group">--}}
                {{--<label for="description">description:</label>--}}
                {{--<textarea name="description" cols="30" rows="10">{{$product->description}}</textarea>--}}
            {{--</div>--}}
            {{--<div class="form-group">--}}
                {{--<label for="price">price:</label>--}}
                {{--<input type="number" name="price" value="{{$product->price}}">--}}
            {{--</div>--}}
            {{--<div class="form-group">--}}
                {{--<label for="old_price">old price:</label>--}}
                {{--<input type="number" name="old_price" value="{{$product->old_price}}">--}}
            {{--</div>--}}
            {{--<div class="form-group">--}}
                {{--<label for="img">picture:</label>--}}
                {{--<input type="file" name="img">--}}
            {{--</div>--}}
            {{--<input type="submit" name="submit" value="update" class="btn btn-success">--}}
        {{--</form>--}}
    {{--</div>--}}


@endsection