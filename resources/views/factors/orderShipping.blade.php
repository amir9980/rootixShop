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
                        {{$shipping->firstWhere('type','ordered')->description}}
                    </div>

                </div>
            </div>

            <div class="col-md-3">
                <div class="card h-100">
                    <div class="card-header">
                        <h4>تایید سفارش</h4>
                    </div>
                    <div class="card-body">
                        @if($shipping->contains('type','checked'))
                            {{$shipping->firstWhere('type','checked')->description}}
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
                        @if($shipping->contains('type','sent'))
                            {{$shipping->firstWhere('type','sent')->description}}
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
                        @if($shipping->contains('type','delivered'))
                            {{$shipping->firstWhere('type','delivered')->description}}
                        @else
                            <p>موردی جهت نمایش وجود ندارد!</p>
                        @endif
                    </div>

                </div>
            </div>

        </div>

    </div>

@endsection
