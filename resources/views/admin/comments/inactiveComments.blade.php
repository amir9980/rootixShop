@extends('layouts.master')

@section('title','نظرات تایید نشده')
@section('page title','نظرات تایید نشده')

@section('content')

    <div class="container">
        <table class="table table-bordered table-striped">
            <thead>
            <th>ردیف</th>
            <th>کاربر</th>
            <th>متن</th>
            <th>تاریخ ثبت</th>
            <th>وضعیت</th>
            </thead>
            @if(count($comments) > 0)
                @foreach($comments as $comment)
                    @php $iteration+=1; @endphp
                    <tr>
                        <td>{{$iteration}}</td>
                        <td>{{$comment->user->username}}</td>
                        <td>{{\Illuminate\Support\Str::limit($comment->body,15)}}</td>
                        <td>{{\Morilog\Jalali\Jalalian::forge($comment->created_at)->format('%A, %d %B %y')}}</td>
                        <td>@if($comment->status=='inactive') <span class="badge badge-danger">غیرفعال</span> @endif</td>
                    </tr>


                    @endforeach
            @else
                <tr >
                    <td colspan="5">نظری یافت نشد!</td>
                </tr>
            @endif
        </table>

        <div class="row justify-content-center">
            {{$comments->links()}}
        </div>




    </div>

@endsection