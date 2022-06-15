@extends('layouts.master')

@section('title','جشنواره های تخفیف')
@section('page title','جشنواره های تخفیف')

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
                <th>عنوان</th>
                <th>توضیحات</th>
                <th>درصد تخفیف</th>
                <th>تاریخ شروع</th>
                <th>تاریخ پایان</th>
                <th>وضعیت</th>
                <th>عملیات</th>

            </tr>
            @foreach($events as $event)
                <tr>
                    <td>@php $iteration+=1;echo $iteration; @endphp</td>
                    <td>{{$event->title}}</td>
                    <td>{{\Illuminate\Support\Str::limit($event->description,15)}}</td>
                    <td>{{$event->percentage}}</td>
                    <td>{{\Morilog\Jalali\Jalalian::forge($event->start_date)->format('%A, %d %B %y')}}</td>
                    <td>{{\Morilog\Jalali\Jalalian::forge($event->expire_date)->format('%A, %d %B %y')}}</td>
                    <td>@if($event->status=='Active') <span class="badge badge-success">فعال</span> @else <span class="badge badge-danger">غیرفعال</span> @endif</td>
                    <td>
                        <form action="{{route('discountEvent.destroy',$event->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" type="submit">حذف</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>

        <div class="d-flex card-footer justify-content-center">
            {{$events->links()}}
        </div>

    </div>

@endsection