@extends('layouts.master')

@section('title','جزئیات سبد خرید')
@section('page title','جزئیات سبد خرید')

@section('content')

    <div class="col-12">


        <div class="card">
            <div class="card-header">
                <h3 class="card-title">سبدهای خرید</h3>
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
                                        aria-label="محصول: activate to sort column ascending">محصول
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                        aria-label=" تعداد: activate to sort column ascending">تعداد
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                        aria-label=" قیمت: activate to sort column ascending">قیمت
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                        aria-label="تاریخ ثبت: activate to sort column ascending">تاریخ ثبت
                                    </th>

                                </tr>
                                </thead>
                                <tbody>

                                @if(count($products)>0)
                                    @foreach($products as $product)

                                        <tr role="row" class="even">
                                            <td class="sorting_1">@php $iteration+=1;echo $iteration; @endphp</td>
                                            <td class="sorting_1">{{$product->product->title}}</td>
                                            <td class="sorting_1">{{$product->count}}</td>
                                            <td class="sorting_1">{{number_format($product->product->price)}}</td>
                                            <td>{{\Morilog\Jalali\Jalalian::forge($product->created_at)->format('%A, %d %B %y')}}</td>


                                        </tr>


                                    @endforeach

                                @endif

                                </tbody>

                            </table>
                        </div>
                    </div>

                </div>
                <!-- /.card-body -->
            </div>


        </div>


@endsection