@extends('layouts.master')

@section('title','محصولات')

@section('content')

    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">محصولات</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div id="example2_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4"><div class="row"><div class="col-sm-12 col-md-6"></div><div class="col-sm-12 col-md-6"></div></div><div class="row"><div class="col-sm-12"><table id="example2" class="table table-bordered table-hover dataTable" role="grid">
                                <thead>
                                <tr role="row">
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="عنوان: activate to sort column ascending">عنوان</th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="توضیحات: activate to sort column ascending">توضیحات</th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="تاریخ ثبت: activate to sort column ascending">تاریخ ثبت</th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label=" وضعیت: activate to sort column ascending">وضعیت</th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="عملیات: activate to sort column ascending">عملیات</th>
                                </tr>
                                </thead>
                                <tbody>

                                @if(count($products)>0)

                                    @foreach($products as $product)

                                <tr role="row" class="even">
                                    <td class="sorting_1">{{$product->title}}</td>
                                    <td >{{ \Illuminate\Support\Str::limit($product->description,15) }}</td>
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
                                        <a href="{{route('product.edit',$product->id)}}" class="btn btn-sm btn-success" ><i class="fa fa-edit d-block"></i>ویرایش </a>
                                        <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#{{$product->title.'DeleteModal'}}"><i class="fa fa-remove d-block"></i>حذف</button>
                                    </td>

                                </tr>


                                <!-- Delete Modal -->
                                <div class="modal fade" id="{{$product->title.'DeleteModal'}}" tabindex="-1" role="dialog" aria-labelledby="DeleteModal" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLongTitle">حذف محصول "{{$product->title}}"</h5>
                                                <button type="button" class="close mr-auto ml-0" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="{{route('product.destroy',$product->id)}}" method="post">
                                                    @csrf
                                                    <div class="form-group">
                                                        <label for="reason">دلیل حذف محصول:</label>
                                                        <input type="text" name="reason">
                                                    </div>
                                                    <input type="submit" class="btn btn-danger" name="sumbit" value="حذف">
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                </div>


                                    @endforeach

                                    @endif

                                </tbody>

                                <tfoot>
                                <tr>
                                    <th rowspan="1" colspan="1">عنوان</th>
                                    <th rowspan="1" colspan="1">توضیحات</th>
                                    <th rowspan="1" colspan="1">تاریخ ثبت</th>
                                    <th rowspan="1" colspan="1">وضعیت</th>
                                    <th rowspan="1" colspan="1">عملیات</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12 col-md-5"></div>
                        <div class="col-sm-12 col-md-7">
                            <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                                <ul class="pagination">
                                    <li class="paginate_button page-item previous disabled" id="example2_previous">
                                        <a href="#" aria-controls="example2" data-dt-idx="0" tabindex="0" class="page-link">قبلی</a>
                                    </li>
                                    <li class="paginate_button page-item active">
                                        <a href="#" aria-controls="example2" data-dt-idx="1" tabindex="0" class="page-link">1</a>
                                    </li>
                                    <li class="paginate_button page-item ">
                                        <a href="#" aria-controls="example2" data-dt-idx="2" tabindex="0" class="page-link">2</a>
                                    </li>
                                    <li class="paginate_button page-item ">
                                        <a href="#" aria-controls="example2" data-dt-idx="3" tabindex="0" class="page-link">3</a>
                                    </li>
                                    <li class="paginate_button page-item ">
                                        <a href="#" aria-controls="example2" data-dt-idx="4" tabindex="0" class="page-link">4</a>
                                    </li>
                                    <li class="paginate_button page-item ">
                                        <a href="#" aria-controls="example2" data-dt-idx="5" tabindex="0" class="page-link">5</a>
                                    </li><li class="paginate_button page-item "><a href="#" aria-controls="example2" data-dt-idx="6" tabindex="0" class="page-link">6</a></li><li class="paginate_button page-item next" id="example2_next"><a href="#" aria-controls="example2" data-dt-idx="7" tabindex="0" class="page-link">بعدی</a></li></ul></div></div></div></div>
            </div>
            <!-- /.card-body -->
        </div>

    </div>


@endsection