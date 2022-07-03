@extends('layouts.master')

@section('title','نظرات')
@section('page title','نظرات')

@section('content')

    <div class="container">
        <table class="table table-bordered table-striped">
            <thead>
            <th>ردیف</th>
            <th>کاربر</th>
            <th>محصول</th>
            <th>متن</th>
            <th>تاریخ ثبت</th>
            <th>وضعیت</th>
            <th>عملیات</th>
            </thead>
            @if(count($comments) > 0)
                @foreach($comments as $comment)
                    @php $iteration+=1; @endphp
                    <tr>
                        <td>{{$iteration}}</td>
                        <td>{{$comment->user->username}}</td>
                        <td><a href="{{route('product.show',$comment->product->id)}}">{{$comment->product->title}}</a></td>
                        <td>{{\Illuminate\Support\Str::limit($comment->body,15)}}</td>
                        <td>{{\Morilog\Jalali\Jalalian::forge($comment->created_at)->format('%A, %d %B %y')}}</td>
                        <td>@if($comment->status=='inactive') <span class="badge badge-danger">غیرفعال</span> @else  <span class="badge badge-success">فعال</span> @endif </td>
                        <td>
                            <form action="{{route('comment.destroy',$comment)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-outline-primary" data-toggle="modal" data-target="#viewComment">
                                    مشاهده
                                </button>
                                <button class="btn btn-sm btn-outline-danger" type="submit">حذف</button>
                            </form>

                            <div class="modal fade" id="viewComment" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close " data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                            <h5 class="modal-title" id="exampleModalLongTitle">{{$comment->user->username}}</h5>

                                        </div>
                                        <div class="modal-body">
                                            {{$comment->body}}
                                        </div>
                                        <div class="modal-footer justify-content-start">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">بستن</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </td>
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