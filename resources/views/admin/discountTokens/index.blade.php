@extends('layouts.master')

@section('title','کدهای تخفیف')
@section('page title','کدهای تخفیف')

@section('content')

    <div class="container">
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
                    <td>@if($token->user){{$token->user->username}}@endif</td>
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