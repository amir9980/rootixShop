@extends('layouts.master')

@section('title','کدهای تخفیف')
@section('page title','کدهای تخفیف')

@section('content')

    <div class="container">

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">فیلتر</h4>
            </div>
            <div class="card-body">
                <form action="#" method="get">

                    <div class="row">
                        <label>درصد تخفیف:</label>
                        <div class="col-md-2">

                                <input type="number" class="form-control" name="percentage" value="{{request()->query('percentage')}}">

                        </div>
                        <label>تاریخ:</label>
                        <div class="col-md-2">
                            <div class="input-group">

                                <input type="text" class="jalaliDatePicker form-control" placeholder="شروع"
                                       title="از" name="start_date"
                                       value="{{request()->query('start_date')}}">
                                <input type="text" class="jalaliDatePicker form-control" placeholder="انقضا"
                                       title="از" name="expire_date"
                                       value="{{request()->query('expire_date')}}">
                            </div>
                        </div>
                        <label for="access">دسترسی:</label>
                        <div class="col-md-2">
                            <select class="form-control" name="access">
                                <option value="">انتخاب کنید</option>
                                <option value="public" @if(request()->query('access')=='public') selected @endif>عمومی</option>
                                <option value="private" @if(request()->query('access')=='private') selected @endif>خصوصی</option>

                            </select>
                        </div>
                        <div class="col-md-2">
                            <button class="btn-primary btn" type="submit">فیلتر</button>
                        </div>
                    </div>
                </form>
            </div>

        </div>


        <table class="table table-bordered table-striped text-center">

            <tr>
                <th>
                    ردیف
                </th>
                <th>
                    دسترسی
                </th>
                <th>کاربر</th>
                <th>کد</th>
                <th>درصد تخفیف</th>
                <th>تاریخ شروع</th>
                <th>تاریخ پایان</th>

            </tr>
            @foreach($tokens as $token)
                <tr>
                    <td>@php $iteration+=1;echo $iteration; @endphp</td>
                    <td>@if($token->access=='public')عمومی@elseخصوصی @endif</td>
                    <td>@if($token->user){{$token->user->username}}@else همه کاربران @endif</td>
                    <td>{{$token->token}}</td>
                    <td>{{$token->percentage}}</td>
                    <td>{{\Morilog\Jalali\Jalalian::forge($token->start_date)->format('%A, %d %B %y')}}</td>
                    <td>{{\Morilog\Jalali\Jalalian::forge($token->expire_date)->format('%A, %d %B %y')}}</td>
                </tr>
                @endforeach
        </table>

        <div class="d-flex card-footer justify-content-center">
            {{$tokens->links()}}
        </div>

    </div>

    @endsection