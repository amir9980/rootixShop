@extends('layouts.master')

@section('title','سبد های خرید')
@section('page title','سبد های خرید')

@section('content')

    <div class="col-12">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">فیلتر</h4>
                    </div>
                    <div class="card-body">
                        <form action="#" method="get">

                            <div class="row">

                                <label for="from_price">قیمت از:</label>
                                <div class="col-md-2">
                                    <div class="input-group align-items-center">
                                        <input type="text" class="form-control numberInput" placeholder="از" name="from_price"
                                               value="{{number_format((float)request()->query('from_price'))}}">
                                        <label for="to_price">تا:</label>

                                        <input type="text" class="form-control numberInput" placeholder="تا" name="to_price"
                                               value="{{number_format((float)request()->query('to_price'))}}">
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
                                <label for="status">وضعیت پرداخت:</label>
                                <div class="col-md-2">
                                    <select class="form-control" name="status">
                                        <option value="">انتخاب کنید...</option>
                                        <option value="paid" @if(request()->query('status')=='paid') selected @endif>پرداخت شده
                                        </option>
                                        <option value="not_paid" @if(request()->query('status')=='not_paid') selected @endif>پرداحت نشده
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
            </div>
        </div>




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
                            <table id="example2" class="text-center table table-bordered table-striped table-hover dataTable" role="grid">

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

                                @if(count($factors)>0)
                                    @foreach($factors as $factor)

                                        <tr role="row" class="even">
                                            <td class="sorting_1">@php $iteration+=1;echo $iteration; @endphp</td>
                                            <td class="sorting_1">{{$factor->user->username}}</td>
                                            <td>{{\Morilog\Jalali\Jalalian::forge($factor->created_at)->format('%A, %d %B %y')}}</td>
                                            <td class="d-flex flex-column">
                                                <span>{{number_format($factor->total_price)}}&nbsp;تومان</span>

                                                @if(isset($factor->discountToken))<span class="badge badge-success">با احتساب {{$factor->discountToken->percentage}}&nbsp;درصد تخفیف</span>@endif
                                            <td>
                                                @if($factor->is_paid == 1)
                                                    <span class="badge badge-success">پرداخت شده</span>
                                                @else
                                                    <span class="badge badge-danger">پرداخت نشده</span>
                                                @endif
                                            </td>
                                            <td class="d-flex">
                                                <a href="{{route('factor.show',$factor->id)}}"
                                                   class="btn btn-sm btn-info"><i class="fa fa-list-ul d-block" aria-hidden="true"></i>مشاهده
                                                </a>

                                            </td>

                                        </tr>


                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="6">فاکتوری یافت نشد!</td>
                                    </tr>
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
                {{$factors->links()}}
            </div>

        </div>


@endsection