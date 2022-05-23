@extends('layouts.master')

@section('title','شارژ')
@section('page title','شارژ کیف پول')

@section('content')

    <div class="container">
        <div class="row">
            <form action="{{route('payment.store',request()->user())}}" method="post">
                @csrf
                <div class="form-group">
                    <label for="value">مبلغ</label>
                    <input type="text" class="form-control numberInput" name="value" placeholder="تومان">
                </div>

                <button class="btn btn-sm btn-outline-info" type="submit">پرداخت</button>
            </form>
        </div>
    </div>

@endsection