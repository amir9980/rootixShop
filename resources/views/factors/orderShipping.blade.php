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
                        @if($shipping->checked_description)
                            {{$shipping->checked_description}}
                        @else
                            <p>موردی جهت نمایش وجود ندارد!</p>
                        @endif
                    </div>

                </div>
            </div>


            <div class="col-md-3">
                <div class="card h-100">
                    <div class="card-header">
                        <h4>ارسال سفارش</h4>
                    </div>
                    <div class="card-body">
                        @if($shipping->sent_description)
                            {{$shipping->sent_description}}
                        @else
                            <p>موردی جهت نمایش وجود ندارد!</p>
                        @endif
                    </div>

                </div>
            </div>

            <div class="col-md-3">
                <div class="card h-100">
                    <div class="card-header">
                        <h4>تحویل سفارش</h4>
                    </div>
                    <div class="card-body">
                        @if($shipping->delivered_description)
                            {{$shipping->delivered_description}}
                        @else
                            <p>موردی جهت نمایش وجود ندارد!</p>
                        @endif
                    </div>

                </div>
            </div>

        </div>

    </div>

@endsection
