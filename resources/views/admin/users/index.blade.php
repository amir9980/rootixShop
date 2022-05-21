@extends('layouts.master')

@section('title','کاربران')
@section('page title','مشاهده کاربران')

@section('content')

    <div class="col-12">

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">فیلتر</h4>
            </div>
            <div class="card-body">
                <form action="#" method="get">

                    <div class="row">

                        <label for="title">نام کاربری:</label>
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="username"
                                   value="{{request()->query('username')}}">
                        </div>

                        <label for="email">ایمیل:</label>
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="email"
                                   value="{{request()->query('email')}}">
                        </div>

                        <label for="role">نقش:</label>
                        <div class="col-md-2">
                            <select class="form-control" name="role">
                                <option value="">انتخاب کنید...</option>
                                <option value="admin" @if(request()->query('role')=='admin') selected @endif>مدیر
                                </option>
                                <option value="user" @if(request()->query('role')=='user') selected @endif>کاربر
                                </option>

                            </select>
                        </div>

                        <label for="date">تاریخ ثبت:</label>
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

                        <div class="col-md-2">
                            <button class="btn-primary btn" type="submit">فیلتر</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>


        <div class="card">
            <div class="card-header">
                <h3 class="card-title">کاربران</h3>
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
                                        aria-label="نام کاربری: activate to sort column ascending">نام کاربری
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                        aria-label="ایمیل: activate to sort column ascending">ایمیل
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                        aria-label="نقش: activate to sort column ascending">نقش
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                        aria-label="تاریخ ثبت: activate to sort column ascending">تاریخ ثبت
                                    </th>
                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1"
                                        aria-label="عملیات: activate to sort column ascending">عملیات
                                    </th>
                                </tr>
                                </thead>
                                <tbody>

                                @if(count($users)>0)
                                    @foreach($users as $user)

                                        <tr role="row" class="even">
                                            <td class="sorting_1">@php $iteration+=1;echo $iteration; @endphp</td>
                                            <td class="sorting_1">{{$user->username}}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @if($user->is_admin == 1)
                                                    <span class="badge badge-success">مدیر</span>
                                                @else
                                                    <span class="badge badge-primary">کاربر</span>


                                                @endif
                                            </td>
                                            <td>{{\Morilog\Jalali\Jalalian::forge($user->created_at)->format('%A, %d %B %y')}}</td>

                                            <td>
                                                <a href="{{route('users.edit',$user)}}"
                                                   class="btn btn-sm btn-success"><i class="fa fa-edit d-block"></i>ویرایش
                                                </a>
                                            </td>

                                        </tr>


                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="6">کاربری یافت نشد!</td>
                                    </tr>
                                @endif

                                </tbody>

                                <tfoot>
                                <tr>
                                    <th rowspan="1" colspan="1">نام کربری</th>
                                    <th rowspan="1" colspan="1">ایمیل</th>
                                    <th rowspan="1" colspan="1">نقش</th>
                                    <th rowspan="1" colspan="1">تاریخ ثبت</th>
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
                {{$users->links()}}
            </div>

        </div>


@endsection