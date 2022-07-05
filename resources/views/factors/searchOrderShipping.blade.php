@extends('layouts.master')

@section('title','جستجوی سفارش')
@section('page title','جستجوی سفارش')

@section('content')

    <div class="container">

        <form action="{{route('factor.orderShipping')}}" method="POST">
            @csrf
            <div class="form-group">
                <label for="code">کد رهگیری</label>
                <input type="text" name="code" class="form-control">
                <button type="submit" class="btn btn-primary my-2">جستجو</button>
            </div>
        </form>
    </div>

    @endsection