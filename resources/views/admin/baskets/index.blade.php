@extends('layouts.master')

@section('title','سبد های خرید')
@section('page title','سبد های خرید')

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
                                        aria-label="کاربر: activate to sort column ascending">کاربر
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                        aria-label="تاریخ ثبت: activate to sort column ascending">تاریخ ثبت
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                        aria-label=" قیمت کل: activate to sort column ascending">قیمت کل
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

                                @if(count($baskets)>0)
                                    @foreach($baskets as $basket)

                                        <tr role="row" class="even">
                                            <td class="sorting_1">@php $iteration+=1;echo $iteration; @endphp</td>
                                            <td class="sorting_1">{{$basket->user->username}}</td>
                                            <td>{{\Morilog\Jalali\Jalalian::forge($basket->created_at)->format('%A, %d %B %y')}}</td>
                                            <td>{{$basket->total_price}}&nbsp;تومان</td>
                                            <td>
                                                @if($basket->is_paid == 1)
                                                    <span class="badge badge-success">پرداخت شده</span>
                                                @else
                                                    <span class="badge badge-danger">پرداخت نشده</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{route('basket.show',$basket->id)}}"
                                                   class="btn btn-sm btn-info"><i class="fa fa-list-ul d-block" aria-hidden="true"></i>مشاهده
                                                </a>

                                            </td>

                                        </tr>


                                    @endforeach

                                @endif

                                </tbody>

                                <tfoot>
                                <tr>
                                    <th rowspan="1" colspan="1">ردیف</th>
                                    <th rowspan="1" colspan="1">کاربر</th>
                                    <th rowspan="1" colspan="1">تاریخ ثبت</th>
                                    <th rowspan="1" colspan="1"> قیمت کل</th>
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
                {{$baskets->links()}}
            </div>

        </div>


@endsection