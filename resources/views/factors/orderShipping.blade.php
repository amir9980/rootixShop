@extends('layouts.master')

@section('title','پیگیری سفارش')
@section('page title','پیگیری سفارش')

@section('content')

    <div class="container">

        <div class="row text-center">

            <div class="col-md-3">
                <div class="card h-100">
                    <div class="card-header">
                        <h4>ثبت سفارش</h4>
                    </div>
                    <div class="card-body">
                        {{$shipping->ordered_description}}
                    </div>

                </div>
            </div>

            <div class="col-md-3">
                <div class="card h-100">
                    <div class="card-header">
                        <h4>تایید سفارش</h4>
                    </div>
                    <div class="card-body">
                        {{$shipping->checked_description}}
                    </div>

                </div>
            </div>


        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-header">
                    <h4>ارسال سفارش</h4>
                </div>
                <div class="card-body">
                    {{$shipping->sent_description}}
                </div>

            </div>
        </div>

        <div class="col-md-3">
            <div class="card h-100">
                <div class="card-header">
                    <h4>تحویل سفارش</h4>
                </div>
                <div class="card-body">
                    {{$shipping->delivered_description}}
                </div>

            </div>
        </div>

        </div>

    </div>

@endsection