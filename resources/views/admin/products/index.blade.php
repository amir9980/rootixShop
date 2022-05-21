@extends('layouts.master')

@section('title','محصولات')
@section('page title','مشاهده محصولات')

@section('content')

    <div class="col-12">

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">فیلتر</h4>
            </div>
            <div class="card-body">
                <form action="#" method="get">

                    <div class="row">
                        <label for="title">عنوان:</label>
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="title"
                                   value="{{request()->query('title')}}">
                        </div>
                        <label for="price">قیمت:</label>
                        <div class="col-md-2">
                            <div class="input-group">
                                <input type="number" class="form-control" placeholder="از" name="from_price"
                                       value="{{request()->query('from_price')}}">
                                <input type="number" class="form-control" placeholder="تا" name="to_price"
                                       value="{{request()->query('to_price')}}">
                            </div>
                        </div>
                        <label for="date">تاریخ:</label>
                        <div class="col-md-2">
                            <div class="input-group">

                                <input type="text" class="jalaliDatePicker form-control" placeholder="از"
                                       title="از" name="from_date"
                                       value="{{request()->query('from_date')}}">
                                <input type="text" class="jalaliDatePicker form-control" placeholder="تا"
                                       title="از" name="to_date"
                                       value="{{request()->query('to_date')}}">
                            </div>
                        </div>
                        <label for="status">وضعیت:</label>
                        <div class="col-md-2">
                            <select class="form-control" name="status">
                                <option value="">انتخاب کنید...</option>
                                <option value="1" @if(request()->query('status')==1) selected @endif>فعال
                                </option>
                                <option value="2" @if(request()->query('status')==2) selected @endif>غیرفعال
                                </option>
                                <option value="3" @if(request()->query('status')==3) selected @endif>حذف شده
                                </option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button class="btn-primary btn" type="submit">فیلتر</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>


        <div class="card">
            <div class="card-header">
                <h3 class="card-title">محصولات</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div id="example2_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12 col-md-6"></div>
                        <div class="col-sm-12 col-md-6"></div>
                    </div>


                    <div class="row">
                        <div class="col-sm-12">
                            <table id="example2" class="table table-bordered table-hover dataTable" role="grid">

                                <thead>
                                <tr role="row">
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                        aria-label="ردیف: activate to sort column ascending">ردیف
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                        aria-label="عنوان: activate to sort column ascending">عنوان
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                        aria-label="توضیحات: activate to sort column ascending">توضیحات
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                        aria-label="قیمت: activate to sort column ascending">قیمت
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                        aria-label="تاریخ ثبت: activate to sort column ascending">تاریخ ثبت
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                        aria-label=" وضعیت: activate to sort column ascending">وضعیت
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                        aria-label="عملیات: activate to sort column ascending">عملیات
                                    </th>
                                </tr>
                                </thead>
                                <tbody>

                                @if(count($products)>0)
                                    @foreach($products as $product)

                                        <tr role="row" class="even">
                                            <td class="sorting_1">@php $iteration+=1;echo $iteration; @endphp</td>
                                            <td class="sorting_1">{{$product->title}}</td>
                                            <td>{{ \Illuminate\Support\Str::limit($product->description,15) }}</td>
                                            <td>{{ number_format($product->price)}}&nbsp;تومان</td>
                                            <td>{{\Morilog\Jalali\Jalalian::forge($product->created_at)->format('%A, %d %B %y')}}</td>
                                            <td>
                                                @if($product->status == 1)
                                                    <span class="badge badge-success">فعال</span>
                                                @elseif($product->status == 2)
                                                    <span class="badge badge-primary">غیرفعال</span>
                                                @elseif($product->status == 3)
                                                    <span class="badge badge-danger">حذف شده</span>

                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{route('product.edit',$product->id)}}"
                                                   class="btn btn-sm btn-success"><i class="fa fa-edit d-block"></i>ویرایش
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
                                                        data-target="#{{$product->title.'DeleteModal'}}"><i
                                                            class="fa fa-remove d-block"></i>حذف
                                                </button>
                                            </td>

                                        </tr>


                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="{{$product->title.'DeleteModal'}}" tabindex="-1"
                                             role="dialog" aria-labelledby="DeleteModal" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLongTitle">حذف محصول
                                                            "{{$product->title}}"</h5>
                                                        <button type="button" class="close mr-auto ml-0"
                                                                data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form action="{{route('product.destroy',$product->id)}}"
                                                              method="post">
                                                            @csrf
                                                            <div class="form-group">
                                                                <label for="reason">دلیل حذف محصول:</label>
                                                                <input type="text" name="reason">
                                                            </div>
                                                            <input type="submit" class="btn btn-danger" name="sumbit"
                                                                   value="حذف">
                                                        </form>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>


                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6">محصولی یافت نشد!</td>
                                    </tr>
                                @endif

                                </tbody>

                                <tfoot>
                                <tr>
                                    <th rowspan="1" colspan="1">ردیف</th>
                                    <th rowspan="1" colspan="1">عنوان</th>
                                    <th rowspan="1" colspan="1">توضیحات</th>
                                    <th rowspan="1" colspan="1">قیمت</th>
                                    <th rowspan="1" colspan="1">تاریخ ثبت</th>
                                    <th rowspan="1" colspan="1">وضعیت</th>
                                    <th rowspan="1" colspan="1">عملیات</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                </div>
                <!-- /.card-body -->
            </div>

            <div class="d-flex card-footer justify-content-center">
                {{$products->links()}}
            </div>

        </div>


@endsection